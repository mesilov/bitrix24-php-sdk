<?php

namespace Bitrix24;

use Bitrix24\Contracts\iBitrix24;
use Bitrix24\Stub\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class Bitrix24.
 *
 * @author Mesilov Maxim <mesilov.maxim@gmail.com>
 * @copyright 2013 - 2016 Mesilov Maxim
 */
class bitrix24 implements iBitrix24
{
    /**
     * SDK version.
     */
    const VERSION = '1.0';

    /**
     * access token.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * refresh token.
     *
     * @var string
     */
    protected $refreshToken;

    /**
     * domain.
     *
     * @var string
     */
    protected $domain;

    /**
     * scope.
     *
     * @var array
     */
    protected $applicationScope = [];

    /**
     * application id.
     *
     * @var string
     */
    protected $applicationId;

    /**
     * application secret.
     *
     * @var string
     */
    protected $applicationSecret;

    /**
     * raw request, contain all cURL options array and API query.
     *
     * @var array
     */
    protected $rawRequest;

    /**
     * @var array, contain all api-method parameters, vill be available after call method
     */
    protected $methodParameters;

    /**
     * request info data structure акщь curl_getinfo function.
     *
     * @var array
     */
    protected $requestInfo;

    /**
     * @var bool if true raw response from bitrix24 will be available from method getRawResponse, this is debug mode
     */
    protected $isSaveRawResponse = false;

    /**
     * @var array raw response from bitrix24
     */
    protected $rawResponse;

    /**
     * @var string redirect URI from application settings
     */
    protected $redirectUri;

    /**
     * @var string portal GUID
     */
    protected $memberId;

    /**
     * @var array custom options for cURL
     */
    protected $customCurlOptions;
    /**
     * PSR-3 compatible logger
     * use only from wrappers methods log*.
     *
     * @see https://github.com/Seldaek/monolog
     *
     * @var \Monolog\Logger
     */
    protected $log;

    /**
     * Create a object to work with Bitrix24 REST API service.
     *
     * @param bool                 $isSaveRawResponse - if true raw response from bitrix24 will be available from method getRawResponse, this is debug mode
     * @param null|LoggerInterface $obLogger          - instance of \Monolog\Logger
     *
     * @throws Bitrix24Exception
     *
     * @return Bitrix24
     */
    public function __construct($isSaveRawResponse = false, LoggerInterface $obLogger = null)
    {
        if (!extension_loaded('curl')) {
            throw new Bitrix24Exception('cURL extension must be installed to use this library');
        }
        if (!is_bool($isSaveRawResponse)) {
            throw new Bitrix24Exception('isSaveRawResponse flag must be boolean');
        }
        $this->isSaveRawResponse = $isSaveRawResponse;
        if ($obLogger !== null) {
            /*
             * @var \Monolog\Logger
             */
            $this->log = clone $obLogger;
        } else {
            // dev/null logger
            /*
             * @var \Monolog\Logger
             */
            $this->log = new Logger();
        }
    }

    /**
     * Get a random string to sign protected api-call. Use salt for argument "state" in secure api-call
     * random string is a result of mt_rand function.
     *
     * @return int
     */
    public function getSecuritySignSalt()
    {
        return mt_rand();
    }

    /**
     * Set member ID — portal GUID.
     *
     * @param string $memberId
     *
     * @throws Bitrix24Exception
     *
     * @return true;
     */
    public function setMemberId($memberId)
    {
        if ('' === $memberId) {
            throw new Bitrix24Exception('memberId is empty');
        } elseif (null === $memberId) {
            throw new Bitrix24Exception('memberId is null');
        }
        $this->memberId = $memberId;

        return true;
    }

    /**
     * Get memeber ID.
     *
     * @return string | null
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Set redirect URI.
     *
     * @param string $redirectUri
     *
     * @throws Bitrix24Exception
     *
     * @return true;
     */
    public function setRedirectUri($redirectUri)
    {
        if ('' === $redirectUri) {
            throw new Bitrix24Exception('redirect URI is empty');
        }
        $this->redirectUri = $redirectUri;

        return true;
    }

