<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tools\Commands;

use Bitrix24\SDK\Services\CRM\Contact\Service\Contact;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\BulkItemsReader\BulkItemsReaderBuilder;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Psr\Log\LoggerInterface;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\Console\Helper\ProgressBar;


#[AsCommand(
    name: 'b24:etl:copy-property-values',
    description: 'copy property values from one property to another',
    hidden: false
)]
class CopyPropertyValues extends Command
{
    protected LoggerInterface $logger;
    protected const WEBHOOK_URL = 'webhook';
    protected const SOURCE_PROPERTY = 'source';
    protected const DESTINATION_PROPERTY = 'destination';
    protected const ENTITY_TYPE_PROPERTY = 'entity_type';
    private array $supportedEntityTypes = [
        'contact',
        'company',
        'lead',
        'deal',
    ];

    public function __construct(LoggerInterface $logger)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * @param OutputInterface $output
     * @param Contact $service
     * @param array $updateCmd
     * @return void
     * @throws BaseException
     */
    public function updateItems(OutputInterface $output, Contact $service, array $updateCmd): void
    {
        $progressBar = new ProgressBar($output, count($updateCmd));
        $progressBar->start();

        foreach ($service->batch->update($updateCmd) as $item) {
            $this->logger->debug('updateItems', [
                'isUpdated' => $item->isSuccess() === true ? 'Y' : 'N',
            ]);
            $progressBar->advance();
        }

        $progressBar->finish();
    }


    public function createUpdateCommand(array $data, string $b24SourceProp, string $b24DestinationProp): array
    {
        $updateCmd = [];
        foreach ($data as $id => $item) {
            $updateCmd[$id] = [
                'fields' => [
                    $b24DestinationProp =>$item[$b24SourceProp],
                ]
            ];
        }

        return $updateCmd;
    }

