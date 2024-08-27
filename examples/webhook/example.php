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

use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\MemoryUsageProcessor;

require_once 'vendor/autoload.php';

$webhookUrl = 'INSERT_HERE_YOUR_WEBHOOK_URL';

$log = new Logger('bitrix24-php-sdk');
$log->pushHandler(new StreamHandler('bitrix24-php-sdk.log'));
$log->pushProcessor(new MemoryUsageProcessor(true, true));

// create service builder factory
$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);
// init bitrix24-php-sdk service from webhook
$b24Service = $b24ServiceFactory->initFromWebhook($webhookUrl);

// work with interested scope
var_dump($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());
// get deals list and address to first element
var_dump($b24Service->getCRMScope()->lead()->list([], [], ['ID', 'TITLE'])->getLeads()[0]->TITLE);