    /**
     * Get redirect URI.
     *
     * @return string | null
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set access token.
     *
     * @param string $accessToken
     *
     * @throws Bitrix24Exception
     *
     * @return true;
     */
    public function setAccessToken($accessToken)
    {
        if ('' === $accessToken) {
            throw new Bitrix24Exception('access token is empty');
        }
        $this->accessToken = $accessToken;

        return true;
    }

    /**
     * Get access token.
     *
     * @return string | null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set refresh token.
     *
     * @param $refreshToken
     *
     * @throws Bitrix24Exception
     *
     * @return true;
     */
    public function setRefreshToken($refreshToken)
    {
        if ('' === $refreshToken) {
            throw new Bitrix24Exception('refresh token is empty');
        }
        $this->refreshToken = $refreshToken;

        return true;
    }

    /**
     * Get refresh token.
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Set domain.
     *
     * @param $domain
     *
     * @throws Bitrix24Exception
     *
     * @return true;
     */
    public function setDomain($domain)
    {
        if ('' === $domain) {
            throw new Bitrix24Exception('domain is empty');
        }
        $this->domain = $domain;

        return true;
    }

    /**
     * Get domain.
     *
     * @return string | null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set application scope.
     *
     * @param array $applicationScope
     *
     * @throws Bitrix24Exception
     *
     * @return bool
     */
    public function setApplicationScope(array $applicationScope)
    {
        if (is_array($applicationScope) && count($applicationScope) > 0) {
            $this->applicationScope = $applicationScope;

            return true;
        } else {
            throw new Bitrix24Exception('application scope not set');
        }
    }

    /**
     * Get application scope.
     */
    public function getApplicationScope()
    {
        return $this->applicationScope;
    }

    /**
     * Set application id.
     *
     * @param string $applicationId
     *
     * @throws Bitrix24Exception
     *
     * @return true;
     */
    public function setApplicationId($applicationId)
    {
        if ('' === $applicationId) {
            throw new Bitrix24Exception('application id is empty');
        }
        $this->applicationId = $applicationId;

        return true;
    }

// end of SetApplicationId

    /**
     * Get application id.
     *
     * @return string
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * Set application secret.
     *
     * @param string $applicationSecret
     *
     * @throws Bitrix24Exception
     *
     * @return true;
     */
    public function setApplicationSecret($applicationSecret)
    {
        if ('' === $applicationSecret) {
            throw new Bitrix24Exception('application secret is empty');
        }
        $this->applicationSecret = $applicationSecret;

        return true;
    }

    /**
     * Get application secret.
     *
     * @return string
     */
    public function getApplicationSecret()
    {
        return $this->applicationSecret;
    }

    /**
     * Set custom cURL options, overriding default ones.
     *
     * @link http://php.net/manual/en/function.curl-setopt.php
     *
     * @param array $options - array(CURLOPT_XXX => value1, CURLOPT_XXX2 => value2,...)
     *
     * @return bool
     */
    public function setCustomCurlOptions($options)
    {
        $this->customCurlOptions = $options;

        return true;
    }

    /**
     * Return raw request, contain all cURL options array and API query. Data available after you try to call method call
     * numbers of array keys is const of cURL module. Example: CURLOPT_RETURNTRANSFER = 19913.
     *
     * @return array | null
     */
    public function getRawRequest()
    {
        return $this->rawRequest;
    }

    /**
     * Return result from function curl_getinfo. Data available after you try to call method call.
     *
     * @return array | null
     */
    public function getRequestInfo()
    {
        return $this->requestInfo;
    }

    /**
     * Return additional parameters of last api-call. Data available after you try to call method call.
     *
     * @return array | null
     */
    public function getMethodParameters()
    {
        return $this->methodParameters;
    }

