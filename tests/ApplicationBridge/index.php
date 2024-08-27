<?php
declare(strict_types=1);

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

use Bitrix24\SDK\Core\Credentials\AuthToken;
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
$accessToken = AuthToken::initFromPlacementRequest($request);
$b24Service = $b24ServiceFactory->initFromRequest($appProfile, $accessToken, $_REQUEST['DOMAIN']);

// save new access token for integration tests
$credentialsProvider = ApplicationCredentialsProvider::buildProviderForLocalApplication();
$credentialsProvider->saveAuthToken($accessToken);

// call rest-api
print_r($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());

