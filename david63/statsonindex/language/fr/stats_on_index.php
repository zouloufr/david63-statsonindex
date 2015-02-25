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
	'ACTIVITY'				=> 'Membres actifs <strong>»»</strong>',

	'EXTENDED'				=> 'Statistiques détaillées <strong>»»</strong>',

	'FILE_PER_DAY'			=> 'Pièces jointes par jour <strong>%1$s</strong>',
	'FILES_PER_USER'		=> 'Pièces jointes par membre <strong>%1$s</strong>',
	'FILES_PER_YEAR'		=> 'Pièces jointes par an <strong>%1$s</strong>',

	'NONE'					=> 'Aucun',

	'POST_PER_DAY'			=> 'Messages par jour <strong>%1$s</strong>',
	'POSTS_PER_TOPIC'		=> 'Messages par sujet <strong>%1$s</strong>',
	'POSTS_PER_USER'		=> 'Messages par membre <strong>%1$s</strong>',
	'POSTS_PER_YEAR'		=> 'Messages par an <strong>%1$s</strong>',

	'START_DATE'			=> 'Nous sommes en ligne depuis',
	'SUMMARY'				=> '<strong>Résumé</strong>',

	'TFHOUR_POSTS'			=> 'Nouveaux messages <strong>%1$s</strong>',
	'TFHOUR_TOPICS'			=> 'Nouveaux sujets <strong>%1$s</strong>',
	'TFHOUR_USERS'			=> 'Nouveaux membres <strong>%1$s</strong>',
	'TOPIC_PER_DAY'			=> 'Sujets par jour <strong>%1$s</strong>',
	'TOPICS_PER_USER'		=> 'Sujets par membre <strong>%1$s</strong>',
	'TOPICS_PER_YEAR'		=> 'Sujets par an <strong>%1$s</strong>',
	'TOTAL_FILES'			=> 'Nombre total de PJ <strong>%1$s</strong>',
	'TWENTYFOURHOUR_STATS'	=> 'Activité durant les dernières 24 heures',

	'USER_PER_DAY'			=> 'Membres par jour <strong>%1$s</strong>',
	'USERS_PER_YEAR'		=> 'Membres par an <strong>%1$s</strong>',
	'USERS_TFHOUR_TOTAL'	=> array(
		1	=> '%1$s Utilisateur actif durant les dernières 24 heures',
		2	=> '%1$s Utilisateurs actifs durant les dernières 24 heures',
	),

	// Reformat these for output consisency
	'TOTAL_POSTS_COUNT'		=> 'Nombre total de messages <strong>%1$s</strong>',
	'TOTAL_TOPICS'			=> 'Nombre total de sujets <strong>%1$s</strong>',
	'TOTAL_USERS'			=> 'Nombre total de membres <strong>%1$s</strong>',
));
