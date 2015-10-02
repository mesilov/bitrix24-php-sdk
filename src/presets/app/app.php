<?php
namespace Bitrix24\Presets\App;
/**
 * Class App
 * @package Bitrix24\Presets
 * @link https://training.bitrix24.com/rest_help/general/app_info.php
 */
class App
{
	/**
	 * @var string Specifies the application ID.
	 */
	const CODE = 'CODE';
	/**
	 * @var string Specifies the application version
	 */
	const VERSION = 'VERSION';
	/**
	 * @var string The application status. It can be one of the following values:
	 * 	F (Free) - free;
	 * 	D (Demo) - demo version;
	 * 	T (Trial) - trial version, time limited;
	 * 	P (Paid) - the application has been purchased.
	 */
	const STATUS = 'STATUS';
	/**
	 * @var string application status id free
	 */
	const STATUS_FREE = 'F';
	/**
	 * @var string application status is demo
	 */
	const STATUS_DEMO = 'D';
	/**
	 * @var string application status is trial
	 */
	const STATUS_TRIAL = 'T';
	/**
	 * @var string application status is paid
	 */
	const STATUS_PAID = 'P';
	/**
	 * @var string [Y|N]: if Y, the application license or trial period has expired.
	 */
	const PAYMENT_EXPIRED = 'PAYMENT_EXPIRED';
	/**
	 * @var string Specifies the number of days left until the application license or trial period expires. After the license expires,
	 * the application may remain fully functional for a certain grace period to account for possible delay of payment.
	 * Finally, if the license has not been renewed, the application is reverted back to demo mode or cease functioning at all.
	 * In that case, the value of  PAYMENT_EXPIRED is Y, and the value of DAYS is negative.
	 */
	const DAYS = 'DAYS';
	/**
	 * @var string information about portal licence
	 */
	const LICENSE = 'LICENSE';
	/**
	 * @var string
	 */
	const PORTAL_LICENSE_PROJECT = 'project';
	/**
	 * @var string
	 */
	const PORTAL_LICENSE_CORPORATION = 'corporation';
	/**
	 * @var string
	 */
	const PORTAL_LICENSE_COMPANY = 'company';
	/**
	 * @var string
	 */
	const PORTAL_LICENSE_TEAM = 'team';
	/**
	 * @var string
	 */
	const PORTAL_LICENSE_DEMO = 'demo';
	/**
	 * @var string
	 */
	const PORTAL_LICENSE_NFR = 'nfr';
	/**
	 * @var string
	 */
	const PORTAL_LICENSE_TEAM_PLUS = 'tf';
}