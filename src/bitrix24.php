<?php
namespace Bitrix24;
class Bitrix24
{
	/**
	 * SDK version
	 */
	const VERSION = '1.0';

	/**
	 * access token
	 * @var string
	 */
	protected $accessToken = null;

	/**
	 * refresh token
	 * @var string
	 */
	protected $refreshToken = null;

	/**
	 * domain
	 * @var string
	 */
	protected $domain = null;

	/**
	 * scope
	 * @var array
	 */
	protected $applicationScope = array();

	/**
	 * application id
	 * @var string
	 */
	protected $applicationId = null;

	/**
	 * application secret
	 * @var string
	 */
	protected $applicationSecret = null;

	/**
	 * raw request, contain all cURL options array and API query
	 * @var array
	 */
	protected $rawRequest = null;

	/**
	 * @var array, contain all api-method parameters, vill be available after call method
	 */
	protected $methodParameters = null;

	/**
	 * request info data structure акщь curl_getinfo function
	 * @var array
	 */
	protected $requestInfo = null;

	/**
	 * @var bool if true raw response from bitrix24 will be available from method getRawResponse, this is debug mode
	 */
	protected $isSaveRawResponse = false;

	/**
	 * @var array raw response from bitrix24
	 */
	protected $rawResponse = null;

	/**
	 * @var string redirect URI from application settings
	 */
	protected $redirectUri = null;

	/**
	 * @var string portal GUID
	 */
	protected $memberId = null;

	/**
	 * Create a object to work with Bitrix24 REST API service
	 * @param bool $isSaveRawResponse - if true raw response from bitrix24 will be available from method getRawResponse, this is debug mode
	 * @throws Bitrix24Exception
	 * @return Bitrix24
	 */
	public function __construct($isSaveRawResponse = false)
	{
		if (!extension_loaded('curl'))
		{
			throw new Bitrix24Exception('cURL extension must be installed to use this library');
		}
		if(!is_bool($isSaveRawResponse))
		{
			throw new Bitrix24Exception('isSaveRawResponse flag must be boolean');
		}
		$this->isSaveRawResponse = $isSaveRawResponse;
	}

	/**
	 * Get a random string to sign protected api-call. Use salt for argument "state" in secure api-call
	 * random string is a result of mt_rand function
	 * @return int
	 */
	public function getSecuritySignSalt()
	{
		return mt_rand();
	}

	/**
	 * Set member ID — portal GUID
	 * @param string $memberId
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setMemberId($memberId)
	{
		if(!empty($memberId))
		{
			$this->memberId = $memberId;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('memberId is empty');
		}
	}

	/**
	 * Get memeber ID
	 * @return string | null
	 */
	public function getMemberId()
	{
		return $this->memberId;
	}

	/**
	 * Set redirect URI
	 * @param string $redirectUri
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setRedirectUri($redirectUri)
	{
		if(!empty($redirectUri))
		{
			$this->redirectUri = $redirectUri;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('redirect URI not set');
		}
	}

	/**
	 * Get redirect URI
	 * @return string | null
	 */
	public function getRedirectUri()
	{
		return $this->redirectUri;
	}
	/**
	 * Set access token
	 * @param string $accessToken
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setAccessToken($accessToken)
	{
		if(!empty($accessToken))
		{
			$this->accessToken = $accessToken;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('access token not set');
		}
	}

	/**
	 * Get access token
	 * @return string | null
	 */
	public function getAccessToken()
	{
		return $this->accessToken;
	}

	/**
	 * Set refresh token
	 * @param $refreshToken
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setRefreshToken($refreshToken)
	{
		if(!empty($refreshToken))
		{
			$this->refreshToken = $refreshToken;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('refresh token not set');
		}
	}

	/**
	 * Get refresh token
	 * @return string
	 */
	public function getRefreshToken()
	{
		return $this->refreshToken;
	}

	/**
	 * Set domain
	 * @param $domain
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setDomain($domain)
	{
		if(!empty($domain))
		{
			$this->domain = $domain;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('domain not set');
		}
	}

	/**
	 * Get domain
	 * @return string | null
	 */
	public function getDomain()
	{
		return $this->domain;
	}

