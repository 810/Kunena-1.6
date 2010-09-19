<?php
/**
 * @version $Id$
 * Kunena Component
 * @package Kunena
 *
 * @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.com
 **/

defined ( '_JEXEC' ) or die ();

require_once (KPATH_SITE .'/lib/kunena.link.class.php');
require_once (KPATH_SITE .'/lib/kunena.image.class.php');
require_once (KPATH_SITE .'/lib/kunena.timeformat.class.php');
require_once (KUNENA_PATH_FUNCS . DS . 'latestx.php');

kimport('html.parser');
kimport('session');

class CKunenaRSSData {
	/**
	 * @static
	 * @access public
	 * @return obj CKunenaLatestX resultlist
	 */
	static function fetch( $type, $incl_cat, $excl_cat, $limit, $timelimit ) {

		// Verify all query options and get a similar array returned into $options
		$options = self::getVerifiedOptions( array(
													'type'		=> $type,
													'incl_cat'	=> $incl_cat,
													'excl_cat'	=> $excl_cat,
													'limit'		=> $limit,
													'timelimit'	=> $timelimit
											)
		);

		// Apply admin restrictions
		foreach ( $options['incl_cat'] as $key => $catid ) {
			if ( in_array( $catid, $options['excl_cat'] ) ) {
				// forbidden - remove category
				// note: if only one category was wanted (and now removed), incl_cat is empty and all categories will be selected
				unset($options['incl_cat'][$key]);
			}
		}

		KunenaSession::getInstance(true, 0);

		$model = new CKunenaLatestX ( '', 0 );

		$model->threads_per_page	= $options['limit'];
		$model->querytime			= CKunenaTimeformat::internalTime() - $options['timelimit'];
		$model->latestcategory		= $options['incl_cat'];
		$model->latestcategory_in	= 1;
			
		if (count($options['incl_cat']) == 0) {
			// If incl_cat is empty everything will be included by CKunenalatestX, therefore we need to specific which categories NOT to load
			$model->latestcategory		= $options['excl_cat'];
			$model->latestcategory_in	= 0;
		}

		$result = array ();
		$threadmode = false;

		switch ( $options['type'] ) {
			case 'topic':
				$model->getLatestTopics();
				$threadmode = true;
				break;
			case 'recent':
				$model->getLatest();
				$threadmode = true;
				break;
			case 'post':
			default:
				$model->getLatestPosts();
		}

		if ( $threadmode == true ) {
			// for thread mode we merge the thread data with the latestreply data
			// we want to keep the subject from the thread, but userinfo and lastest post info
			// from the lastest posts array - by doing so we can leverage a single template for
			// thread and message mode
			$result = $model->threads;

			foreach ($result as $message) {
				$message->id = $model->lastreply[$message->thread]->id;
				$message->message = $model->lastreply[$message->thread]->message;
				$message->userid = $model->lastreply[$message->thread]->userid;
				$message->name = $model->lastreply[$message->thread]->name;
				$message->lasttime = $model->lastreply[$message->thread]->lasttime;
			}
		}
		else {
			$result = $model->customreply;
		}

		if ( empty( $result ) ) {
			$result = array();
		}

		return $result;
	}


	/**
	 * Verify all needed options and return verified options.
	 *
	 * @static
	 * @access private
	 * @param array $options
	 * @return array
	 */
	private static function getVerifiedOptions( $options = array() ) {
		// Default options if nothing is specified
		$verified = array(
						'type'		=> 'post',
						'incl_cat'	=> array(),
						'excl_cat'	=> array(),
						'limit'		=> '100',
						'timelimit'	=> '2629743'	// one month according to google (query: '1 month in seconds')
		);

		// Make sure type is correct
		if (isset($options['type'])) {
			switch ($options['type']) {
				case 'post':
				case 'topic':
				case 'recent':
					$verified['type'] = $options['type'];
					break;
				default:
			}
		}


		// Make sure included_categories is array of integers or array()
		if (isset($options['incl_cat'])) {
			if (!is_array($options['incl_cat'])) {
				$options['incl_cat'] = explode(',', strtolower($options['incl_cat']));
			}

			foreach ($options['incl_cat'] as $val) {
				$tmp = (int) $val;
				if ($tmp > 0) {
					$verified['incl_cat'][] = $tmp;
				}
			}
		}

		// Make sure excluded_categories is array of integers or array
		if (isset($options['excl_cat'])) {
			if (!is_array($options['excl_cat'])) {
				$options['excl_cat'] = explode(',', strtolower($options['excl_cat']));
			}
			foreach ($options['excl_cat'] as $val) {
				$tmp = (int) $val;
				if ($tmp > 0) {
					$verified['excl_cat'][] = $tmp;
				}
			}
		}

		// Limit query in numbers (if 0 then disable limiter)
		if (isset($options['limit'])) {
			$tmp = (int) $options['limit'];
			if ($tmp >= 0) {
				$verified['limit'] = $tmp;
			}
		}

		// Limit query by date (if 0 then disable limiter)
		//strtotime('-1 '. $this->config->rss_timelimit, JFactory::getDate()->toUnix());
		if (isset($options['timelimit'])) {
			if (is_int($options['timelimit'])) {
				$verified['timelimit'] = $options['timelimit'];
			}
			else {
				switch ($options['timelimit']) {
					case 'day':
						$verified['timelimit'] =  86400;
						break;
					case 'week':
						$verified['timelimit'] =  604800;
						break;
					case 'month':
						$verified['timelimit'] =  2629743;		// one month according to google (query: '1 month in seconds')
						break;
					case 'year':
						$verified['timelimit'] =  31556926;		// one year according to google (query: '1 year in seconds')
						break;
					default:
				}
			}
		}

		return $verified;
	}
}
