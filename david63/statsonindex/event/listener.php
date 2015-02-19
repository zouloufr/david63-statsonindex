<?php
/**
*
* @package Statistics on Index Extension
* @copyright (c) 2015
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\statsonindex\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\twig\twig */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\template\twig\twig	$template	Template object
	* @param \phpbb\user                $user		User object
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\template\twig\twig $template, \phpbb\user $user)
	{
		$this->config	= $config;
		$this->template	= $template;
		$this->user		= $user;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'acp_board_settings',
			'core.user_setup'					=> 'load_language_on_setup',
			'core.index_modify_page_title'		=> 'add_stats_settings',
		);
	}

	/**
	* Set ACP board settings
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function acp_board_settings($event)
	{
		if ($event['mode'] == 'load')
		{
			$new_display_var = array(
				'title'	=> $event['display_vars']['title'],
				'vars'	=> array(),
			);

			foreach ($event['display_vars']['vars'] as $key => $content)
			{
				$new_display_var['vars'][$key] = $content;
				if ($key == 'load_birthdays')
				{
					$new_display_var['vars']['statsonindex_admin'] = array(
						'lang'		=> 'ADMIN_STATS',
						'validate'	=> 'bool',
						'type'		=> 'radio:yes_no',
						'explain' 	=> true,
					);
				}
			}
			$event->offsetSet('display_vars', $new_display_var);
		}
	}

	/**
	* Load common stats in index language files during user setup
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function load_language_on_setup($event)
	{
		$lang_set_ext	= $event['lang_set_ext'];
		$lang_set_ext[]	= array(
			'ext_name' => 'david63/statsonindex',
			'lang_set' => 'stats_on_index',
		);

		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* Update the data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_stats_settings($event)
	{
		$files_per_day		= number_format($this->config['num_files'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
		$files_per_user		= number_format($this->config['num_files'] / $this->config['num_users'], '2');
		$files_per_year		= number_format($files_per_day * 364.25, '0');

		$posts_per_day		= number_format($this->config['num_posts'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
		$posts_per_topic	= number_format($this->config['num_posts'] / $this->config['num_topics'], '2');
		$posts_per_user		= number_format($this->config['num_posts'] / $this->config['num_users'], '2');
		$posts_per_year		= number_format($posts_per_day * 364.25, '0');

		$topics_per_day		= number_format($this->config['num_topics'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
		$topics_per_user	= number_format($this->config['num_topics'] / $this->config['num_users'], '2');
		$topics_per_year	= number_format($topics_per_day * 364.25, '0');
		$total_files		= number_format($this->config['num_files'], '0');

		$users_per_day		= number_format($this->config['num_users'] / ceil((time() - $this->config['board_startdate']) / 86400), '2');
		$users_per_year		= number_format($users_per_day * 364.25, '0');

		$none = $this->user->lang('NONE');

		$this->template->assign_vars(array(
			'FILES_PER_DAY'   	=> $this->user->lang('FILES_PER_DAY', ($files_per_day == 0) ? $none : $files_per_day),
    		'FILES_PER_USER'   	=> $this->user->lang('FILES_PER_USER', ($files_per_user == 0) ? $none : $files_per_user),
			'FILES_PER_YEAR'    => $this->user->lang('FILES_PER_YEAR', ($files_per_year == 0) ? $none : $files_per_year),

			'POSTS_PER_DAY'   	=> $this->user->lang('POSTS_PER_DAY', ($posts_per_day == 0) ? $none : $posts_per_day),
    		'POSTS_PER_TOPIC'   => $this->user->lang('POSTS_PER_TOPIC', ($posts_per_topic == 0) ? $none : $posts_per_topic),
    		'POSTS_PER_USER'   	=> $this->user->lang('POSTS_PER_USER', ($posts_per_user == 0) ? $none : $posts_per_user),
			'POSTS_PER_YEAR'    => $this->user->lang('POSTS_PER_YEAR', ($posts_per_year == 0) ? $none : $posts_per_year),

    		'TOPICS_PER_DAY'   	=> $this->user->lang('TOPICS_PER_DAY', ($topics_per_day == 0) ? $none : $topics_per_day),
			'TOPICS_PER_USER'   => $this->user->lang('TOPICS_PER_USER', ($topics_per_user == 0) ? $none : $topics_per_user),
    		'TOPICS_PER_YEAR'   => $this->user->lang('TOPICS_PER_YEAR', ($topics_per_year == 0) ? $none : $topics_per_year),
    		'TOTAL_FILES'    	=> $this->user->lang('TOTAL_FILES', ($total_files == 0) ? $none : $total_files),

    		'USERS_PER_DAY'   	=> $this->user->lang('USERS_PER_DAY', ($users_per_day == 0) ? $none : $users_per_day),
    		'USERS_PER_YEAR'    => $this->user->lang('USERS_PER_YEAR', ($users_per_year == 0) ? $none : $users_per_year),

			'START_DATE'        => $this->user->format_date($this->config['board_startdate']),
			'U_ADMIN_VIEW_ONLY'	=> $this->config['statsonindex_admin'],

			// Reformat these for output consisency
			'TOTAL_POSTS'		=> $this->user->lang('TOTAL_POSTS_COUNT', number_format($this->config['num_posts'], '0')),
			'TOTAL_TOPICS'		=> $this->user->lang('TOTAL_TOPICS', number_format($this->config['num_topics'], '0')),
			'TOTAL_USERS'		=> $this->user->lang('TOTAL_USERS', number_format($this->config['num_users'], '0')),
		));
	}
}