    /**
     * @param OutputInterface $output
     * @param Contact $service
     * @param array $filter
     * @param string $b24SourceProp
     * @param string $b24DestinationProp
     * @return array
     * @throws BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     * @throws \Bitrix24\SDK\Services\CRM\Userfield\Exceptions\UserfieldNotFoundException
     */
    public function readDataFromProperties(OutputInterface $output, Contact $service, array $filter, string $b24SourceProp, string $b24DestinationProp): array
    {
        $progressBar = new ProgressBar($output, $service->countByFilter($filter));
        $progressBar->start();

        $data = [];
        foreach ($service->batch->list([], $filter, ['ID', $b24SourceProp, $b24DestinationProp]) as $id => $item) {
            $data[$item->ID] = [
                $b24SourceProp => (string)$item->getUserfieldByFieldName($b24SourceProp),
                $b24DestinationProp => (string)$item->getUserfieldByFieldName($b24DestinationProp),
            ];
            $progressBar->advance();
        }
        $progressBar->finish();

        return $data;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('copy property values from one property to another')
            ->setHelp('copy property values from one property to another in same portal')
            ->addOption(
                self::WEBHOOK_URL,
                null,
                InputOption::VALUE_REQUIRED,
                'bitrix24 incoming webhook',
                ''
            )
            ->addOption(
                self::SOURCE_PROPERTY,
                null,
                InputOption::VALUE_REQUIRED,
                'source property id',

            )
            ->addOption(
                self::DESTINATION_PROPERTY,
                null,
                InputOption::VALUE_REQUIRED,
                'destination property id',
            )
            ->addOption(
                self::ENTITY_TYPE_PROPERTY,
                null,
                InputOption::VALUE_REQUIRED,
                'entity type: contact, company, lead, deal',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->debug('CopyPropertyValues.start');

        $b24Webhook = (string)$input->getOption(self::WEBHOOK_URL);
        $b24EntityType = (string)$input->getOption(self::ENTITY_TYPE_PROPERTY);
        $b24SourceProp = (string)$input->getOption(self::SOURCE_PROPERTY);
        $b24DestinationProp = (string)$input->getOption(self::DESTINATION_PROPERTY);

        $io = new SymfonyStyle($input, $output);
        $output->writeln(
            [
                '<info>Copy property values from one property to another</info>',
                '<info>========================</info>',
                sprintf('webhook url: %s', $b24Webhook),
                sprintf('entity type: %s', $b24EntityType),
                sprintf('source property: %s', $b24SourceProp),
                sprintf('destination property: %s', $b24DestinationProp),
            ]
        );

        try {
            if ($b24Webhook === '') {
                throw new InvalidArgumentException('webhook url is empty');
            }
            if ($b24EntityType === '') {
                throw new InvalidArgumentException('entity_type is empty');
            }
            if ($b24SourceProp === '') {
                throw new InvalidArgumentException('source property is empty');
            }
            if ($b24DestinationProp === '') {
                throw new InvalidArgumentException('destination property is empty');
            }
            $sb = (new ServiceBuilderFactory(new EventDispatcher(), $this->logger))->initFromWebhook($b24Webhook);
            if (!in_array($b24EntityType, $this->supportedEntityTypes, true)) {
                throw new InvalidArgumentException(sprintf('entity type %s is not supported', $b24EntityType));
            }

            $service = null;
            switch ($b24EntityType) {
                case 'contact':
                    $fields = $sb->getCRMScope()->contact()->fields();
                    $service = $sb->getCRMScope()->contact();
                    break;
                case 'company':
                case 'lead':
                case 'deal':
                default:
                    throw new InvalidArgumentException(sprintf('unsupported entity type %s', $b24EntityType));
            }

            if (!array_key_exists($b24SourceProp, $fields->getFieldsDescription())) {
                throw new InvalidArgumentException(sprintf('source property «%s» is not found in entity %s', $b24SourceProp, $b24EntityType));
            }
            if (!array_key_exists($b24DestinationProp, $fields->getFieldsDescription())) {
                throw new InvalidArgumentException(sprintf('destination property «%s» is not found in entity %s', $b24DestinationProp, $b24EntityType));
            }

            // количество элементов c заполненным полем источником
            // количество элементов с заполненным полем назначения
            // количество элементов у которых заполнено ОБА поля
            $totalElementsCnt = $service->countByFilter();
            $elementsWithFilledSourceProp = $service->countByFilter([sprintf('!%s', $b24SourceProp) => null]);
            $elementsWithoutFilledSourceProp = $service->countByFilter([sprintf('%s', $b24SourceProp) => null]);
            $elementsWithFilledDestinationProp = $service->countByFilter([sprintf('!%s', $b24DestinationProp) => null]);
            $elementsWithoutFilledDestinationProp = $service->countByFilter([sprintf('%s', $b24DestinationProp) => null]);

            $io->info(
                [
                    '',
                    sprintf('total elements count:  %s ', $totalElementsCnt),
                    sprintf('elements with filled source property:  %s ', $elementsWithFilledSourceProp),
                    sprintf('elements without filled source property:  %s ', $elementsWithoutFilledSourceProp),
                    sprintf('elements with filled destination property:  %s ', $elementsWithFilledDestinationProp),
                    sprintf('elements without filled destination property:  %s ', $elementsWithoutFilledDestinationProp)
                ]
            );
            $io->info('read data from bitrix24...');
            // read data from source and destinations properties
            $dataFromProperties = $this->readDataFromProperties($output, $service, [
                sprintf('!%s', $b24SourceProp) => ''
            ], $b24SourceProp, $b24DestinationProp);

            // exclude items with filled destination property
            $dataToCopy = [];
            $conflictData = [];
            foreach ($dataFromProperties as $id => $item) {
                // pass items with copied values
                if ($item[$b24SourceProp] === $item[$b24DestinationProp]) {
                    continue;
                }

                // filter conflict items
                if($item[$b24DestinationProp] !== '') {
                    $conflictData[$id] = $item;
                }
                // filter items to copy
                if($item[$b24DestinationProp] === '') {
                    $dataToCopy[$id] = $item;
                }
            }
            $io->newLine();
            $io->warning([
                '',
                sprintf('conflict items count: %s', count($conflictData)),
                sprintf('problem id: %s', implode(', ', array_keys($conflictData))),
            ]);

            $io->info([
                '',
                sprintf('items to copy count: %s', count($dataToCopy))
            ]);

            // build update command
            $updateCmd = $this->createUpdateCommand($dataToCopy, $b24SourceProp, $b24DestinationProp);

            // update items
            $this->updateItems($output, $service, $updateCmd);

            $io->success('all items updated');
        } catch (BaseException $exception) {
            $io = new SymfonyStyle($input, $output);
            $io->caution(sprintf('error message: %s', $exception->getMessage()));
            $io->text(
                $exception->getTraceAsString()
            );
        } catch (\Throwable $exception) {
            $io = new SymfonyStyle($input, $output);
            $io->caution('unknown error');
            $io->text(
                [
                    sprintf('%s', $exception->getMessage()),
                ]
            );
        }
        $this->logger->debug('CopyPropertyValues.finish');

        return Command::SUCCESS;
    }
}