<?php
namespace Bitrix24\Presets;

class Events
{
	/**
	 * event code when bitrix24 application has uninstall
	 */
	const ON_APP_UNINSTALL = 'ONAPPUNINSTALL';
	/**
	 * event code when bitrix24 application update
	 */
	const ON_APP_UPDATE = 'ONAPPUPDATE';
	/**
	 * event code when bitrix24 application payment
	 */
	const ON_APP_PAYMENT = 'ONAPPPAYMENT';
	/**
	 * event code when task add in bitrix24
	 */
	const ON_TASK_ADD = 'ONTASKADD';
	/**
	 * event code when task in bitrix24 has update
	 */
	const ON_TASK_UPDATE = 'ONTASKUPDATE';
	/**
	 * event code when task in bitrix24 has delete
	 */
	const ON_TASK_DELETE = 'ONTASKDELETE';
	/**
	 * event code when new user in bitrix24 has added
	 */
	const ON_USER_ADD = 'ONUSERADD';
}