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
		$l_total_file_s = ($this->config['num_files'] == 0) ? 'TOTAL_FILES_ZERO' : 'TOTAL_FILES_OTHER';

		$posts_per_day = $this->config['num_posts'] / ceil((time() - $this->config['board_startdate']) / 86400);
		$l_posts_per_day_s = ($posts_per_day == 0) ? 'POSTS_PER_DAY_ZERO' : 'POSTS_PER_DAY_OTHER';
		$posts_per_year = $posts_per_day * 364.25;
		$l_posts_per_year_s = ($posts_per_year == 0) ? 'POSTS_PER_YEAR_ZERO' : 'POSTS_PER_YEAR_OTHER';
		$posts_per_user = $this->config['num_posts'] / $this->config['num_users'];
		$l_posts_per_user_s = ($posts_per_user == 0) ? 'POSTS_PER_USER_ZERO' : 'POSTS_PER_USER_OTHER';
		$posts_per_topic = $this->config['num_posts'] / $this->config['num_topics'];
		$l_posts_per_topic_s = ($posts_per_topic == 0) ? 'POSTS_PER_TOPIC_ZERO' : 'POSTS_PER_TOPIC_OTHER';
		$topics_per_day = $this->config['num_topics'] / ceil((time() - $this->config['board_startdate']) / 86400);
		$l_topics_per_day_s = ($topics_per_day == 0) ? 'TOPICS_PER_DAY_ZERO' : 'TOPICS_PER_DAY_OTHER';
		$topics_per_year = $topics_per_day * 364.25;
		$l_topics_per_year_s = ($topics_per_year == 0) ? 'TOPICS_PER_YEAR_ZERO' : 'TOPICS_PER_YEAR_OTHER';
		$topics_per_user = $this->config['num_topics'] / $this->config['num_users'];
		$l_topics_per_user_s = ($topics_per_user == 0) ? 'TOPICS_PER_USER_ZERO' : 'TOPICS_PER_USER_OTHER';
		$files_per_day = $this->config['num_files'] / ceil((time() - $this->config['board_startdate']) / 86400);
		$l_files_per_day_s = ($files_per_day == 0) ? 'FILES_PER_DAY_ZERO' : 'FILES_PER_DAY_OTHER';
		$files_per_year = $files_per_day * 364.25;
		$l_files_per_year_s = ($files_per_year == 0) ? 'FILES_PER_YEAR_ZERO' : 'FILES_PER_YEAR_OTHER';
		$files_per_user = $this->config['num_files'] / $this->config['num_users'];
		$l_files_per_user_s = ($files_per_day == 0) ? 'FILES_PER_USER_ZERO' : 'FILES_PER_USER_OTHER';
		$users_per_day = $this->config['num_users'] / ceil((time() - $this->config['board_startdate']) / 86400);
		$l_users_per_day_s = ($users_per_day == 0) ? 'USERS_PER_DAY_ZERO' : 'USERS_PER_DAY_OTHER';
		$users_per_year = $users_per_day * 364.25;
		$l_users_per_year_s = ($users_per_year == 0) ? 'USERS_PER_YEAR_ZERO' : 'USERS_PER_YEAR_OTHER';

		$this->template->assign_vars(array(
			'FILES_PER_DAY'   	=> sprintf($this->user->lang($l_files_per_day_s), $files_per_day),
    		'FILES_PER_USER'   	=> sprintf($this->user->lang($l_files_per_user_s), $files_per_user),
			'FILES_PER_YEAR'    => sprintf($this->user->lang($l_files_per_year_s), $files_per_year),

			'POSTS_PER_DAY'   	=> sprintf($this->user->lang($l_posts_per_day_s), $posts_per_day),
    		'POSTS_PER_TOPIC'   => sprintf($this->user->lang($l_posts_per_topic_s), $posts_per_topic),
    		'POSTS_PER_USER'   	=> sprintf($this->user->lang($l_posts_per_user_s), $posts_per_user),
			'POSTS_PER_YEAR'    => sprintf($this->user->lang($l_posts_per_year_s), $posts_per_year),

			'START_DATE'        => $this->user->format_date($this->config['board_startdate']),

    		'TOPICS_PER_DAY'   	=> sprintf($this->user->lang($l_topics_per_day_s), $topics_per_day),
			'TOPICS_PER_USER'   => sprintf($this->user->lang($l_topics_per_user_s), $topics_per_user),
    		'TOPICS_PER_YEAR'   => sprintf($this->user->lang($l_topics_per_year_s), $topics_per_year),
    		'TOTAL_FILES'    	=> sprintf($this->user->lang($l_total_file_s), $this->config['num_files']),

    		'USERS_PER_DAY'   	=> sprintf($this->user->lang($l_users_per_day_s), $users_per_day),
    		'USERS_PER_YEAR'    => sprintf($this->user->lang($l_users_per_year_s), $users_per_year),

			'U_ADMIN_VIEW_ONLY'	=> $this->config['statsonindex_admin'],
		));
	}
}
