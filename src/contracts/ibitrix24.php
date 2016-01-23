<?php
/**
 * Created by PhpStorm.
 * User: Mesilov
 * Date: 23.01.2016
 * Time: 1:47
 */
namespace Bitrix24\Contracts;

use Bitrix24\Bitrix24;
use Bitrix24\Bitrix24Exception;
use Bitrix24\Bitrix24IoException;
use Bitrix24\Bitrix24ApiException;
use Bitrix24\Bitrix24WrongClientException;
use Bitrix24\Bitrix24MethodNotFoundException;
use Bitrix24\Bitrix24TokenIsInvalid;
use Bitrix24\Bitrix24TokenIsExpired;
use Bitrix24\Bitrix24SecurityException;

use Bitrix24\Stub\Logger;
use Psr\Log\LoggerInterface;

/**
 * Interface iBitrix24
 * @package Bitrix24
 */
interface iBitrix24
{
	/**
	 * Create a object to work with Bitrix24 REST API service
	 * @param bool $isSaveRawResponse - if true raw response from bitrix24 will be available from method getRawResponse, this is debug mode
	 * @param null|LoggerInterface $obLogger - instance of \Monolog\Logger
	 * @throws Bitrix24Exception
	 * @return Bitrix24
	 */
	public function __construct($isSaveRawResponse = false, LoggerInterface $obLogger = null);

	/**
	 * Get a random string to sign protected api-call. Use salt for argument "state" in secure api-call
	 * random string is a result of mt_rand function
	 * @return int
	 */
	public function getSecuritySignSalt();

	/**
	 * Set member ID — portal GUID
	 * @param string $memberId
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setMemberId($memberId);
	/**
	 * Get memeber ID
	 * @return string | null
	 */
	public function getMemberId();

	/**
	 * Set redirect URI
	 * @param string $redirectUri
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setRedirectUri($redirectUri);
	/**
	 * Get redirect URI
	 * @return string | null
	 */
	public function getRedirectUri();

	/**
	 * Set access token
	 * @param string $accessToken
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setAccessToken($accessToken);

	/**
	 * Get access token
	 * @return string | null
	 */
	public function getAccessToken();

	/**
	 * Set refresh token
	 * @param $refreshToken
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setRefreshToken($refreshToken);
	/**
	 * Get refresh token
	 * @return string
	 */
	public function getRefreshToken();

	/**
	 * Set domain
	 * @param $domain
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setDomain($domain);

	/**
	 * Get domain
	 * @return string | null
	 */
	public function getDomain();
	/**
	 * Set application scope
	 * @param array $applicationScope
	 * @return boolean
	 * @throws Bitrix24Exception
	 */
	public function setApplicationScope(array $applicationScope);

	/**
	 * Get application scope
	 */
	public function getApplicationScope();

	/**
	 * Set application id
	 * @param string $applicationId
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setApplicationId($applicationId);

	/**
	 * Get application id
	 * @return string
	 */
	public function getApplicationId();

	/**
	 * Set application secret
	 * @param string $applicationSecret
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setApplicationSecret($applicationSecret);

	/**
	 * Get application secret
	 * @return string
	 */
	public function getApplicationSecret();

	/**
	 * Set custom cURL options, overriding default ones
	 * @link http://php.net/manual/en/function.curl-setopt.php
	 * @param array $options - array(CURLOPT_XXX => value1, CURLOPT_XXX2 => value2,...)
	 * @return bool
	 */
	public function setCustomCurlOptions($options);

	/**
	 * Return raw request, contain all cURL options array and API query. Data available after you try to call method call
	 * numbers of array keys is const of cURL module. Example: CURLOPT_RETURNTRANSFER = 19913
	 * @return array | null
	 */
	public function getRawRequest();

	/**
	 * Return result from function curl_getinfo. Data available after you try to call method call
	 * @return array | null
	 */
	public function getRequestInfo();

	/**
	 * Return additional parameters of last api-call. Data available after you try to call method call
	 * @return array | null
	 */
	public function getMethodParameters();

	/**
	 * Execute Bitrix24 REST API method
	 * @param string $methodName
	 * @param array $additionalParameters
	 * @throws Bitrix24Exception
	 * @throws Bitrix24ApiException
	 * @throws Bitrix24TokenIsInvalid
	 * @throws Bitrix24TokenIsExpired
	 * @throws Bitrix24WrongClientException
	 * @throws Bitrix24MethodNotFoundException
	 * @throws Bitrix24SecurityException
	 * @return array
	 */
	public function call($methodName, array $additionalParameters = array());

	/**
	 * Get raw response from Bitrix24 before json_decode call, method available only in debug mode.
	 * To activate debug mode you must before set to true flag isSaveRawResponse in class construct
	 * @throws Bitrix24Exception
	 * @return string
	 */
	public function getRawResponse();

	/**
	 * Get new access token
	 * @return array
	 * @throws Bitrix24Exception
	 * @throws Bitrix24ApiException
	 * @throws Bitrix24TokenIsInvalid
	 * @throws Bitrix24TokenIsExpired
	 * @throws Bitrix24WrongClientException
	 * @throws Bitrix24MethodNotFoundException
	 */
	public function getNewAccessToken();

	/**
	 * Authorize and get first access token
	 * @param $code
	 * @return array
	 * @throws Bitrix24ApiException
	 * @throws Bitrix24Exception
	 * @throws Bitrix24IoException
	 * @throws Bitrix24MethodNotFoundException
	 * @throws Bitrix24TokenIsExpired
	 * @throws Bitrix24TokenIsInvalid
	 * @throws Bitrix24WrongClientException
	 */
	public function getFirstAccessToken($code);

	/**
	 * Check is access token expire, call list of all available api-methods from B24 portal with current access token
	 * if we have an error code expired_token then return true else return false
	 * @throws Bitrix24Exception
	 * @throws Bitrix24ApiException
	 * @throws Bitrix24TokenIsInvalid
	 * @throws Bitrix24TokenIsExpired
	 * @throws Bitrix24WrongClientException
	 * @throws Bitrix24MethodNotFoundException
	 * @return boolean
	 */
	public function isAccessTokenExpire();

	/**
	 * Get list of all methods available for current application
	 * @param array | null $applicationScope
	 * @param bool $isFull
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function getAvailableMethods(array $applicationScope = array(), $isFull = false);

	/**
	 * get list of scope for current application from bitrix24 api
	 * @param bool $isFull
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function getScope($isFull=false);
}