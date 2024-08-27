<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Bitrix24\SDK\Core\Credentials\AuthToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

require_once 'vendor/autoload.php';
?>
    <pre>
    Application is worked, auth tokens from bitrix24:
    <?= print_r($_REQUEST, true) ?>
</pre>
<?php
$request = Request::createFromGlobals();

$log = new Logger('bitrix24-php-sdk');
$log->pushHandler(new StreamHandler('bitrix24-php-sdk.log'));
$log->pushProcessor(new MemoryUsageProcessor(true, true));

$b24ServiceBuilderFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
$appProfile = ApplicationProfile::initFromArray([
    'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => 'INSERT_HERE_YOUR_DATA',
    'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => 'INSERT_HERE_YOUR_DATA',
    'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => 'INSERT_HERE_YOUR_DATA'
]);
$b24Service = $b24ServiceBuilderFactory->initFromRequest($appProfile, AuthToken::initFromPlacementRequest($request), $request->get('DOMAIN'));

var_dump($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());
// get deals list and address to first element
var_dump($b24Service->getCRMScope()->lead()->list([], [], ['ID', 'TITLE'])->getLeads()[0]->TITLE);