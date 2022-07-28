<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Requests\Events;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;

class OnExternalCallBackStart extends AbstractEventRequest
{
    /**
     * @return string Telephone number.
     */
    public function getPhoneNumber(): string
    {
        return $this->eventPayload['data']['PHONE_NUMBER'];
    }

    /**
     * @return string Text to be voiced over to a user during initiated call ().
     */
    public function getText(): string
    {
        return $this->eventPayload['data']['TEXT'];
    }

    /**
     * @return string Voice ID to be used for text voiceover (via form settings). To get a voice IDs list, see voximplant.tts.voices.get.
     */
    public function getVoiceId(): string
    {
        return $this->eventPayload['data']['VOICE'];
    }

    /**
     * @return \Bitrix24\SDK\Services\Telephony\Common\CrmEntityType
     * @throws \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException
     */
    public function getCrmEntityType(): CrmEntityType
    {
        return CrmEntityType::initByCode($this->eventPayload['data']['CRM_ENTITY_TYPE']);
    }

    /**
     * @return int CRM entity ID with type specified in CRM_ENTITY_TYPE.
     */
    public function getCrmEntityId(): int
    {
        return (int)$this->eventPayload['data']['CRM_ENTITY_ID'];
    }

    /**
     * @return string Number of external line used to request a callback
     */
    public function getLineNumber(): string
    {
        return $this->eventPayload['data']['LINE_NUMBER'];
    }
}