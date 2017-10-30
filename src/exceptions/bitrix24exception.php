<?php
/*
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Mesilov Maxim <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitrix24\Exceptions;

/**
 * Class Bitrix24Exception
 *
 * \Exception
 * 		\Bitrix24Exception — base class
 * 			\Bitrix24IoException — I/O network errors
 * 			    \Bitrix24EmptyResponseException — empty response from Bitrix24 portal
 * 			\Bitrix24ApiException — API level errors
 * 				\Bitrix24WrongClientException — Wrong client or application will be deleted from portal
 * 				\Bitrix24MethodNotFoundException — API-method not found
 * 				\Bitrix24TokenIsInvalidException — The access token provided is invalid
 * 				\Bitrix24TokenIsExpiredException — The access token provided has expired
 * 				\Bitrix24PortalDeletedException — Bitrix24 portal deleted
 * 				\Bitrix24PortalRenamedException — Bitrix24 portal renamed
 * 				\Bitrix24PaymentRequiredException — Bitrix24 application payment required
 * 			\Bitrix24SecurityException — Security errors for protected methods
 *
 * @package Bitrix24\Exceptions
 */
class Bitrix24Exception extends \Exception
{
}