    /**
     * Execute a request API to Bitrix24 using cURL.
     *
     * @param string $url
     * @param array  $additionalParameters
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    protected function executeRequest($url, array $additionalParameters = [])
    {
        $curlOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_VERBOSE        => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_USERAGENT      => strtolower(__CLASS__.'-PHP-SDK/v'.self::VERSION),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($additionalParameters),
            CURLOPT_URL            => $url,
        ];

        if (is_array($this->customCurlOptions)) {
            foreach ($this->customCurlOptions as $customCurlOptionKey => $customCurlOptionValue) {
                $curlOptions[$customCurlOptionKey] = $customCurlOptionValue;
            }
        }

        $this->rawRequest = $curlOptions;
        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);
        $curlResult = curl_exec($curl);
        $this->requestInfo = curl_getinfo($curl);
        $this->log->debug('cURL request info', [$this->requestInfo]);
        $curlErrorNumber = curl_errno($curl);
        // handling network I/O errors
        if ($curlErrorNumber > 0) {
            $errorMsg = curl_error($curl).PHP_EOL.'cURL error code: '.$curlErrorNumber.PHP_EOL;
            curl_close($curl);
            throw new Bitrix24IoException($errorMsg);
        } else {
            curl_close($curl);
        }
        if (true === $this->isSaveRawResponse) {
            $this->rawResponse = $curlResult;
        }
        // handling json_decode errors
        $jsonResult = json_decode($curlResult, true);
        unset($curlResult);
        $jsonErrorCode = json_last_error();
        if (null === $jsonResult && (JSON_ERROR_NONE !== $jsonErrorCode)) {
            /*
             * @todo add function json_last_error_msg()
             */
            $errorMsg = 'fatal error in function json_decode.'.PHP_EOL.'Error code: '.$jsonErrorCode.PHP_EOL;
            throw new Bitrix24Exception($errorMsg);
        }

        return $jsonResult;
    }

    /**
     * Execute Bitrix24 REST API method.
     *
     * @param string $methodName
     * @param array  $additionalParameters
     *
     * @throws Bitrix24Exception
     * @throws Bitrix24ApiException
     * @throws Bitrix24TokenIsInvalid
     * @throws Bitrix24TokenIsExpired
     * @throws Bitrix24WrongClientException
     * @throws Bitrix24MethodNotFoundException
     * @throws Bitrix24SecurityException
     *
     * @return array
     */
    public function call($methodName, array $additionalParameters = [])
    {
        if (null === $this->getDomain()) {
            throw new Bitrix24Exception('domain not found, you must call setDomain method before');
        }
        if (null === $this->getAccessToken()) {
            throw new Bitrix24Exception('access token not found, you must call setAccessToken method before');
        }
        if ('' === $methodName) {
            throw new Bitrix24Exception('method name not found, you must set method name');
        }
        $url = 'https://'.$this->domain.'/rest/'.$methodName;
        $additionalParameters['auth'] = $this->accessToken;
        // save method parameters for debug
        $this->methodParameters = $additionalParameters;
        // is secure api-call?
        $isSecureCall = false;
        if (array_key_exists('state', $additionalParameters)) {
            $isSecureCall = true;
        }
        // execute request
        $this->log->info('call bitrix24 method', [
            'BITRIX24_DOMAIN'   => $this->domain,
            'METHOD_NAME'       => $methodName,
            'METHOD_PARAMETERS' => $additionalParameters,
        ]);
        $requestResult = $this->executeRequest($url, $additionalParameters);
        // check errors and throw exception if errors exists
        $this->handleBitrix24APILevelErrors($requestResult, $methodName, $additionalParameters);
        // handling security sign for secure api-call
        if ($isSecureCall) {
            if (array_key_exists('signature', $requestResult)) {
                // check signature structure
                if (strpos($requestResult['signature'], '.') === false) {
                    throw new Bitrix24SecurityException('security signature is corrupted');
                }
                if (null === $this->getMemberId()) {
                    throw new Bitrix24Exception('member-id not found, you must call setMemberId method before');
                }
                if (null === $this->getApplicationSecret()) {
                    throw new Bitrix24Exception('application secret not found, you must call setApplicationSecret method before');
                }
                // prepare
                $key = md5($this->getMemberId().$this->getApplicationSecret());
                $delimiterPosition = strrpos($requestResult['signature'], '.');
                $dataToDecode = substr($requestResult['signature'], 0, $delimiterPosition);
                $signature = base64_decode(substr($requestResult['signature'], $delimiterPosition + 1));
                // compare signatures
                $hash = hash_hmac('sha256', $dataToDecode, $key, true);
                if ($hash !== $signature) {
                    throw new Bitrix24SecurityException('security signatures not same, bad request');
                }
                // decode
                $arClearData = json_decode(base64_decode($dataToDecode), true);
                // handling json_decode errors
                $jsonErrorCode = json_last_error();
                if (null === $arClearData && (JSON_ERROR_NONE !== $jsonErrorCode)) {
                    /*
                     * @todo add function json_last_error_msg()
                     */
                    $errorMsg = 'fatal error in function json_decode.'.PHP_EOL.'Error code: '.$jsonErrorCode.PHP_EOL;
                    throw new Bitrix24Exception($errorMsg);
                }
                // merge dirty and clear data
                unset($arClearData['state']);
                $requestResult ['result'] = array_merge($requestResult ['result'], $arClearData);
            } else {
                throw new Bitrix24SecurityException('security signature in api-response not found');
            }
        }

        return $requestResult;
    }

    /**
     * Handling bitrix24 api-level errors.
     *
     * @param $arRequestResult
     * @param $methodName
     * @param array $additionalParameters
     *
     * @throws Bitrix24ApiException
     * @throws Bitrix24TokenIsInvalid
     * @throws Bitrix24TokenIsExpired
     * @throws Bitrix24WrongClientException
     * @throws Bitrix24MethodNotFoundException
     *
     * @return null
     */
    protected function handleBitrix24APILevelErrors($arRequestResult, $methodName, array $additionalParameters = [])
    {
        if (array_key_exists('error', $arRequestResult)) {
            $errorMsg = sprintf('%s - %s in call [%s] for domain [%s]',
                $arRequestResult['error'],
                (array_key_exists('error_description', $arRequestResult) ? $arRequestResult['error_description'] : ''),
                $methodName,
                $this->getDomain());
            $this->log->error($errorMsg, [
                // response
                'REQUEST_RESULT' => $arRequestResult,
                // query
                'METHOD_NAME'           => $methodName,
                'ADDITIONAL_PARAMETERS' => $additionalParameters,
                // portal specific settings
                'B24_DOMAIN'        => $this->getDomain(),
                'B24_MEMBER_ID'     => $this->getMemberId(),
                'B24_ACCESS_TOKEN'  => $this->getAccessToken(),
                'B24_REFRESH_TOKEN' => $this->getRefreshToken(),
                // application settings
                'APPLICATION_SCOPE'  => $this->getApplicationScope(),
                'APPLICATION_ID'     => $this->getApplicationId(),
                'APPLICATION_SECRET' => $this->getApplicationSecret(),
                'REDIRECT_URI'       => $this->getRedirectUri(),
                // network
                'RAW_REQUEST'       => $this->getRawRequest(),
                'CURL_REQUEST_INFO' => $this->getRequestInfo(), ]);
            // throw specific API-level exceptions
            switch (strtoupper(trim($arRequestResult['error']))) {
                case 'WRONG_CLIENT':
                    throw new Bitrix24WrongClientException($errorMsg);
                case 'ERROR_METHOD_NOT_FOUND':
                    throw new Bitrix24MethodNotFoundException($errorMsg);
                case 'INVALID_TOKEN':
                    throw new Bitrix24TokenIsInvalid($errorMsg);
                case 'EXPIRED_TOKEN':
                    throw new Bitrix24TokenIsExpired($errorMsg);
                default:
                    throw new Bitrix24ApiException($errorMsg);
            }
        }

        return;
    }

    /**
     * Get raw response from Bitrix24 before json_decode call, method available only in debug mode.
     * To activate debug mode you must before set to true flag isSaveRawResponse in class construct.
     *
     * @throws Bitrix24Exception
     *
     * @return string
     */
    public function getRawResponse()
    {
        if (false === $this->isSaveRawResponse) {
            throw new Bitrix24Exception('you must before set to true flag isSaveRawResponse in class construct');
        }

        return $this->rawResponse;
    }

    /**
     * Get new access token.
     *
     * @throws Bitrix24Exception
     * @throws Bitrix24ApiException
     * @throws Bitrix24TokenIsInvalid
     * @throws Bitrix24TokenIsExpired
     * @throws Bitrix24WrongClientException
     * @throws Bitrix24MethodNotFoundException
     *
     * @return array
     */
    public function getNewAccessToken()
    {
        $domain = $this->getDomain();
        $applicationId = $this->getApplicationId();
        $applicationSecret = $this->getApplicationSecret();
        $refreshToken = $this->getRefreshToken();
        $applicationScope = $this->getApplicationScope();
        $redirectUri = $this->getRedirectUri();

        if (null === $domain) {
            throw new Bitrix24Exception('domain not found, you must call setDomain method before');
        } elseif (null === $applicationId) {
            throw new Bitrix24Exception('application id not found, you must call setApplicationId method before');
        } elseif (null === $applicationSecret) {
            throw new Bitrix24Exception('application id not found, you must call setApplicationSecret method before');
        } elseif (null === $refreshToken) {
            throw new Bitrix24Exception('application id not found, you must call setRefreshToken method before');
        } elseif (0 === count($applicationScope)) {
            throw new Bitrix24Exception('application scope not found, you must call setApplicationScope method before');
        } elseif (null === $redirectUri) {
            throw new Bitrix24Exception('application redirect URI not found, you must call setRedirectUri method before');
        }

        $url = 'https://'.$domain.'/oauth/token/'.
            '?client_id='.urlencode($applicationId).
            '&grant_type=refresh_token'.
            '&client_secret='.$applicationSecret.
            '&refresh_token='.$refreshToken.
            '&scope='.implode(',', array_map('urlencode', array_unique($applicationScope))).
            '&redirect_uri='.urlencode($redirectUri);
        $requestResult = $this->executeRequest($url);
        // handling bitrix24 api-level errors
        $this->handleBitrix24APILevelErrors($requestResult, 'refresh access token');

        return $requestResult;
    }

    /**
     * Authorize and get first access token.
     *
     * @param $code
     *
     * @throws Bitrix24ApiException
     * @throws Bitrix24Exception
     * @throws Bitrix24IoException
     * @throws Bitrix24MethodNotFoundException
     * @throws Bitrix24TokenIsExpired
     * @throws Bitrix24TokenIsInvalid
     * @throws Bitrix24WrongClientException
     *
     * @return array
     */
    public function getFirstAccessToken($code)
    {
        $domain = $this->getDomain();
        $applicationId = $this->getApplicationId();
        $applicationSecret = $this->getApplicationSecret();
        //$refreshToken = $this->getRefreshToken();
        $applicationScope = $this->getApplicationScope();
        $redirectUri = $this->getRedirectUri();

        if (null === $domain) {
            throw new Bitrix24Exception('domain not found, you must call setDomain method before');
        } elseif (null === $applicationId) {
            throw new Bitrix24Exception('application id not found, you must call setApplicationId method before');
        } elseif (null === $applicationSecret) {
            throw new Bitrix24Exception('application id not found, you must call setApplicationSecret method before');
        } elseif (0 === count($applicationScope)) {
            throw new Bitrix24Exception('application scope not found, you must call setApplicationScope method before');
        } elseif (null === $redirectUri) {
            throw new Bitrix24Exception('application redirect URI not found, you must call setRedirectUri method before');
        }

        $url = 'https://'.$domain.'/oauth/token/'.
            '?client_id='.urlencode($applicationId).
            '&grant_type=authorization_code'.
            '&client_secret='.$applicationSecret.
            '&scope='.implode(',', array_map('urlencode', array_unique($applicationScope))).
            '&redirect_uri='.urlencode($redirectUri).
            '&code='.urlencode($code);

        $requestResult = $this->executeRequest($url);
        // handling bitrix24 api-level errors
        $this->handleBitrix24APILevelErrors($requestResult, 'get first access token');

        return $requestResult;
    }

    /**
     * Check is access token expire, call list of all available api-methods from B24 portal with current access token
     * if we have an error code expired_token then return true else return false.
     *
     * @throws Bitrix24Exception
     * @throws Bitrix24ApiException
     * @throws Bitrix24TokenIsInvalid
     * @throws Bitrix24TokenIsExpired
     * @throws Bitrix24WrongClientException
     * @throws Bitrix24MethodNotFoundException
     *
     * @return bool
     */
    public function isAccessTokenExpire()
    {
        $isTokenExpire = false;
        $accessToken = $this->getAccessToken();
        $domain = $this->getDomain();

        if (null === $domain) {
            throw new Bitrix24Exception('domain not found, you must call setDomain method before');
        } elseif (null === $accessToken) {
            throw new Bitrix24Exception('application id not found, you must call setAccessToken method before');
        }
        $url = 'https://'.$domain.'/rest/app.info?auth='.$accessToken;
        $requestResult = $this->executeRequest($url);
        if ('expired_token' === $requestResult['error']) {
            $isTokenExpire = true;
        } else {
            // handle other errors
            $this->handleBitrix24APILevelErrors($requestResult, 'app.info');
        }

        return $isTokenExpire;
    }

