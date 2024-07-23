<?php
declare(strict_types=1);

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowAutoExecutionType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowDocumentType;
use Bitrix24\SDK\Services\Workflows\Common\WorkflowPropertyType;
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

$request = Request::createFromGlobals();


$log = new Logger('bitrix24-php-sdk-cli');
$log->pushHandler(new StreamHandler($_ENV['LOGS_FILE_NAME'], (int)$_ENV['LOGS_LEVEL']));
$log->pushProcessor(new MemoryUsageProcessor(true, true));

$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
$appProfile = ApplicationProfile::initFromArray($_ENV);
$b24Service = $b24ServiceFactory->initFromRequest($appProfile, AuthToken::initFromPlacementRequest($request), $_REQUEST['DOMAIN']);


var_dump('Hello world');

var_dump(Bitrix24\SDK\Core\Credentials\Credentials::createFromPlacementRequest(
    new \Bitrix24\SDK\Application\Requests\Placement\PlacementRequest($request),
    $appProfile
)->getAuthToken());
//
//$b64 = new \Symfony\Component\Mime\Encoder\Base64Encoder();
//$str = $b64->encodeString(file_get_contents('bp-82.bpt'));


// run workflow
//var_dump($b24Service->getBizProcScope()->template()->delete(82));

//$templateId = $b24Service->getBizProcScope()->template()->add(
//    WorkflowDocumentType::buildForContact(),
//    'Test template',
//    'Test template description',
//    WorkflowAutoExecutionType::withoutAutoExecution,
//    'bp-82.bpt'
//)->getId();
//
//$updateResult = $b24Service->getBizProcScope()->template()->update(
//    $templateId,
//    null,
//    'updated name',
//    null,
//    null,
//    'bp-82.bpt'
//)->isSuccess();
//
//var_dump($updateResult);


//
//
//foreach ($b24Service->getBizProcScope()->activity()->list()->getActivities() as $activityCode) {
//    var_dump($activityCode);
//    var_dump($b24Service->getBizProcScope()->activity()->delete($activityCode)->isSuccess());
//}
//$activityCode = 'test_activity';
//$handlerUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/activity-handler.php';
//$b24AdminUserId = $b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile()->ID;
//$activityName = [
//    'ru' => 'Название активити',
//    'en' => 'activity name'
//];
//$activityDescription = [
//    'ru' => 'Описание активити',
//    'en' => 'Activity description'
//];
//$activityProperties = [
//    'comment' => [
//        'Name' => [
//            'ru' => 'строка desc',
//            'en' => 'string desc'
//        ],
//        'Description' => [
//            'ru' => 'строка desc',
//            'en' => 'string desc'
//        ],
//        'Type' => WorkflowPropertyType::string->name,
//        'Options' => null,
//        'Required' => 'N',
//        'Multiple' => 'N',
//        'Default' => 'дефолтная строка - значение'
//
//    ],
//    'amount' => [
//        'Name' => [
//            'ru' => 'int значение',
//            'en' => 'int value'
//        ],
//        'Description' => [
//            'ru' => 'int значение пример',
//            'en' => 'int value example'
//        ],
//        'Type' => WorkflowPropertyType::int->name,
//        'Options' => null,
//        'Required' => 'N',
//        'Multiple' => 'N',
//        'Default' => 333
//    ]
//];
//
//$activityReturnProperties = [
//    'result_sum' => [
//        'Name' => [
//            'ru' => 'int значение',
//            'en' => 'int value'
//        ],
//        'Description' => [
//            'ru' => 'int',
//            'en' => 'int'
//        ],
//        'Type' => WorkflowPropertyType::int->name,
//        'Options' => null,
//        'Required' => 'N',
//        'Multiple' => 'N',
//        'Default' => 444
//    ]
//];
//
//
//$addActivityResult = $b24Service->getBizProcScope()->activity()->add(
//    $activityCode,
//    $handlerUrl,
//    $b24AdminUserId,
//    $activityName,
//    $activityDescription,
//    true,
//    $activityProperties,
//    false,
//    $activityReturnProperties,
//    WorkflowDocumentType::buildForLead(),
//    []
//);
//
//var_dump($addActivityResult->getCoreResponse()->getResponseData()->getResult());
//
//
//
//print('delete robots...' . PHP_EOL);
//foreach ($b24Service->getBizProcScope()->robot()->list()->getRobots() as $robotCode) {
//    print_r($b24Service->getBizProcScope()->robot()->delete($robotCode)->isSuccess());
//}
//
//
//$robotProperties = [
//    'comment' => [
//        'Name' => [
//            'ru' => 'строка desc',
//            'en' => 'string desc'
//        ],
//        'Description' => [
//            'ru' => 'строка desc',
//            'en' => 'string desc'
//        ],
//        'Type' => WorkflowPropertyType::string->name,
//        'Options' => null,
//        'Required' => 'N',
//        'Multiple' => 'N',
//        'Default' => 'дефолтная строка - значение'
//
//    ],
//    'amount' => [
//        'Name' => [
//            'ru' => 'int значение',
//            'en' => 'int value'
//        ],
//        'Description' => [
//            'ru' => 'int значение пример',
//            'en' => 'int value example'
//        ],
//        'Type' => WorkflowPropertyType::int->name,
//        'Options' => null,
//        'Required' => 'N',
//        'Multiple' => 'N',
//        'Default' => 333
//    ]
//];
//
//$robotReturnProperties = [
//    'result_sum' => [
//        'Name' => [
//            'ru' => 'int значение',
//            'en' => 'int value'
//        ],
//        'Description' => [
//            'ru' => 'int',
//            'en' => 'int'
//        ],
//        'Type' => WorkflowPropertyType::int->name,
//        'Options' => null,
//        'Required' => 'N',
//        'Multiple' => 'N',
//        'Default' => 'дефолтная строка - значение'
//    ]
//];
//
//$handlerUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/robot-handler.php';
//var_dump($handlerUrl);
//print('install robots...' . PHP_EOL);
//$addResult = $b24Service->getBizProcScope()->robot()->add('test_r_1', $handlerUrl,
//    1,
//    [
//        'ru' => 'РОБОТ 1',
//        'en' => 'robot 1',
//    ],
//    true,
//    $robotProperties,
//    false,
//    $robotReturnProperties
//);
//
//var_dump($addResult->isSuccess());
////
//var_dump($b24Service->getBizProcScope()->robot()->list()->getRobots());
////
//
