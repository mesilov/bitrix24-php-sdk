<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\CRM;

use Bitrix24\CRM\Company;
use Bitrix24\Contracts\iBitrix24;


/**
 * @package Bitrix24
 */
class CompanyTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdateCallsClientWithIdAndFields()
    {
        $testId = \md5(\time());
        $testField = \md5($testId);
        $testFields = [
            $testField => \md5($testField),
        ];

        //silly mocking in PHPUnit 4.8
        $methods = array();
        $ref = new \ReflectionClass('Bitrix24\\Contracts\\iBitrix24');
        foreach ($ref->getMethods() as $method) {
            $methods[] = $method->getName();
        }
        $client = $this->getMockBuilder('Bitrix24\\Contracts\\iBitrix24')
            ->setMethods($methods)
            ->getMock();
        $client->expects($this->once())
            ->method('call')
            ->with(
                'crm.company.update',
                array(
                    'id' => $testId,
                    'fields' => $testFields,
                )
            );

        $company = new Company($client);
        $company->update($testId, $testFields);
    }
}
