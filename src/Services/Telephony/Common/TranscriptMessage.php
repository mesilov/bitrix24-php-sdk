<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\Telephony\Common;

readonly class TranscriptMessage
{
    public function __construct(
        public TranscriptMessageSide $side,
        public int                   $startTime,
        public int                   $stopTime,
        public string                $message
    )
    {
    }
}