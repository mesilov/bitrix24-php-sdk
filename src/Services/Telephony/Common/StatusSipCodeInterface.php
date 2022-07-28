<?php

declare(strict_types=1);

/*
 * This file is part of the bitrix24-php-sdk package.
 *
 *  Kirill  Кhramov <k_hram@mail.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Services\Telephony\Common;

interface StatusSipCodeInterface
{
    //Provisional Responses
    public const STATUS_RINGING = 180;
    public const STATUS_CALL_IS_BEING_FORWARDED = 181;
    public const STATUS_QUEUED = 182;
    public const STATUS_SESSION_PROGRESS = 183;
    public const STATUS_EARLY_DIALOG_TERMINATED = 199;
    //Successful Responses
    public const STATUS_OK = 200;
    public const STATUS_ACCEPTED = 202;
    public const STATUS_NO_NOTIFICATION = 204;
    //Redirection Responses
    public const STATUS_MULTIPIE_CHOICES = 300;
    public const STATUS_MOVED_PERMANENTLY = 301;
    public const STATUS_MOVED_TEMPORARILY = 302;
    public const STATUS_USE_PROXY = 305;
    public const STATUS_ALTERNATIVE_SERVICE = 380;
    //Client Failure Responses
    public const STATUS_BAD_REQUEST = 400;
    public const STATUS_UNAUTHORIZED = 401;
    public const STATUS_PAYMENT_REQUIRED = 402;
    public const STATUS_FORBIDDEN = 403;
    public const STATUS_NOT_FOUND = 404;
    public const STATUS_METHOD_NOT_ALLOWED = 405;
    public const STATUS_NOT_ACCEPTABLE = 406;
    public const STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;
    public const STATUS_REQUEST_TIMEOUT = 408;
    public const STATUS_C0NFLICT = 409;
    public const STATUS_GONE = 410;
    public const STATUS_LENGTH_REQUIRED = 411;
    public const STATUS_CONDITIONAL_REQUEST_FAILED = 412;
    public const STATUS_REQUEST_ENTITY_TOO_LARGE = 413;
    public const STATUS_REQUEST_URI_TOO_LONG = 414;
    public const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
    public const STATUS_UNSUPPORTED_URI_SCHEME = 416;
    public const STATUS_UNKNOWN_RESOURCE_PRIORITY = 417;
    public const STATUS_BAD_EXTENSION = 420;
    public const STATUS_EXTENSION_REQUIRED = 421;
    public const STATUS_SESSION_INTERVAL_TOO_SMALL = 422;
    public const STATUS_INTERVAL_TOO_BRIED = 423;
    public const STATUS_BAD_LOCATION_INFORMATION = 424;
    public const STATUS_BAD_ALERT_MESSAGE = 425;
    public const STATUS_USE_IDENTITY_HEADER = 428;
    public const STATUS_PROVIDE_REFERRER_IDENTITY = 429;
    public const STATUS_FLOW_FAILED = 430;
    public const STATUS_ANONYMITY_DISALLOWED = 433;
    public const STATUS_BAD_IDENTITY_INFO = 436;
    public const STATUS_UNSUPPORTED_CERTIFICATE = 437;
    public const STATUS_INVALID_IDENTITY_HEADER = 438;
    public const STATUS_FIRST_HOP_LACKS_OUTBOUND_SUPPORT = 439;
    public const STATUS_MAX_BREADTH_EXCEEDED = 440;
    public const STATUS_BAD_INFO_PACKAGE = 469;
    public const STATUS_CONSENT_NEEDED = 470;
    public const STATUS_TEMPORARILY_UNAVAILABLE = 480;
    public const STATUS_CALL_OR_TRANSACTION_DOES_NOT_EXIST = 481;
    public const STATUS_LOOP_DETECTED = 482;
    public const STATUS_TOO_MANY_HOPS = 483;
    public const STATUS_ADDRESS_INCOMPLETE = 484;
    public const STATUS_AMBIGUOUS = 485;
    public const STATUS_BUSY_HERE = 486;
    public const STATUS_REQUEST_TERMINATED = 487;
    public const STATUS_NOT_ACCEPTABLE_HERE = 488;
    public const STATUS_BAD_EVENT = 489;
    public const STATUS_REQUEST_PENDING = 491;
    public const STATUS_UNDECIPHERABLE = 493;
    public const STATUS_SECURITY_AGREEMENT_REQUIRED = 494;
    //Server Failure Responses
    public const STATUS_INTERNAL_SERVER_ERROR = 500;
    public const STATUS_NOT_IMPLEMENTED = 501;
    public const STATUS_BAD_GATEWAY = 502;
    public const STATUS_SERVICE_UNAVAILABLE = 503;
    public const STATUS_SERVER_TIME_OUT = 504;
    public const STATUS_VERSION_NOT_SUPPORTED = 505;
    public const STATUS_MESSAGE_TOO_LARGE = 513;
    public const STATUS_PUSH_NOTIFICATION_SERVICE_NOT_SUPPORTED = 555;
    public const STATUS_PRECONDITION_FAILURE = 580;
    //Global Failure Responses
    public const STATUS_BUSY_EVERYWHERE = 600;
    public const STATUS_DECLINE = 603;
    public const STATUS_DOES_NOT_EXIST_ANYWHERE = 604;
    public const STATUS_GLOBAL_NOT_ACCEPTABLE = 606;
    public const STATUS_UNWANTED = 607;
    public const STATUS_REJECTED = 608;
}