<?php
/**
 * Class Bitrix24Exception
 *
 * \Exception
 * 		\Bitrix24Exception — base class
 * 			\Bitrix24IoException — I/O network errors
 *              \Bitrix24EmptyResponseException — empty response from Bitrix24 portal
 * 			\Bitrix24ApiException — API level errors
 * 				\Bitrix24WrongClientException — Wrong client or application will be deleted from portal
 * 				\Bitrix24MethodNotFoundException — API-method not found
 * 				\Bitrix24TokenIsInvalid — The access token provided is invalid
 * 				\Bitrix24TokenIsExpired — The access token provided has expired
 * 				\Bitrix24PortalDeleted — Bitrix24 portal deleted
 * 			\Bitrix24SecurityException — Security errors for protected methods
 */
namespace Bitrix24;

/**
 * Class Bitrix24Exception
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24Exception
 */
class Bitrix24Exception extends \Exception {}

/**
 * Class Bitrix24IoException
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24IoException
 */
class Bitrix24IoException extends Bitrix24Exception {}

/**
 * Class Bitrix24EmptyResponseException
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24EmptyResponseException
 */
class Bitrix24EmptyResponseException extends Bitrix24IoException {}

/**
 * Class Bitrix24ApiException
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24ApiException
 */
class Bitrix24ApiException extends Bitrix24Exception {}

/**
 * Class Bitrix24WrongClientException
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24WrongClientException
 */
class Bitrix24WrongClientException extends Bitrix24ApiException {}

/**
 * Class Bitrix24MethodNotFoundException
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24MethodNotFoundException
 */
class Bitrix24MethodNotFoundException extends Bitrix24ApiException {}

/**
 * Class Bitrix24TokenIsInvalid
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24TokenIsInvalidException
 */
class Bitrix24TokenIsInvalid extends Bitrix24ApiException {}

/**
 * Class Bitrix24TokenIsExpired
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24TokenIsExpiredException
 */
class Bitrix24TokenIsExpired extends Bitrix24ApiException {}

/**
 * Class Bitrix24PortalDeleted
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24PortalDeletedException
 */
class Bitrix24PortalDeleted extends Bitrix24ApiException {}

/**
 * Class Bitrix24SecurityException
 * @package Bitrix24
 * @deprecated use \Bitrix24\Exceptions\Bitrix24SecurityException
 */
class Bitrix24SecurityException extends Bitrix24Exception {}