	/**
	 * Set application scope
	 * @param array $applicationScope
	 * @return boolean
	 * @throws Bitrix24Exception
	 */
	public function setApplicationScope(array $applicationScope)
	{
		if(is_array($applicationScope) && count($applicationScope)> 0)
		{
			$this->applicationScope = $applicationScope;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('application scope not set');
		}
	}


	/**
	 * Get application scope
	 */
	public function getApplicationScope()
	{
		return $this->applicationScope;
	}

	/**
	 * Set application id
	 * @param string $applicationId
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setApplicationId($applicationId)
	{
		if(!empty($applicationId))
		{
			$this->applicationId = $applicationId;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('application id not set');
		}
	}// end of SetApplicationId

	/**
	 * Get application id
	 * @return string
	 */
	public function getApplicationId()
	{
		return $this->applicationId;
	}

	/**
	 * Set application secret
	 * @param string $applicationSecret
	 * @throws Bitrix24Exception
	 * @return true;
	 */
	public function setApplicationSecret($applicationSecret)
	{
		if(!empty($applicationSecret))
		{
			$this->applicationSecret = $applicationSecret;
			return true;
		}
		else
		{
			throw new Bitrix24Exception('application secret not set');
		}
	}

	/**
	 * Get application secret
	 * @return string
	 */
	public function getApplicationSecret()
	{
		return $this->applicationSecret;
	}

	/**
	 * Return raw request, contain all cURL options array and API query. Data available after you try to call method call
	 * numbers of array keys is const of cURL module. Example: CURLOPT_RETURNTRANSFER = 19913
	 * @return array | null
	 */
	public function getRawRequest()
	{
		return $this->rawRequest;
	}

	/**
	 * Return result from function curl_getinfo. Data available after you try to call method call
	 * @return array | null
	 */
	public function getRequestInfo()
	{
		return $this->requestInfo;
	}

	/**
	 * Return additional parameters of last api-call. Data available after you try to call method call
	 * @return array | null
	 */
	public function getMethodParameters()
	{
		return $this->methodParameters;
	}

