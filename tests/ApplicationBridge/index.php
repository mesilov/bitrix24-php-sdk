<?php
declare(strict_types=1);

use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Tests\ApplicationBridge\ApplicationCredentialsProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

?>
    <pre>

    <?= print_r($_REQUEST, true) ?>
    </pre>
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


$log = new Logger('bitrix24-php-sdk');
$log->pushHandler(new StreamHandler($_ENV['LOGS_FILE_NAME'], (int)$_ENV['LOGS_LEVEL']));
$log->pushProcessor(new MemoryUsageProcessor(true, true));

$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
$appProfile = ApplicationProfile::initFromArray($_ENV);
$accessToken = AccessToken::initFromPlacementRequest($request);
$b24Service = $b24ServiceFactory->initFromRequest($appProfile, $accessToken, $_REQUEST['DOMAIN']);

// save new access token for integration tests
$credentialsProvider = ApplicationCredentialsProvider::buildProviderForLocalApplication();
$credentialsProvider->saveAccessToken($accessToken);

// call rest-api
print_r($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());

