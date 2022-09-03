<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Application\Requests\Placement;

use Bitrix24\SDK\Application\ApplicationStatus;
use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Application\Requests\AbstractRequest;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class PlacementRequest extends AbstractRequest
{
    private AccessToken $accessToken;
    private string $memberId;
    private ApplicationStatus $applicationStatus;
    private string $code;
    /**
     * @var array<string, mixed>
     */
    private array $placementOptions;
    private string $domainUrl;
    private string $languageCode;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
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

        $this->accessToken = AccessToken::initFromPlacementRequest($request);
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

    /**
     * @return string
     */
    public function getMemberId(): string
    {
        return $this->memberId;
    }

    /**
     * @return \Bitrix24\SDK\Core\Credentials\AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return array|mixed
     */
    public function getPlacementOptions()
    {
        return $this->placementOptions;
    }

    /**
     * @return mixed|string
     */
    public function getDomainUrl()
    {
        return $this->domainUrl;
    }

    /**
     * @return mixed|string
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }
}