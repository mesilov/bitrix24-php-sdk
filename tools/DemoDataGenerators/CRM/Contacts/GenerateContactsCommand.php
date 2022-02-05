<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tools\DemoDataGenerators\CRM\Contacts;

use Bitrix24\SDK\Core\Batch;
use Bitrix24\SDK\Core\BulkItemsReader\BulkItemsReaderBuilder;
use Bitrix24\SDK\Core\CoreBuilder;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Services\ServiceBuilder;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GenerateContactsCommand
 *
 * @package Bitrix24\SDK\Tools\DemoDataGenerators\CRM\Contacts
 */
class GenerateContactsCommand extends Command
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;
    /**
     * @var string
     */
    protected static $defaultName = 'generate:contacts';
    protected const CONTACTS_COUNT = 'count';
    protected const WEBHOOK_URL = 'webhook';

    /**
     * GenerateContactsCommand constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * настройки
     */
    protected function configure(): void
    {
        $this
            ->setDescription('generate contacts')
            ->setHelp('generate demo-data contacts in CRM')
            ->addOption(
                self::WEBHOOK_URL,
                null,
                InputOption::VALUE_REQUIRED,
                'bitrix24 incoming webhook',
                ''
            )
            ->addOption(
                self::CONTACTS_COUNT,
                null,
                InputOption::VALUE_REQUIRED,
                'contacts count',
                1
            );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $b24Webhook = (string)$input->getOption(self::WEBHOOK_URL);
        if ($b24Webhook === '') {
            throw new InvalidArgumentException(sprintf('option %s not found, you must set this option', self::WEBHOOK_URL));
        }
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->debug('GenerateContactsCommand.start');

        $contactsCount = (int)$input->getOption(self::CONTACTS_COUNT);
        $b24Webhook = (string)$input->getOption(self::WEBHOOK_URL);
        $io = new SymfonyStyle($input, $output);

        $output->writeln(
            [
                '<info>Generate contacts in CRM</info>',
                '<info>========================</info>',
                sprintf('webhook url: %s', $b24Webhook),
                sprintf('try to add contacts: %s', $contactsCount),
            ]
        );

        try {
            // todo create service builder factory
            $core = (new CoreBuilder())
                ->withLogger($this->logger)
                ->withWebhookUrl($b24Webhook)
                ->build();
            $batch = new Batch(
                $core,
                $this->logger
            );
            $services = new ServiceBuilder(
                $core,
                $batch,
                (new BulkItemsReaderBuilder(
                    $core,
                    $batch,
                    $this->logger
                ))
                    ->build(),
                $this->logger
            );

            $output->writeln(sprintf('contacts total count: %s', $services->getCRMScope()->contact()->countByFilter()));

            $io->section('start adding contacts…');
            $timeStart = microtime(true);
            foreach (
                $services->getCRMScope()->contact()->batch->add(
                    $this->generateContacts($contactsCount)
                ) as $queryCnt => $addedItem
            ) {
                /**
                 * @var $queryResultData \Bitrix24\SDK\Core\Result\AddedItemBatchResult
                 */
                $io->writeln(
                    [
                        sprintf(
                            '%s Mb |%s of %s | contact id: %s',
                            round(memory_get_peak_usage(true) / 1024 / 1024, 2),
                            $queryCnt + 1,
                            $contactsCount,
                            $addedItem->getId()
                        ),
                    ]
                );
            }
            $timeEnd = microtime(true);
            $io->writeln(sprintf('batch query duration: %s seconds', round($timeEnd - $timeStart, 2)) . PHP_EOL . PHP_EOL);
            $io->success('contacts added');
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
        $this->logger->debug('GenerateContactsCommand.finish');

        return Command::SUCCESS;
    }

    /**
     * Generate fake contacts
     *
     * @param int $contactsCount
     *
     * @return array<int, array> $contacts
     * @throws \Exception
     */
    protected function generateContacts(int $contactsCount): array
    {
        $contacts = [];
        for ($i = 0; $i < $contactsCount; $i++) {
            $contacts[] = [
                'NAME'        => sprintf('name_%s', $i),
                'LAST_NAME'   => sprintf('last_%s', $i),
                'SECOND_NAME' => sprintf('second_%s', $i),
                'PHONE'       => [
                    ['VALUE' => sprintf('+7978%s', random_int(1000000, 9999999)), 'VALUE_TYPE' => 'MOBILE'],
                ],
                'EMAIL'       => [
                    ['VALUE' => sprintf('test-%s@gmail.com', random_int(1000000, 9999999)), 'VALUE_TYPE' => 'WORK'],
                ],
            ];
        }

        return $contacts;
    }
}

