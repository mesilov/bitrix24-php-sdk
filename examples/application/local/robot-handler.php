<?php
declare(strict_types=1);

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowPropertyType;
use Bitrix24\SDK\Services\Workflows\Robot\Request\IncomingRobotRequest;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__, 3) . '/vendor/autoload.php';

?>
    <pre>
    Приложение работает, получили токены от Битрикс24:
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


try {
    $log = new Logger('bitrix24-php-sdk-cli');
    $log->pushHandler(new StreamHandler($_ENV['LOGS_FILE_NAME'], (int)$_ENV['LOGS_LEVEL']));
    $log->pushProcessor(new MemoryUsageProcessor(true, true));

    $req = Request::createFromGlobals();
    $log->debug('incoming request', [
        'payload' => $req->request->all()
    ]);

    $b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
    $appProfile = ApplicationProfile::initFromArray($_ENV);


    $rr = IncomingRobotRequest::initFromRequest($req);

    $b24Service = $b24ServiceFactory->initFromRequest(
        $appProfile,
        $rr->auth->accessToken,
        $rr->auth->domain
    );

    $returnProp = [
        'result_sum' => 5555
    ];

    $res = $b24Service->getBizProcScope()->event()->send(
        $rr->eventToken,
        $returnProp,
        sprintf('debug result %s', print_r($returnProp, true))
    );
    $log->debug('ffffffff', [
        'res' => $res->isSuccess()
    ]);

} catch (Throwable $exception) {

    $log->error(sprintf('error: %s', $exception->getMessage()), [
        'trace' => $exception->getTraceAsString()
    ]);


}


