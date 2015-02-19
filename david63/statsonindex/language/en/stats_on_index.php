<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'EXTENDED'			=> '<strong>Extended statistics</strong>',

	'FILE_PER_DAY'		=> array(
		2	=> 'Attachments per day <strong>%1$s</strong>',
	),
	'FILES_PER_USER'	=> array(
		2	=> 'Attachments per member <strong>%1$s</strong>',
	),
	'FILES_PER_YEAR'	=> array(
		2	=> 'Attachments per year <strong>%1$s</strong>',
	),

	'NONE'				=> 'None',

	'POST_PER_DAY'		=> array(
		2	=> 'Posts per day <strong>%1$s</strong>',
	),
	'POSTS_PER_TOPIC'	=> array(
		2	=> 'Posts per topic <strong>%1$s</strong>',
	),
	'POSTS_PER_USER'	=> array(
		2	=> 'Posts per member <strong>%1$s</strong>',
	),
	'POSTS_PER_YEAR'	=> array(
		2	=> 'Posts per year <strong>%1$s</strong>',
	),

	'START_DATE'		=> 'We have been online since',
	'SUMMARY'			=> '<strong>Summary</strong>',

	'TOPIC_PER_DAY'		=> array(
		2	=> 'Topics per day <strong>%1$s</strong>',
	),
	'TOPICS_PER_USER'	=> array(
		2	=> 'Topics per member <strong>%1$s</strong>',
	),
	'TOPICS_PER_YEAR'	=> array(
		2	=> 'Topics per year <strong>%1$s</strong>',
	),
	'TOTAL_FILES'		=> array(
		2	=> 'Total attachments <strong>%1$s</strong>',
	),

	'USER_PER_DAY'		=> array(
		2	=> 'Members per day <strong>%1$s</strong>',
	),
	'USERS_PER_YEAR'	=> array(
		2	=> 'Members per year <strong>%1$s</strong>',
	),

	// Reformat these for output consisency
	'TOTAL_POSTS_COUNT'	=> array(
		2	=> 'Total posts <strong>%1$s</strong>',
	),
	'TOTAL_TOPICS'		=> array(
		2	=> 'Total topics <strong>%1$s</strong>',
	),
	'TOTAL_USERS'		=> array(
		2	=> 'Total members <strong>%1$s</strong>',
	),

));