	/**
	 * Execute a request API to Bitrix24 using cURL
	 * @param string $url
	 * @param array $additionalParameters
	 * @throws Bitrix24Exception
	 * @return array
	 */
	protected function executeRequest($url, array $additionalParameters = array())
	{
		/**
		 * @todo add method to set custom cURL options
		 */
		$curlOptions = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLINFO_HEADER_OUT => true,
			CURLOPT_VERBOSE => true,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT        => 5,
			CURLOPT_USERAGENT => strtolower(__CLASS__.'-PHP-SDK/v'.self::VERSION),
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($additionalParameters),
			CURLOPT_URL => $url
		);
		$this->rawRequest = $curlOptions;
		$curl = curl_init();
		curl_setopt_array($curl, $curlOptions);
		$curlResult = curl_exec($curl);
		$this->requestInfo = curl_getinfo($curl);
		$curlErrorNumber = curl_errno($curl);
		// handling network I/O errors
		if($curlErrorNumber > 0)
		{
			$errorMsg = curl_error($curl).PHP_EOL.'cURL error code: '.$curlErrorNumber.PHP_EOL;
			curl_close($curl);
			throw new Bitrix24IoException($errorMsg);
		}
		else
		{
			curl_close($curl);
		}
		if(true === $this->isSaveRawResponse)
		{
			$this->rawResponse = $curlResult;
		}
		// handling json_decode errors
		$jsonResult = json_decode($curlResult, true);
		unset($curlResult);
		$jsonErrorCode = json_last_error();
		if(is_null($jsonResult) && (JSON_ERROR_NONE != $jsonErrorCode))
		{
			/**
			 * @todo add function json_last_error_msg()
			 */
			$errorMsg = 'fatal error in function json_decode.'.PHP_EOL.'Error code: '.$jsonErrorCode.PHP_EOL;
			throw new Bitrix24Exception($errorMsg);
		}
		return $jsonResult;
	}

	/**
	 * Execute Bitrix24 REST API method
	 * @param string $methodName
	 * @param array $additionalParameters
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function call($methodName, array $additionalParameters = array())
	{
		if(is_null($this->getDomain()))
		{
			throw new Bitrix24Exception('domain not found, you must call setDomain method before');
		}
		if(is_null($this->getAccessToken()))
		{
			throw new Bitrix24Exception('access token not found, you must call setAccessToken method before');
		}
		if(0 == strlen($methodName))
		{
			throw new Bitrix24Exception('method name not found, you must set method name');
		}
		$url = 'https://'.$this->domain.'/rest/'.$methodName;
		$additionalParameters['auth'] = $this->accessToken;
		// save method parameters for debug
		$this->methodParameters = $additionalParameters;
		// is secure api-call?
		$isSecureCall = false;
		if(array_key_exists('state', $additionalParameters))
		{
			$isSecureCall = true;
		}
		// execute request
		$requestResult = $this->executeRequest($url, $additionalParameters);
		// check errors and throw exception if errors exists
		$this->handleBitrix24APILevelErrors($requestResult, $methodName);
		// handling security sign for secure api-call
		if($isSecureCall)
		{
			if(array_key_exists('signature', $requestResult))
			{
				// check signature structure
				if (strpos($requestResult['signature'], '.') === false)
				{
					throw new Bitrix24SecurityException('security signature is corrupted');
				}
				if(is_null($this->getMemberId()))
				{
					throw new Bitrix24Exception('member-id not found, you must call setMemberId method before');
				}
				if(is_null($this->getApplicationSecret()))
				{
					throw new Bitrix24Exception('application secret not found, you must call setApplicationSecret method before');
				}
				// prepare
				$key = md5($this->getMemberId().$this->getApplicationSecret());
				$delimiterPosition = strrpos($requestResult['signature'], '.');
				$dataToDecode = substr($requestResult['signature'], 0, $delimiterPosition);
				$signature = base64_decode(substr($requestResult['signature'], $delimiterPosition + 1));
				// compare signatures
				$hash = hash_hmac('sha256', $dataToDecode, $key, true);
				if ($hash !== $signature)
				{
					throw new Bitrix24SecurityException('security signatures not same, bad request');
				}
				// decode
				$arClearData = json_decode(base64_decode($dataToDecode), true);
				// handling json_decode errors
				$jsonErrorCode = json_last_error();
				if(is_null($arClearData) && (JSON_ERROR_NONE != $jsonErrorCode))
				{
					/**
					 * @todo add function json_last_error_msg()
					 */
					$errorMsg = 'fatal error in function json_decode.'.PHP_EOL.'Error code: '.$jsonErrorCode.PHP_EOL;
					throw new Bitrix24Exception($errorMsg);
				}
				// merge dirty and clear data
				unset($arClearData['state']);
				$requestResult ["result"] = array_merge($requestResult ["result"], $arClearData);
			}
			else
			{
				throw new Bitrix24SecurityException('security signature in api-response not found');
			}
		}
		return $requestResult;
	}

	/**
	 * Handling bitrix24 api-level errors
	 * @param $arRequestResult
	 * @param $methodName
	 * @return null
	 * @throws Bitrix24ApiException
	 */
	protected function handleBitrix24APILevelErrors($arRequestResult, $methodName)
	{
		if (array_key_exists('error', $arRequestResult))
		{
			$errName = '';
			$errDescription = '';
			if (isset($arRequestResult['error_description'])) {
				$errDescription = $arRequestResult['error_description'].PHP_EOL;
			}
			if (!strlen($errDescription)) {
				$errName = $arRequestResult['error'].PHP_EOL;
			}
			$errorMsg = $errName.$errDescription.'in call: [ '.$methodName.' ]';
			throw new Bitrix24ApiException($errorMsg);
		}
		return null;
	}
	/**
	 * Get raw response from Bitrix24 before json_decode call, method available only in debug mode.
	 * To activate debug mode you must before set to true flag isSaveRawResponse in class construct
	 * @throws Bitrix24Exception
	 * @return string
	 */
	public function getRawResponse()
	{
		if(false === $this->isSaveRawResponse)
		{
			throw new Bitrix24Exception('you must before set to true flag isSaveRawResponse in class construct');
		}
		return $this->rawResponse;
	}

	/**
	 * Get new access token
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function getNewAccessToken()
	{
		$domain = $this->getDomain();
		$applicationId = $this->getApplicationId();
		$applicationSecret = $this->getApplicationSecret();
		$refreshToken = $this->getRefreshToken();
		$applicationScope = $this->getApplicationScope();
		$redirectUri = $this->getRedirectUri();

		if(is_null($domain))
		{
			throw new Bitrix24Exception('domain not found, you must call setDomain method before');
		}
		elseif(is_null($applicationId))
		{
			throw new Bitrix24Exception('application id not found, you must call setApplicationId method before');
		}
		elseif(is_null($applicationSecret))
		{
			throw new Bitrix24Exception('application id not found, you must call setApplicationSecret method before');
		}
		elseif(is_null($refreshToken))
		{
			throw new Bitrix24Exception('application id not found, you must call setRefreshToken method before');
		}
		elseif(is_null($applicationScope))
		{
			throw new Bitrix24Exception('application scope not found, you must call setApplicationScope method before');
		}
		elseif(is_null($redirectUri))
		{
			throw new Bitrix24Exception('application redirect URI not found, you must call setRedirectUri method before');
		}

		$url = 'https://'.$domain."/oauth/token/".
			"?client_id=".urlencode($applicationId).
			"&grant_type=refresh_token".
			"&client_secret=".$applicationSecret.
			"&refresh_token=".$refreshToken.
			'&scope='.implode(',', array_map('urlencode', array_unique($applicationScope))).
			'&redirect_uri='.urlencode($redirectUri);
		$requestResult = $this->executeRequest($url);
		// handling bitrix24 api-level errors
		$this->handleBitrix24APILevelErrors($requestResult, 'refresh access token');
		return $requestResult;
	}

	/**
	 * Сheck is access token expire, сall list of all available api-methods from B24 portal with current access token
	 * if we have an error code expired_token then return true else return false
	 * @throws Bitrix24Exception
	 * @return boolean
	 */
	public function isAccessTokenExpire()
	{
		$isTokenExpire = false;
		$accessToken = $this->getAccessToken();
		$domain = $this->getDomain();

		if(is_null($domain))
		{
			throw new Bitrix24Exception('domain not found, you must call setDomain method before');
		}
		elseif(is_null($accessToken))
		{
			throw new Bitrix24Exception('application id not found, you must call setAccessToken method before');
		}
		$url = 'https://'.$domain."/rest/methods.json?auth=".$accessToken.'&full=true';
		$requestResult = $this->executeRequest($url);
		if('expired_token' == $requestResult['error'])
		{
			$isTokenExpire = true;
		}
		return $isTokenExpire;
	}// end of isTokenExpire

	/**
	 * Get list of all methods available for current application
	 * @param array | null $applicationScope
	 * @param bool $isFull
	 * @return array
	 * @throws Bitrix24Exception
	 */
	public function getАvailableMethoods($applicationScope = array(), $isFull=false)
	{
		$accessToken = $this->getAccessToken();
		$domain = $this->getDomain();

		if(is_null($domain))
		{
			throw new Bitrix24Exception('domain not found, you must call setDomain method before');
		}
		elseif(is_null($accessToken))
		{
			throw new Bitrix24Exception('application id not found, you must call setAccessToken method before');
		}

		$showAll = '';
		if(TRUE === $isFull)
		{
			$showAll = '&full=true';
		}
		$scope='';
		if(is_null($applicationScope))
		{
			$scope = '&scope';
		}
		elseif(count(array_unique($applicationScope)) > 0)
		{
			$scope = '&scope='.implode(',', array_map('urlencode', array_unique($applicationScope)));
		}
		$url = 'https://'.$domain."/rest/methods.json?auth=".$accessToken.$showAll.$scope;
		$requestResult = $this->executeRequest($url);
		return $requestResult;
	}

	/**
	 * get list of scope for current application from bitrix24 api
	 * @param bool $isFull
	 * @throws Bitrix24Exception
	 * @return array
	 */
	public function getScope($isFull=false)
	{
		$accessToken = $this->getAccessToken();
		$domain = $this->getDomain();

		if(is_null($domain))
		{
			throw new Bitrix24Exception('domain not found, you must call setDomain method before');
		}
		elseif(is_null($accessToken))
		{
			throw new Bitrix24Exception('application id not found, you must call setAccessToken method before');
		}
		$showAll = '';
		if(TRUE === $isFull)
		{
			$showAll = '&full=true';
		}
		$url = 'https://'.$domain."/rest/scope.json?auth=".$accessToken.$showAll;
		$requestResult = $this->executeRequest($url);
		return $requestResult;
	}
}
