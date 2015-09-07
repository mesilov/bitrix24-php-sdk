<?php
namespace Bitrix24\Presets\Task\Item;
/**
 * Class Fields
 * @link http://www.bitrixsoft.com/rest_help/tasks/fields.php
 * @package Bitrix24\Presets\Task\Item
 */
class Fields
{
	/**
	 * @var string Specifies the task name.	Read, write
	 */
	const TITLE = 'TITLE';
	/**
	 * @var string Specifies the task description. Read, write
	 */
	const DESCRIPTION = 'DESCRIPTION';
	/**
	 * @var string Specifies the task deadline date. Read, write
	 */
	const DEADLINE = 'DEADLINE';
	/**
	 * @var string Specifies the date when the task is scheduled to start. Read, write
	 */
	const START_DATE_PLAN = 'START_DATE_PLAN';
	/**
	 * @var string Specifies the date when the task is planned to be finished. Read, write
	 */
	const END_DATE_PLAN = 'END_DATE_PLAN';
	/**
	 * @var string Determines the task priority level. Read, write
	 */
	const PRIORITY = 'PRIORITY';
	/**
	 * @var string Contains the user ID's of persons involved in the task (shown in the user interface as participants). Read, write
	 */
	const ACCOMPLICES = 'ACCOMPLICES';
	/**
	 * @var array Contains the user ID's of persons who were set to monitor task progress and results (shown in the user interface as observers). Read, write
	 */
	const AUDITORS = 'AUDITORS';
	/**
	 * @var string Contains tags assigned to the task. To set multiple tags for a task, specify them as space separated words (plain text). Read, write
	 * The CTasks::GetList method does not return the TAGS field.
	 * The call CTaskItem::getInstance()->getTags() will return an array of the tag names.
	 */
	const TAGS ='TAGS';
	/**
	 * @var string A boolean (Y/N) value which, if set to "Y", specifies that a responsible person associated with the task is allowed to shift the deadline date. Read, write
	 */
	const ALLOW_CHANGE_DEADLINE = 'ALLOW_CHANGE_DEADLINE';
	/**
	 * @var string A boolean (Y/N) value which, if set to "Y", specifies that the task result needs to be approved by a creator. Otherwise, the task will auto close once marked as completed. Read, write
	 */
	const TASK_CONTROL = 'TASK_CONTROL';
	/**
	 * @var string Specifies the ID of a parent task. Read, write
	 */
	const PARENT_ID = 'PARENT_ID';
	/**
	 * @var string Specifies the ID of a task that needs to be completed prior to this one. Read, write
	 */
	const DEPENDS_ON = 'DEPENDS_ON';
	/**
	 * @var string Specifies the ID of a workgroup to which this task relates. Read, write
	 */
	const GROUP_ID = 'GROUP_ID';
	/**
	 * @var string The user ID of a person to whom the task is assigned. Read, write
	 */
	const RESPONSIBLE_ID = 'RESPONSIBLE_ID';
	/**
	 * @var string Specifies a time estimate for the task. Read, write
	 */
	const TIME_ESTIMATE = 'TIME_ESTIMATE';
	/**
	 * @var integer The current task ID. The identifier is unique across the database. Read
	 */
	const ID = 'ID';
	/**
	 * @var integer Specifies the user ID of a person who created the task.	Read, write
	 */
	const CREATED_BY = 'CREATED_BY';
	/**
	 * @var string A boolean (Y/N) value which, if set to "Y", specifies that the task description includes BB codes. Read
	 */
	const DESCRIPTION_IN_BBCODE = 'DESCRIPTION_IN_BBCODE';
	/**
	 * @var string A text description of the reason for rejecting the task. Read, write
	 */
	const DECLINE_REASON = 'DECLINE_REASON';
	/**
	 * @var string Determines the task's real status set using the STATUS field (see CTasks::STATE_xxx). This field is read-only.
	 */
	const REAL_STATUS = 'REAL_STATUS';
	/**
	 * @var string Use this field to set the meta status for a task. Read, write
	 * To set this field, use the CTasks::STATE_xxx constants. However, this field may return one of the CTasks::METASTATE_xxx values.
	 * For example, if a task had never been started and became overdue, this field will return CTasks::METASTATE_EXPIRED,
	 * while the real status is CTasks::STATE_NEW returned by the REAL_STATUS field.
	 */
	const STATUS = 'STATUS';
	/**
	 * @var string Contains the first name of a person to whom the task is assigned (a responsible person).	Read
	 */
	const RESPONSIBLE_NAME = 'RESPONSIBLE_NAME';
	/**
	 * @var string The last name of the task's responsible person. Read
	 */
	const RESPONSIBLE_LAST_NAME = 'RESPONSIBLE_LAST_NAME';
	/**
	 * @var string The second name of the task's responsible person. Read
	 */
	const RESPONSIBLE_SECOND_NAME = 'RESPONSIBLE_SECOND_NAME';
	/**
	 * @var \DateTime Specifies the date the task was started. Read
	 */
	const DATE_START = 'DATE_START';
	/**
	 * @var string Specifies the time required to complete the task, in minutes. Read
	 */
	const DURATION_FACT = 'DURATION_FACT';
	/**
	 * @var string 	Contains the first name of a person who created the task. Read
	 */
	const CREATED_BY_NAME = 'CREATED_BY_NAME';
	/**
	 * @var string The last name of the task creator. Read
	 */
	const CREATED_BY_LAST_NAME = 'CREATED_BY_LAST_NAME';	
	/**
	 * @var string 	The second name of the task creator. Read
	 */
	const CREATED_BY_SECOND_NAME = 'CREATED_BY_SECOND_NAME';
	/**
	 * @var string Specifies the date the task was created.	Read
	 */
	const CREATED_DATE = 'CREATED_DATE';	
	/**
	 * @var string The user ID of a person who last updated the task.	Read
	 */
	const CHANGED_BY = 'CHANGED_BY';	
	/**
	 * @var string Specifies the date the task was last updated.	Read
	 */
	const CHANGED_DATE = 'CHANGED_DATE';	
	/**
	 * @var string The user ID of a person who changed the task status.	Read
	 */
	const STATUS_CHANGED_BY = 'STATUS_CHANGED_BY';	
	/**
	 * @var string Specifies the date the task status was changed.	Read
	 */
	const STATUS_CHANGED_DATE = 'STATUS_CHANGED_DATE';	
	/**
	 * @var string The user ID of a person who completed the task.	Read
	 */
	const CLOSED_BY = 'CLOSED_BY';	
	/**
	 * @var string Specifies the date the task was completed.	Read
	 */
	const CLOSED_DATE = 'CLOSED_DATE';	
	/**
	 * @var string A GUID (globally unique identifier) associated with the task. It can be said, with a fair amount of confidence,
	 * that this identifier will always remain unique across multiple databases.	Read
	 */
	const GUID = 'GUID';	
	/**
	 * @var string The rating score given by a task creator.	Read, write
	 */
	const MARK ='MARK';	
	/**
	 * @var string Contains the date the task was last viewed in the public area by a currently logged in user.	Read
	 */
	const VIEWED_DATE = 'VIEWED_DATE';
	/**
	 * @var string 	Specifies the actual time spent for the task, in seconds.	Read
	 */
	const TIME_SPENT_IN_LOGS = 'TIME_SPENT_IN_LOGS';
	/**
	 * @var string Specifies the task external ID.	Read, write
	 */
	const XML_ID = 'XML_ID';	
	/**
	 * @var string A boolean (Y/N) value which, if set to "Y", specifies that the system keeps tracking of the time spent for the task.	Read, write
	 */
	const ALLOW_TIME_TRACKING ='ALLOW_TIME_TRACKING';
	/**
	 * @var string A boolean (Y/N) value which, if set to "Y", includes the task in the performance report.	Read, write
	 */
	const ADD_IN_REPORT = 'ADD_IN_REPORT';	
	/**
	 * @var string Specifies the ID of the forum containing comments to the task.	Read, write
	 */
	const FORUM_ID = 'FORUM_ID';	
	/**
	 * @var string Specifies the ID of the forum topic containing comments to the task.	Read, write
	 */
	const FORUM_TOPIC_ID = 'FORUM_TOPIC_ID';
	/**
	 * @var string 	Contains the number of forum comments. 	Read
	 */
	const COMMENTS_COUNT ='COMMENTS_COUNT';
	/**
	 * @var string Specifies the ID of the site on which the task was created.	Read, write
	 */
	const SITE_ID = 'SITE_ID';	
	/**
	 * @var string 	A boolean (Y/N) value which, if set to "Y", specifies that at least one of the task participants is subordinate to a current user.	Read
	 */
	const SUBORDINATE = 'SUBORDINATE';
	/**
	 * @var string Contains the ID of a template used to create the task. This field may be empty for tasks created in outdated versions.	Read
	 */
	const FORKED_BY_TEMPLATE_ID = 'FORKED_BY_TEMPLATE_ID';
}