// end of isTokenExpire

    /**
     * Get list of all methods available for current application.
     *
     * @param array | null $applicationScope
     * @param bool         $isFull
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function getAvailableMethods(array $applicationScope = [], $isFull = false)
    {
        $accessToken = $this->getAccessToken();
        $domain = $this->getDomain();

        if (null === $domain) {
            throw new Bitrix24Exception('domain not found, you must call setDomain method before');
        } elseif (null === $accessToken) {
            throw new Bitrix24Exception('application id not found, you must call setAccessToken method before');
        }

        $showAll = '';
        if (true === $isFull) {
            $showAll = '&full=true';
        }
        $scope = '';
        if (null === $applicationScope) {
            $scope = '&scope';
        } elseif (count(array_unique($applicationScope)) > 0) {
            $scope = '&scope='.implode(',', array_map('urlencode', array_unique($applicationScope)));
        }
        $url = 'https://'.$domain.'/rest/methods.json?auth='.$accessToken.$showAll.$scope;
        $requestResult = $this->executeRequest($url);

        return $requestResult;
    }

    /**
     * get list of scope for current application from bitrix24 api.
     *
     * @param bool $isFull
     *
     * @throws Bitrix24Exception
     *
     * @return array
     */
    public function getScope($isFull = false)
    {
        $accessToken = $this->getAccessToken();
        $domain = $this->getDomain();

        if (null === $domain) {
            throw new Bitrix24Exception('domain not found, you must call setDomain method before');
        } elseif (null === $accessToken) {
            throw new Bitrix24Exception('application id not found, you must call setAccessToken method before');
        }
        $showAll = '';
        if (true === $isFull) {
            $showAll = '&full=true';
        }
        $url = 'https://'.$domain.'/rest/scope.json?auth='.$accessToken.$showAll;
        $requestResult = $this->executeRequest($url);

        return $requestResult;
    }
}
