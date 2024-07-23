<?php
declare(strict_types=1);

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowPropertyType;
use Bitrix24\SDK\Services\Workflows\Workflow\Request\IncomingRobotRequest;
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

    $workflowReq = IncomingRobotRequest::initFromRequest($req);

    print_r($workflowReq);

    $b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
    $appProfile = ApplicationProfile::initFromArray($_ENV);

    //AccessToken::initFromWorkflowRequest($req),
    $b24Service = $b24ServiceFactory->initFromRequest(
        $appProfile,
        $workflowReq->auth->accessToken,
        $workflowReq->auth->domain
    );

    $returnProp = [
        'result_sum' => 5555
    ];

    print('PROP' . PHP_EOL);
    print_r($workflowReq->properties);
    print_r($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());

    $b24Service->getBizProcScope()->activity()->log(
        $workflowReq->eventToken,
        'hello from activity handler'
    );

    $res = $b24Service->getBizProcScope()->event()->send(
        $workflowReq->eventToken,
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

    print('ERRRRRRRRRORRRR!!!!');
    print($exception->getMessage() . PHP_EOL);
    print_r($exception->getTraceAsString());

}


//    Array
//    (
//    [workflow_id] => 664fa13bbbb410.99176768
//    [code] => test_activity
//    [document_id] => Array
//    (
//        [0] => crm
//        [1] => CCrmDocumentContact
//        [2] => CONTACT_109286
//    )
//
//    [document_type] => Array
//    (
//        [0] => crm
//        [1] => CCrmDocumentContact
//        [2] => CONTACT
//    )
//
//    [event_token] => 664fa13bbbb410.99176768|A40364_79843_85254_57332|MS1ekdI0CvXi8ycL8qNIn96hak8JEndG.54020ce210345fb6eb12a79d75316d9430b42ccd9c1d82ab1a3bf8b064ec50e9
//    [properties] => Array
//    (
//        [comment] => дефолтная строка - значение
//        [amount] => 333
//    )
//
//    [use_subscription] => Y
//    [timeout_duration] => 660
//    [ts] => 1716494651

//    [auth] => Array
//    (

// access token
//          [access_token] => 4baf4f66006e13540058f18a000000100000009b41bce7ec85f07c3646c07e6d629e7c
//          [refresh_token] => 3b2e7766006e13540058f18a000000100000003b31a96730e79dc7561c1d7d0b33933f
//          [expires] => 1716498251

// endpoints
//          [server_endpoint] => https://oauth.bitrix.info/rest/
//          [client_endpoint] => https://bitrix24-php-sdk-playground.bitrix24.ru/rest/

// scope
//          [scope] => crm,bizproc,appform,baas,placement,user_brief,call,telephony

// application status
//          [status] => L


//          [application_token] => f9ac5db5ad4adbdee13eb034207d8fbd
//          [expires_in] => 3600
//          [domain] => bitrix24-php-sdk-playground.bitrix24.ru
//          [member_id] => 010b6886ebc205e43ae65000ee00addb
//          [user_id] => 16
//        )
//)
