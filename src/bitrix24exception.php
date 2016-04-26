<?php
/**
 * Class Bitrix24Exception
 *
 * \Exception
 * 		\Bitrix24Exception — base class
 * 			\Bitrix24IoException — I/O network errors
 * 			\Bitrix24ApiException — API level errors
 * 				\Bitrix24WrongClientException — Wrong client or application will be deleted from portal
 * 				\Bitrix24MethodNotFoundException — API-method not found
 * 				\Bitrix24TokenIsInvalid — The access token provided is invalid
 * 				\Bitrix24TokenIsExpired — The access token provided has expired
 * 				\Bitrix24PortalDeleted — Bitrix24 portal deleted
 * 			\Bitrix24SecurityException — Security errors for protected methods
 */
namespace Bitrix24;
class Bitrix24Exception extends \Exception {}
class Bitrix24IoException extends Bitrix24Exception {}
class Bitrix24ApiException extends Bitrix24Exception {}
class Bitrix24WrongClientException extends Bitrix24ApiException {}
class Bitrix24MethodNotFoundException extends Bitrix24ApiException {}
class Bitrix24TokenIsInvalid extends Bitrix24ApiException {}
class Bitrix24TokenIsExpired extends Bitrix24ApiException {}
class Bitrix24PortalDeleted extends Bitrix24ApiException {}
class Bitrix24SecurityException extends Bitrix24Exception {}
