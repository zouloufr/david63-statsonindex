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
	'ACTIVITY'				=> 'Miembros activos',

	'EXTENDED'				=> 'Estadísticas ampliadas',

	'FILE_PER_DAY'			=> 'Adjuntos por día <strong>%1$s</strong>',
	'FILES_PER_USER'		=> 'Adjuntos por miembro <strong>%1$s</strong>',
	'FILES_PER_YEAR'		=> 'Adjuntos por año <strong>%1$s</strong>',

	'NONE'					=> 'Ninguno',

	'POST_PER_DAY'			=> 'Mensajes por día <strong>%1$s</strong>',
	'POSTS_PER_TOPIC'		=> 'Mensajes por tema <strong>%1$s</strong>',
	'POSTS_PER_USER'		=> 'Mensajes por miembro <strong>%1$s</strong>',
	'POSTS_PER_YEAR'		=> 'Mensajes por año <strong>%1$s</strong>',

	'START_DATE'			=> 'Estamos en línea desde',
	'SUMMARY'				=> '<strong>Resumen</strong>',

	'TFHOUR_POSTS'			=> 'Nuevos mensajes <strong>%1$s</strong>',
	'TFHOUR_TOPICS'			=> 'Nuevos temas <strong>%1$s</strong>',
	'TFHOUR_USERS'			=> 'Nuevos usuarios <strong>%1$s</strong>',
	'TOPIC_PER_DAY'			=> 'Temas por día <strong>%1$s</strong>',
	'TOPICS_PER_USER'		=> 'Temas por miembro <strong>%1$s</strong>',
	'TOPICS_PER_YEAR'		=> 'Temas por año <strong>%1$s</strong>',
	'TOTAL_FILES'			=> 'Adjuntos totales <strong>%1$s</strong>',
	'TWENTYFOURHOUR_STATS'	=> 'Actividad durante las últimas 24 horas',

	'USER_PER_DAY'			=> 'Miembros por día <strong>%1$s</strong>',
	'USERS_PER_YEAR'		=> 'Miembros por año <strong>%1$s</strong>',
	'USERS_TFHOUR_TOTAL'	=> array(
		1	=> '%1$s Usuario activo en las últimas 24 horas',
		2	=> '%1$s Usuarios activos en las últimas 24 horas',
	),

	// Reformat these for output consisency
	'TOTAL_POSTS_COUNT'		=> 'Mensajes totales <strong>%1$s</strong>',
	'TOTAL_TOPICS'			=> 'Temas totales <strong>%1$s</strong>',
	'TOTAL_USERS'			=> 'Miembros totales <strong>%1$s</strong>',
));
