<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application;

use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class ApplicationStatus
{
    private const STATUS_SHORT_FREE = 'F';
    private const STATUS_SHORT_DEMO = 'D';
    private const STATUS_SHORT_TRIAL = 'T';
    private const STATUS_SHORT_PAID = 'P';
    private const STATUS_SHORT_LOCAL = 'L';
    private const STATUS_SHORT_SUBSCRIPTION = 'S';
    private string $statusCode;

    /**
     * @param string $statusShortCode
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $statusShortCode)
    {
        switch ($statusShortCode) {
            case self::STATUS_SHORT_FREE:
                $this->statusCode = 'free';
                break;
            case self::STATUS_SHORT_DEMO:
                $this->statusCode = 'demo';
                break;
            case self::STATUS_SHORT_TRIAL:
                $this->statusCode = 'trial';
                break;
            case self::STATUS_SHORT_PAID:
                $this->statusCode = 'paid';
                break;
            case self::STATUS_SHORT_LOCAL:
                $this->statusCode = 'local';
                break;
            case self::STATUS_SHORT_SUBSCRIPTION:
                $this->statusCode = 'subscription';
                break;
            default:
                throw new InvalidArgumentException(
                    sprintf('unknown application status code %s', $statusShortCode)
                );
        }
    }

    /**
     * @return bool
     */
    public function isFree(): bool
    {
        return 'free' === $this->statusCode;
    }

    /**
     * @return bool
     */
    public function isDemo(): bool
    {
        return 'demo' === $this->statusCode;
    }

    /**
     * @return bool
     */
    public function isTrial(): bool
    {
        return 'trial' === $this->statusCode;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return 'paid' === $this->statusCode;
    }

    /**
     * @return bool
     */
    public function isLocal(): bool
    {
        return 'local' === $this->statusCode;
    }

    /**
     * @return bool
     */
    public function isSubscription(): bool
    {
        return 'subscription' === $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * @param Request $request
     *
     * @return self
     * @throws InvalidArgumentException
     */
    public static function initFromRequest(Request $request): self
    {
        return new self($request->request->getAlpha('status'));
    }

    /**
     * @param string $shortStatusCode
     *
     * @return self
     * @throws InvalidArgumentException
     */
    public static function initFromString(string $shortStatusCode): self
    {
        return new self($shortStatusCode);
    }
}