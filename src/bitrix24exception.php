<?php
/**
 * Class Bitrix24Exception
 *
 * \Exception
 * 		\Bitrix24Exception — base class
 * 			\Bitrix24IoException — I/O network errors
 * 			\Bitrix24ApiException — API level errors
 * 			\Bitrix24SecurityException — Security errors for protected methods
 */
namespace Bitrix24;
class Bitrix24Exception extends \Exception {}
class Bitrix24IoException extends Bitrix24Exception {}
class Bitrix24ApiException extends Bitrix24Exception {}
class Bitrix24SecurityException extends Bitrix24Exception {}