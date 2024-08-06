<?php
declare(strict_types=1);

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Services\Telephony\Common\CallType;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;
use Bitrix24\SDK\Services\Telephony\Common\TelephonyCallStatusCode;
use Bitrix24\SDK\Services\Telephony\Events\TelephonyEventsFabric;
use Carbon\CarbonImmutable;
use Money\Currency;
use Money\Money;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__, 3) . '/vendor/autoload.php';
require dirname(__DIR__, 2) . '/LoggerFactory.php';

if (!class_exists(Dotenv::class)) {
    throw new LogicException('You need to add "symfony/dotenv" as Composer dependencies.');
}
(new Dotenv())->bootEnv('.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    if (class_exists(
        Debug::class
    )) {
        Debug::enable();
    }
}

try {

    $log = LoggerFactory::get();

    $request = Request::createFromGlobals();
    $log->debug('incoming request', [
        'payload' => $request->request->all()
    ]);

    // create telephony event
    $event = (new TelephonyEventsFabric())->create($request);
    if ($event === null) {
        throw new \Bitrix24\SDK\Core\Exceptions\InvalidArgumentException('unknown event code');
    }
    $log->debug('received event', [
        'code' => $event->getEventCode(),
        'payload' => $event->getEventPayload(),
    ]);

    // init service builder with auth token from event
    $serviceBuilder = (new ServiceBuilderFactory(new EventDispatcher(), $log))->initFromRequest(
        ApplicationProfile::initFromArray($_ENV),
        AuthToken::initFromEventRequest($request),
        $event->getAuth()->client_endpoint
    );

    $curUser = $serviceBuilder->getMainScope()->main()->getCurrentUserProfile()->getUserProfile();
    $log->debug('current user profile', [
        'id' => $curUser->ID
    ]);
    $currentB24UserId = $serviceBuilder->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
    $innerPhoneNumber = '123';
    // set inner phone number for user
    $serviceBuilder->getUserScope()->user()->update(
        $currentB24UserId,
        [
            'UF_PHONE_INNER' => $innerPhoneNumber
        ]
    );

    if ($event instanceof Bitrix24\SDK\Services\Telephony\Events\OnExternalCallBackStart\OnExternalCallBackStart) {
        // start call
        $phoneNumber = '7978' . random_int(1000000, 9999999);
        $b24CallId = $serviceBuilder->getTelephonyScope()->externalCall()->register(
            $innerPhoneNumber,
            $currentB24UserId,
            $phoneNumber,
            CarbonImmutable::now(),
            CallType::outbound,
            true,
            true,
            '3333',
            null,
            CrmEntityType::contact
        )->getExternalCallRegistered()->CALL_ID;

        //emulate work with external pbx and make real call
        sleep(3);

        // finish call
        $money = new Money(10000, new Currency('USD'));
        $duration = 100;
        $finishResult = $serviceBuilder->getTelephonyScope()->externalCall()->finishForUserId(
            $b24CallId,
            $currentB24UserId,
            $duration,
            $money,
            TelephonyCallStatusCode::successful,
            true
        );
    }
    if ($event instanceof Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallEnd\OnVoximplantCallEnd) {
        $log->debug('OnVoximplantCallEnd event payload', [
            'paylload' => $event->getEventPayload()
        ]);
    }
} catch (Throwable $exception) {

    $log->error(sprintf('error: %s', $exception->getMessage()), [
        'trace' => $exception->getTraceAsString()
    ]);


}


