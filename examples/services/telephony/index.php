<?php
declare(strict_types=1);

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\Main\Common\EventHandlerMetadata;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Services\Telephony\Events\OnExternalCallBackStart\OnExternalCallBackStart;
use Bitrix24\SDK\Services\Telephony\Events\OnExternalCallStart\OnExternalCallStart;
use Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallEnd\OnVoximplantCallEnd;
use Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallInit\OnVoximplantCallInit;
use Bitrix24\SDK\Services\Telephony\Events\OnVoximplantCallStart\OnVoximplantCallStart;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__, 3) . '/vendor/autoload.php';
require dirname(__DIR__, 2) . '/LoggerFactory.php';
?>
    <pre><?= print_r($_REQUEST, true) ?></pre>
<?php
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

$request = Request::createFromGlobals();

$log = LoggerFactory::get();

$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
$appProfile = ApplicationProfile::initFromArray($_ENV);
$accessToken = AuthToken::initFromPlacementRequest($request);
$b24Service = $b24ServiceFactory->initFromRequest($appProfile, $accessToken, $_REQUEST['DOMAIN']);


// subscribe to all events
$handlerUrl = 'https://' . $request->getHost() . '/events-handler.php';
$b24UserId = $b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
$eventHandlers = [
    new EventHandlerMetadata(OnExternalCallBackStart::CODE, $handlerUrl, $b24UserId),
    new EventHandlerMetadata(OnExternalCallStart::CODE, $handlerUrl, $b24UserId),
    new EventHandlerMetadata(OnVoximplantCallInit::CODE, $handlerUrl, $b24UserId),
    new EventHandlerMetadata(OnVoximplantCallEnd::CODE, $handlerUrl, $b24UserId),
    new EventHandlerMetadata(OnVoximplantCallStart::CODE, $handlerUrl, $b24UserId)
];


$b24Service->getMainScope()->eventManager()->bindEventHandlers($eventHandlers);
