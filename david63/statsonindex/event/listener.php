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

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\template\twig\twig	$template	Template object
	* @param \phpbb\user                $user		User object
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\template\twig\twig $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $cache)
	{
		$this->config	= $config;
		$this->template	= $template;
		$this->user		= $user;
		$this->db		= $db;
		$this->cache	= $cache;
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
		// Activity stats
		// if the user is a bot, we will not even process this function
		if (!$this->user->data['is_bot'])
		{
			// obtain user activity data
			$active_users		= $this->obtain_active_user_data();
			$active_user_count	= number_format(sizeof($active_users), '0');

			// obtain posts/topics/new users activity
			$activity	= $this->obtain_activity_data();
			$tf_posts	= number_format($activity['posts'], '0');
			$tf_topics	= number_format($activity['topics'], '0');
			$tf_users	= number_format($activity['users'], '0');

			// 24 hour users online list, assign to the template block: lastvisit
			foreach ($active_users as $row)
			{
				$this->template->assign_block_vars('lastvisit', array(
					'USERNAME_FULL'	=> get_username_string((($row['user_type'] == USER_IGNORE) ? 'no_profile' : 'full'), $row['user_id'], $row['username'], $row['user_colour']),
				));
			}
		}

		// Extended stats
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
			'FILES_PER_DAY'   		=> $this->user->lang('FILE_PER_DAY', ($files_per_day == 0) ? $none : $files_per_day),
    		'FILES_PER_USER'   		=> $this->user->lang('FILES_PER_USER', ($files_per_user == 0) ? $none : $files_per_user),
			'FILES_PER_YEAR'    	=> $this->user->lang('FILES_PER_YEAR', ($files_per_year == 0) ? $none : $files_per_year),

			'POSTS_PER_DAY'   		=> $this->user->lang('POST_PER_DAY', ($posts_per_day == 0) ? $none : $posts_per_day),
    		'POSTS_PER_TOPIC'   	=> $this->user->lang('POSTS_PER_TOPIC', ($posts_per_topic == 0) ? $none : $posts_per_topic),
    		'POSTS_PER_USER'   		=> $this->user->lang('POSTS_PER_USER', ($posts_per_user == 0) ? $none : $posts_per_user),
			'POSTS_PER_YEAR'    	=> $this->user->lang('POSTS_PER_YEAR', ($posts_per_year == 0) ? $none : $posts_per_year),

			'TFHOUR_POSTS'			=> $this->user->lang('TFHOUR_POSTS', ($tf_posts == 0) ? $none : $tf_posts),
			'TFHOUR_TOPICS'			=> $this->user->lang('TFHOUR_TOPICS', ($tf_topics == 0) ? $none : $tf_topics),
			'TFHOUR_USERS'			=> $this->user->lang('TFHOUR_USERS', ($tf_users == 0) ? $none : $tf_users),
    		'TOPICS_PER_DAY'   		=> $this->user->lang('TOPIC_PER_DAY', ($topics_per_day == 0) ? $none : $topics_per_day),
			'TOPICS_PER_USER'   	=> $this->user->lang('TOPICS_PER_USER', ($topics_per_user == 0) ? $none : $topics_per_user),
    		'TOPICS_PER_YEAR'   	=> $this->user->lang('TOPICS_PER_YEAR', ($topics_per_year == 0) ? $none : $topics_per_year),
    		'TOTAL_FILES'    		=> $this->user->lang('TOTAL_FILES', ($total_files == 0) ? $none : $total_files),

    		'USERS_PER_DAY'   		=> $this->user->lang('USER_PER_DAY', ($users_per_day == 0) ? $none : $users_per_day),
    		'USERS_PER_YEAR'    	=> $this->user->lang('USERS_PER_YEAR', ($users_per_year == 0) ? $none : $users_per_year),
			'USERS_TFHOUR_TOTAL'	=> $this->user->lang('USERS_TFHOUR_TOTAL', ($active_user_count == 0) ? $none : (int)$active_user_count),

			'START_DATE'        	=> $this->user->format_date($this->config['board_startdate']),
			'U_ADMIN_VIEW_ONLY'		=> $this->config['statsonindex_admin'],

			// Reformat these for output consisency
			'TOTAL_POSTS'			=> $this->user->lang('TOTAL_POSTS_COUNT', number_format($this->config['num_posts'], '0')),
			'TOTAL_TOPICS'			=> $this->user->lang('TOTAL_TOPICS', number_format($this->config['num_topics'], '0')),
			'TOTAL_USERS'			=> $this->user->lang('TOTAL_USERS', number_format($this->config['num_users'], '0')),
		));
	}

	/**
 	* Obtain an array of active users over the last 24 hours.
 	*
 	* @return array
 	*/
	protected function obtain_active_user_data()
	{
		if (($active_users = $this->cache->get('_active_users')) === false)
		{
			$active_users = array();

			// grab a list of users who are currently online
	   		// and users who have visited in the last 24 hours
			$sql_ary = array(
				'SELECT'	=> 'u.user_id, u.user_colour, u.username, u.user_type',
				'FROM'		=> array(USERS_TABLE => 'u'),
				'LEFT_JOIN'	=> array(
					array(
						'FROM'	=> array(SESSIONS_TABLE => 's'),
							'ON'	=> 's.session_user_id = u.user_id',
					),
				),
				'WHERE'		=> 'u.user_lastvisit > ' . (time() - 86400) . ' OR s.session_user_id <> ' . ANONYMOUS,
				'GROUP_BY'	=> 'u.user_id',
				'ORDER_BY'	=> 'u.username',
			);

			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));

			while ($row = $this->db->sql_fetchrow($result))
			{
         		$active_users[$row['user_id']] = $row;
			}
			$this->db->sql_freeresult($result);

			// cache this data for 1 hour, this improves performance
			$this->cache->put('_active_users', $active_users, 3600);
		}

		return $active_users;
   	}

	/**
 	* obtained cached 24 hour activity data
 	*
 	* @return array
 	*/
	protected function obtain_activity_data()
	{
		if (($activity = $this->cache->get('_activity_mod')) === false)
		{
			// set interval to 24 hours ago
			$interval = time() - 86400;

			$activity = array();

			// total new posts in the last 24 hours
			$sql = 'SELECT COUNT(post_id) AS new_posts
				FROM ' . POSTS_TABLE . '
				WHERE post_time > ' . $interval;

			$result = $this->db->sql_query($sql);
			$activity['posts'] = $this->db->sql_fetchfield('new_posts');
			$this->db->sql_freeresult($result);

			// total new topics in the last 24 hours
			$sql = 'SELECT COUNT(topic_id) AS new_topics
				FROM ' . TOPICS_TABLE . '
				WHERE topic_time > ' . $interval;

			$result = $this->db->sql_query($sql);
			$activity['topics'] = $this->db->sql_fetchfield('new_topics');
			$this->db->sql_freeresult($result);

			// total new users in the last 24 hours, counts inactive users as well
			$sql = 'SELECT COUNT(user_id) AS new_users
				FROM ' . USERS_TABLE . '
				WHERE user_regdate > ' . $interval;

			$result = $this->db->sql_query($sql);
			$activity['users'] = $this->db->sql_fetchfield('new_users');
			$this->db->sql_freeresult($result);

			// cache this data for 1 hour, this improves performance
			$this->cache->put('_activity_mod', $activity, 3600);
		}

		return $activity;
	}
}