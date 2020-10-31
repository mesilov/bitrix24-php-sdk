<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response;

use Bitrix24\SDK\Core\Response\DTO;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class Response
 *
 * @package Bitrix24\SDK\Core\Response
 */
class Response
{
    /**
     * @var ResponseInterface
     */
    protected $httpResponse;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Response constructor.
     *
     * @param ResponseInterface $httpResponse
     * @param LoggerInterface   $logger
     */
    public function __construct(ResponseInterface $httpResponse, LoggerInterface $logger)
    {
        $this->httpResponse = $httpResponse;
        $this->logger = $logger;
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }

    /**
     * @return DTO\ResponseData
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getResponseData(): DTO\ResponseData
    {
        $this->logger->debug('getResponseData.start');
        $resultString = $this->httpResponse->getContent();
        try {
            $responseResult = json_decode($resultString, true, 512, JSON_THROW_ON_ERROR);

            $resultDto = new DTO\Result($responseResult['result']);
            $time = DTO\Time::initFromResponse($responseResult['time']);

            $this->logger->debug(
                'getResponseData.finish',
                [
                    'result'       => $resultDto->getResultData(),
                    'durationTime' => $time->getDuration(),
                ]
            );

            return new DTO\ResponseData(
                $resultDto,
                $time
            );
        } catch (\JsonException $e) {
            $this->logger->error(
                $e->getMessage(),
                [
                    'response' => $this->httpResponse->getContent(),
                ]
            );
        }
    }
}