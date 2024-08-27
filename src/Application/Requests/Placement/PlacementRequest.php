<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Placement;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Application\Requests\AbstractRequest;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class PlacementRequest extends AbstractRequest
{
    private readonly AuthToken $accessToken;

    private readonly string $memberId;

    private readonly ApplicationStatus $applicationStatus;

    private readonly string $code;

    /**
     * @var array<string, mixed>
     */
    private readonly array $placementOptions;

    private readonly string $domainUrl;

    private readonly string $languageCode;

    /**
     *
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     * @throws \JsonException
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $query = parse_url($request->getRequestUri())['query'];
        $queryArgs = [];
        parse_str($query, $queryArgs);
        $this->domainUrl = sprintf('https://%s', $queryArgs['DOMAIN']);
        $this->languageCode = $queryArgs['LANG'];

        $this->accessToken = AuthToken::initFromPlacementRequest($request);
        $this->applicationStatus = ApplicationStatus::initFromRequest($request);
        $this->memberId = $request->request->get('member_id');
        $this->code = (string)$request->request->get('PLACEMENT');

        $options = json_decode((string)$request->request->get('PLACEMENT_OPTIONS'), true, 512, JSON_THROW_ON_ERROR);
        if ($options === null) {
            throw new InvalidArgumentException('invalid data in PLACEMENT_OPTIONS json payload');
        }

        // fix "undefined" string in options when placement loaded in telephony settings
        if (!is_array($options)) {
            $options = [];
        }

        $this->placementOptions = $options;
    }

    public function getApplicationStatus(): ApplicationStatus
    {
        return $this->applicationStatus;
    }

    public function getMemberId(): string
    {
        return $this->memberId;
    }

    public function getAccessToken(): AuthToken
    {
        return $this->accessToken;
    }

    public function getCode(): string
    {
        return $this->code;
    }


    public function getPlacementOptions(): array
    {
        return $this->placementOptions;
    }


    public function getDomainUrl(): string
    {
        return $this->domainUrl;
    }


    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }
}