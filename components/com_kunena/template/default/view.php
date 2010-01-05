<?php
/**
 * @version $Id: view.php 377 2009-02-12 08:52:32Z mahagr $
 * Kunena Component
 * @package Kunena
 *
 * @Copyright (C) 2008 - 2009 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.com
 *
 * Based on FireBoard Component
 * @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.bestofjoomla.com
 *
 * Based on Joomlaboard Component
 * @copyright (C) 2000 - 2004 TSMF / Jan de Graaff / All Rights Reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author TSMF & Jan de Graaff
 **/

// Dont allow direct linking
defined ( '_JEXEC' ) or die ( 'Restricted access' );

$kunena_app = & JFactory::getApplication ();
$kunena_config = & CKunenaConfig::getInstance ();
$kunena_session = & CKunenaSession::getInstance ();
$kunena_db = & JFactory::getDBO ();

global $kunena_emoticons;

function KunenaViewPagination($catid, $threadid, $page, $totalpages, $maxpages) {
	$kunena_config = & CKunenaConfig::getInstance ();

	$startpage = ($page - floor ( $maxpages / 2 ) < 1) ? 1 : $page - floor ( $maxpages / 2 );
	$endpage = $startpage + $maxpages;
	if ($endpage > $totalpages) {
		$startpage = ($totalpages - $maxpages) < 1 ? 1 : $totalpages - $maxpages;
		$endpage = $totalpages;
	}

	$output = '<span class="fb_pagination">' . _PAGE;
	if ($startpage > 1) {
		if ($endpage < $totalpages)
			$endpage --;
		$output .= CKunenaLink::GetThreadPageLink ( $kunena_config, 'view', $catid, $threadid, 1, $kunena_config->messages_per_page, 1, '', $rel = 'follow' );
		if ($startpage > 2) {
			$output .= "...";
		}
	}

	for($i = $startpage; $i <= $endpage && $i <= $totalpages; $i ++) {
		if ($page == $i) {
			$output .= "<strong>$i</strong>";
		} else {
			$output .= CKunenaLink::GetThreadPageLink ( $kunena_config, 'view', $catid, $threadid, $i, $kunena_config->messages_per_page, $i, '', $rel = 'follow' );
		}
	}

	if ($endpage < $totalpages) {
		if ($endpage < $totalpages - 1) {
			$output .= "...";
		}

		$output .= CKunenaLink::GetThreadPageLink ( $kunena_config, 'view', $catid, $threadid, $totalpages, $kunena_config->messages_per_page, $totalpages, '', $rel = 'follow' );
	}

	$output .= '</span>';
	return $output;
}

//securing form elements
$catid = ( int ) $catid;
$id = ( int ) $id;

$smileyList = smile::getEmoticons ( 0 );

//ob_start();
$showedEdit = 0;
require_once (KUNENA_PATH_LIB . DS . 'kunena.statsbar.php');

//get the allowed forums and turn it into an array
$allow_forum = ($kunena_session->allowed != '') ? explode ( ',', $kunena_session->allowed ) : array ();

$this->kunena_forum_locked = 0;
$topicLocked = 0;

$kunena_db->setQuery ( "SELECT a.*, b.* FROM #__fb_messages AS a LEFT JOIN #__fb_messages_text AS b ON a.id=b.mesid WHERE a.id='{$id}' AND a.hold='0'" );
$this_message = $kunena_db->loadObject ();
check_dberror ( 'Unable to load current message.' );

if ((in_array ( $catid, $allow_forum )) || (isset ( $this_message->catid ) && in_array ( $this_message->catid, $allow_forum ))) {
	$view = $view == "" ? $this->kunena_cookie_settings [current_view] : $view;
	setcookie ( "fboard_settings[current_view]", $view, time () + 31536000, '/' );

	$topicLocked = $this_message->locked;
	$topicSticky = $this_message->ordering;

	if (count ( $this_message ) < 1) {
		echo '<p align="center">' . _MODERATION_INVALID_ID . '</p>';
	} else {
		$thread = $this_message->parent == 0 ? $this_message->id : $this_message->thread;

		// Test if this is a valid SEO URL if not we should redirect using a 301 - permanent redirect
		if ($thread != $this_message->id || $catid != $this_message->catid) {
			// Invalid SEO URL detected!
			// Create permanent re-direct and quit
			// This query to calculate the page this reply is sitting on within this thread
			$query = "SELECT COUNT(*) FROM #__fb_messages AS a WHERE a.thread='{$thread}' AND hold='0' AND a.id<='{$id}'";
			$kunena_db->setQuery ( $query );
			$replyCount = $kunena_db->loadResult ();
			check_dberror ( 'Unable to calculate location of current message.' );

			$replyPage = $replyCount > $kunena_config->messages_per_page ? ceil ( $replyCount / $kunena_config->messages_per_page ) : 1;

			header ( "HTTP/1.1 301 Moved Permanently" );
			header ( "Location: " . htmlspecialchars_decode ( CKunenaLink::GetThreadPageURL ( $kunena_config, 'view', $this_message->catid, $thread, $replyPage, $kunena_config->messages_per_page, $this_message->id ) ) );

			$kunena_app->close ();
		}

		if ($kunena_my->id) {
			//mark this topic as read
			$kunena_db->setQuery ( "SELECT readtopics FROM #__fb_sessions WHERE userid='{$kunena_my->id}'" );
			$readTopics = $kunena_db->loadResult ();

			if ($readTopics == "") {
				$readTopics = $thread;
			} else {
				//get all readTopics in an array
				$_read_topics = @explode ( ',', $readTopics );

				if (! @in_array ( $thread, $_read_topics )) {
					$readTopics .= "," . $thread;
				}
			}

			$kunena_db->setQuery ( "UPDATE #__fb_sessions SET readtopics='{$readTopics}' WHERE userid='{$kunena_my->id}'" );
			$kunena_db->query ();
		}

		//update the hits counter for this topic & exclude the owner
		if ($kunena_my->id == 0 || $this_message->userid != $kunena_my->id) {
			$kunena_db->setQuery ( "UPDATE #__fb_messages SET hits=hits+1 WHERE id='{$thread}' AND parent='0'" );
			$kunena_db->query ();
		}

		$query = "SELECT COUNT(*) FROM #__fb_messages AS a WHERE a.thread='{$thread}' AND hold='0'";
		$kunena_db->setQuery ( $query );
		$total = $kunena_db->loadResult ();
		check_dberror ( 'Unable to calculate message count.' );

		//prepare paging
		$limit = JRequest::getInt ( 'limit', 0 );
		if ($limit < 1)
			$limit = $kunena_config->messages_per_page;
		$limitstart = JRequest::getInt ( 'limitstart', 0 );
		if ($limitstart < 0)
			$limitstart = 0;
		if ($limitstart > $total)
			$limitstart = intval ( $total / $limit ) * $limit;
		$ordering = ($kunena_config->default_sort == 'desc' ? 'desc' : 'asc'); // Just to make sure only valid options make it
		$maxpages = 9 - 2; // odd number here (show - 2)
		$totalpages = ceil ( $total / $limit );
		$page = floor ( $limitstart / $limit ) + 1;
		$firstpage = 1;
		if ($ordering == 'desc')
			$firstpage = $totalpages;

		$replylimit = $page == $firstpage ? $limit - 1 : $limit; // If page contains first message, load $limit-1 messages
		$replystart = $limitstart && $ordering == 'asc' ? $limitstart - 1 : $limitstart; // If not first page and order=asc, start on $limitstart-1
		// Get replies of current thread
		$query = "SELECT a.*, b.* FROM #__fb_messages AS a LEFT JOIN #__fb_messages_text AS b ON a.id=b.mesid " . "WHERE a.thread='{$thread}' AND a.id!='{$id}' AND a.hold='0' AND a.catid='{$catid}' ORDER BY id {$ordering}";
		$kunena_db->setQuery ( $query, $replystart, $replylimit );
		$replies = $kunena_db->loadObjectList ();
		check_dberror ( 'Unable to load replies' );

		$flat_messages = array ();
		if ($page == 1 && $ordering == 'asc')
			$flat_messages [] = $this_message; // ASC: first message is the first one
		foreach ( $replies as $message )
			$flat_messages [] = $message;
		if ($page == $totalpages && $ordering == 'desc')
			$flat_messages [] = $this_message; // DESC: first message is the last one
		unset ( $replies );

		$pagination = KunenaViewPagination ( $catid, $thread, $page, $totalpages, $maxpages );

		//Get the category name for breadcrumb
		$kunena_db->setQuery ( "SELECT * FROM #__fb_categories WHERE id='{$catid}'" );
		$objCatInfo = $kunena_db->loadObject ();
		//Get Parent's cat.name for breadcrumb
		$kunena_db->setQuery ( "SELECT id, name FROM #__fb_categories WHERE id='{$objCatInfo->parent}'" );
		$objCatParentInfo = $kunena_db->loadObject ();

		$this->kunena_forum_locked = $objCatInfo->locked;

		//meta description and keywords
		$metaKeys = kunena_htmlspecialchars ( stripslashes ( "{$this_message->subject}, {$objCatParentInfo->name}, {$kunena_config->board_title}, " . _GEN_FORUM . ', ' . $kunena_app->getCfg ( 'sitename' ) ) );
		$metaDesc = kunena_htmlspecialchars ( stripslashes ( "{$this_message->subject} ({$page}/{$totalpages}) - {$objCatParentInfo->name} - {$objCatInfo->name} - {$kunena_config->board_title} " . _GEN_FORUM ) );

		$document = & JFactory::getDocument ();
		$cur = $document->get ( 'description' );
		$metaDesc = $cur . '. ' . $metaDesc;
		$document->setMetadata ( 'keywords', $metaKeys );
		$document->setDescription ( $metaDesc );

		//Perform subscriptions check only once
		$fb_cansubscribe = 0;
		if ($kunena_config->allowsubscriptions && ("" != $kunena_my->id || 0 != $kunena_my->id)) {
			$kunena_db->setQuery ( "SELECT thread FROM #__fb_subscriptions WHERE userid='{$kunena_my->id}' AND thread='{$thread}'" );
			$fb_subscribed = $kunena_db->loadResult ();

			if ($fb_subscribed == "") {
				$fb_cansubscribe = 1;
			}
		}
		//Perform favorites check only once
		$fb_canfavorite = 0;
		if ($kunena_config->allowfavorites && ("" != $kunena_my->id || 0 != $kunena_my->id)) {
			$kunena_db->setQuery ( "SELECT thread FROM #__fb_favorites WHERE userid='{$kunena_my->id}' AND thread='{$thread}'" );
			$fb_favorited = $kunena_db->loadResult ();

			if ($fb_favorited == "") {
				$fb_canfavorite = 1;
			}
		}

		//data ready display now
		if (CKunenaTools::isModerator($kunena_my->id, $catid) || (($this->kunena_forum_locked == 0 && $topicLocked == 0) && ($kunena_my->id > 0 || $kunena_config->pubwrite))) {
			//this user is allowed to reply to this topic
			$thread_reply = CKunenaLink::GetTopicPostReplyLink ( 'reply', $catid, $thread, isset ( $kunena_emoticons ['topicreply'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['topicreply'] . '" alt="' . _GEN_POST_REPLY . '" title="' . _GEN_POST_REPLY . '" border="0" />' : _GEN_POST_REPLY );
		}

		if ($fb_cansubscribe == 1) {
			// this user is allowed to subscribe - check performed further up to eliminate duplicate checks
			// for top and bottom navigation
			$thread_subscribe = CKunenaLink::GetTopicPostLink ( 'subscribe', $catid, $id, isset ( $kunena_emoticons ['subscribe'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['subscribe'] . '" alt="' . _VIEW_SUBSCRIBETXT . '" title="' . _VIEW_SUBSCRIBETXT . '" border="0" />' : _VIEW_SUBSCRIBETXT );
		}

		//START: FAVORITES
		if ($kunena_my->id != 0 && $kunena_config->allowsubscriptions && $fb_cansubscribe == 0) {
			// this user is allowed to unsubscribe
			$thread_subscribe = CKunenaLink::GetTopicPostLink ( 'unsubscribe', $catid, $id, isset ( $kunena_emoticons ['unsubscribe'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['unsubscribe'] . '" alt="' . _VIEW_UNSUBSCRIBETXT . '" title="' . _VIEW_UNSUBSCRIBETXT . '" border="0" />' : _VIEW_UNSUBSCRIBETXT );
		}

		if ($fb_canfavorite == 1) {
			// this user is allowed to add a favorite - check performed further up to eliminate duplicate checks
			// for top and bottom navigation
			$thread_favorite = CKunenaLink::GetTopicPostLink ( 'favorite', $catid, $id, isset ( $kunena_emoticons ['favorite'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['favorite'] . '" alt="' . _VIEW_FAVORITETXT . '" title="' . _VIEW_FAVORITETXT . '" border="0" />' : _VIEW_FAVORITETXT );
		}

		if ($kunena_my->id != 0 && $kunena_config->allowfavorites && $fb_canfavorite == 0) {
			// this user is allowed to unfavorite
			$thread_favorite = CKunenaLink::GetTopicPostLink ( 'unfavorite', $catid, $id, isset ( $kunena_emoticons ['unfavorite'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['unfavorite'] . '" alt="' . _VIEW_UNFAVORITETXT . '" title="' . _VIEW_UNFAVORITETXT . '" border="0" />' : _VIEW_UNFAVORITETXT );
		}
		// FINISH: FAVORITES


		if (CKunenaTools::isModerator($kunena_my->id, $catid) || ($this->kunena_forum_locked == 0 && ($kunena_my->id > 0 || $kunena_config->pubwrite))) {
			//this user is allowed to post a new topic
			$thread_new = CKunenaLink::GetPostNewTopicLink ( $catid, isset ( $kunena_emoticons ['new_topic'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['new_topic'] . '" alt="' . _GEN_POST_NEW_TOPIC . '" title="' . _GEN_POST_NEW_TOPIC . '" border="0" />' : _GEN_POST_NEW_TOPIC );
		}

		if (CKunenaTools::isModerator($kunena_my->id, $catid)) {
			// offer the moderator always the move link to relocate a topic to another forum
			// and the (un)sticky bit links
			// and the (un)lock links
			$thread_move = CKunenaLink::GetTopicPostLink ( 'move', $catid, $id, isset ( $kunena_emoticons ['move'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['move'] . '" alt="Move" border="0" title="' . _VIEW_MOVE . '" />' : _GEN_MOVE );

			if ($topicSticky == 0) {
				$thread_sticky = CKunenaLink::GetTopicPostLink ( 'sticky', $catid, $id, isset ( $kunena_emoticons ['sticky'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['sticky'] . '" alt="Sticky" border="0" title="' . _VIEW_STICKY . '" />' : _GEN_STICKY );
			} else {
				$thread_sticky = CKunenaLink::GetTopicPostLink ( 'unsticky', $catid, $id, isset ( $kunena_emoticons ['unsticky'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['unsticky'] . '" alt="Unsticky" border="0" title="' . _VIEW_UNSTICKY . '" />' : _GEN_UNSTICKY );
			}

			if ($topicLocked == 0) {
				$thread_lock = CKunenaLink::GetTopicPostLink ( 'lock', $catid, $id, isset ( $kunena_emoticons ['lock'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['lock'] . '" alt="Lock" border="0" title="' . _VIEW_LOCK . '" />' : _GEN_LOCK );
			} else {
				$thread_lock = CKunenaLink::GetTopicPostLink ( 'unlock', $catid, $id, isset ( $kunena_emoticons ['unlock'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['unlock'] . '" alt="Unlock" border="0" title="' . _VIEW_UNLOCK . '" />' : _GEN_UNLOCK );
			}
			$thread_delete = CKunenaLink::GetTopicPostLink ( 'delete', $catid, $id, isset ( $kunena_emoticons ['delete'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['delete'] . '" alt="Delete" border="0" title="' . _VIEW_DELETE . '" />' : _GEN_DELETE );
			$thread_merge = CKunenaLink::GetTopicPostLink ( 'merge', $catid, $id, isset ( $kunena_emoticons ['merge'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['merge'] . '" alt="Merge" border="0" title="' . _VIEW_MERGE . '" />' : _GEN_MERGE );
		}
		?>

<script type="text/javascript">
        jQuery(function()
        {
            jQuery(".fb_qr_fire").click(function()
            {
                jQuery("#sc" + (jQuery(this).attr("id").split("__")[1])).toggle();
            });
            jQuery(".fb_qm_cncl_btn").click(function()
            {
                jQuery("#sc" + (jQuery(this).attr("id").split("__")[1])).toggle();
            });

        });
        </script>

<div><?php
		if (file_exists ( KUNENA_ABSTMPLTPATH . '/pathway.php' )) {
			require_once (KUNENA_ABSTMPLTPATH . '/pathway.php');
		} else {
			require_once (KUNENA_PATH_TEMPLATE_DEFAULT . DS . 'pathway.php');
		}
		?>
</div>
<?php
		if ($objCatInfo->headerdesc) {
			?>
<table class="fb_forum-headerdesc<?php echo $objCatInfo->class_sfx;?>" border="0" cellpadding="0"
	cellspacing="0" width="100%">
	<tr>
		<td><?php
			$headerdesc = stripslashes ( smile::smileReplace ( $objCatInfo->headerdesc, 0, $kunena_config->disemoticons, $smileyList ) );
			$headerdesc = nl2br ( $headerdesc );
			//wordwrap:
			$headerdesc = smile::htmlwrap ( $headerdesc, $kunena_config->wrap );
			echo $headerdesc;
			?>
		</td>
	</tr>
</table>
<?php
		}
		?>

<!-- B: List Actions -->

<table class="fb_list_actions" border="0" cellspacing="0"
	cellpadding="0" width="100%">
	<tr>
		<td class="fb_list_actions_goto"><?php
		//go to bottom
		echo '<a name="forumtop" /> ';
		echo CKunenaLink::GetSamePageAnkerLink ( 'forumbottom', isset ( $kunena_emoticons ['bottomarrow'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['bottomarrow'] . '" border="0" alt="' . _GEN_GOTOBOTTOM . '" title="' . _GEN_GOTOBOTTOM . '"/>' : _GEN_GOTOBOTTOM );

		echo '</td>';
		if (CKunenaTools::isModerator($kunena_my->id, $catid) || isset ( $thread_reply ) || isset ( $thread_subscribe ) || isset ( $thread_favorite )) {
			echo '<td class="fb_list_actions_forum">';
			echo '<div class="fb_message_buttons_row" style="text-align: center;">';
			if (isset ( $thread_reply ))
				echo $thread_reply;
			if (isset ( $thread_subscribe ))
				echo ' ' . $thread_subscribe;
			if (isset ( $thread_favorite ))
				echo ' ' . $thread_favorite;
			echo '</div>';
			if (CKunenaTools::isModerator($kunena_my->id, $catid)) {
				echo '<div class="fb_message_buttons_row" style="text-align: center;">';
				echo $thread_delete;
				echo ' ' . $thread_move;
				echo ' ' . $thread_sticky;
				echo ' ' . $thread_lock;
				echo '</div>';
			}
			echo '</td>';
		}
		echo '<td class="fb_list_actions_forum" width="100%">';
		if (isset ( $thread_new )) {
			echo '<div class="fb_message_buttons_row" style="text-align: left;">';
			echo $thread_new;
			echo '</div>';
		}
		if (isset ( $thread_merge )) {
			echo '<div class="fb_message_buttons_row" style="text-align: left;">';
			echo $thread_merge;
			echo '</div>';
		}
		echo '</td>';

		//pagination 1
		echo '<td class="fb_list_pages_all" nowrap="nowrap">';
		echo $pagination;
		echo '</td>';
		?>


		</td>
	</tr>
</table>

<!-- F: List Actions -->

<!-- <table border = "0" cellspacing = "0" cellpadding = "0" width = "100%" align = "center"> -->

<table class="fb_blocktable<?php
		echo $objCatInfo->class_sfx;
		?>"
	id="fb_views" cellpadding="0" cellspacing="0" border="0" width="100%">
	<thead>
		<tr>
			<th align="left">
			<div class="fb_title_cover  fbm"><span class="fb_title fbl"><b><?php
		echo _KUNENA_TOPIC;
		?></b>
			<?php
		echo $this->kunena_topic_title;
		?></span></div>
			<!-- B: FORUM TOOLS --> <?php

		//(JJ) BEGIN: RECENT POSTS
		if (file_exists ( KUNENA_ABSTMPLTPATH . '/plugin/forumtools/forumtools.php' )) {
			include (KUNENA_ABSTMPLTPATH . '/plugin/forumtools/forumtools.php');
		} else {
			include (KUNENA_PATH_TEMPLATE_DEFAULT . DS . 'plugin/forumtools/forumtools.php');
		}

		//(JJ) FINISH: RECENT POSTS


		?>
			<!-- F: FORUM TOOLS --> <!-- Begin: Total Favorite --> <?php
		$kunena_db->setQuery ( "SELECT COUNT(*) FROM #__fb_favorites WHERE thread='{$thread}'" );
		$fb_totalfavorited = $kunena_db->loadResult ();

		echo '<div class="fb_totalfavorite">';
		if ($kunena_emoticons ['favoritestar']) {
			if ($fb_totalfavorited >= 1)
				echo '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['favoritestar'] . '" alt="*" border="0" title="' . _KUNENA_FAVORITE . '" />';
			if ($fb_totalfavorited >= 3)
				echo '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['favoritestar'] . '" alt="*" border="0" title="' . _KUNENA_FAVORITE . '" />';
			if ($fb_totalfavorited >= 6)
				echo '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['favoritestar'] . '" alt="*" border="0" title="' . _KUNENA_FAVORITE . '" />';
			if ($fb_totalfavorited >= 10)
				echo '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['favoritestar'] . '" alt="*" border="0" title="' . _KUNENA_FAVORITE . '" />';
			if ($fb_totalfavorited >= 15)
				echo '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['favoritestar'] . '" alt="*" border="0" title="' . _KUNENA_FAVORITE . '" />';
		} else {
			echo _KUNENA_TOTALFAVORITE;
			echo $fb_totalfavorited;
		}
		echo '</div>';
		?>
			<!-- Finish: Total Favorite --></th>
		</tr>
	</thead>

	<tr>
		<td><?php
		$tabclass = array ("sectiontableentry1", "sectiontableentry2" );

		$this->mmm = 0;
		$k = 0;
		// Set up a list of moderators for this category (limits amount of queries)
		$kunena_db->setQuery ( "SELECT a.userid FROM #__fb_users AS a LEFT JOIN #__fb_moderation AS b ON b.userid=a.userid WHERE b.catid='{$catid}'" );
		$catModerators = $kunena_db->loadResultArray ();

		/**
		 * note: please check if this routine is fine. there is no need to see for all messages if they are locked or not, either the thread or cat can be locked anyway
		 */

		//check if topic is locked
		$_lockTopicID = $this_message->thread;
		$topicLocked = $this_message->locked;

		if ($_lockTopicID) // prev UNDEFINED $topicID!!
{
			$lockedWhat = _TOPIC_NOT_ALLOWED; // UNUSED
		}

		else { //topic not locked; check if forum is locked
			$kunena_db->setQuery ( "SELECT locked FROM #__fb_categories WHERE id='{$this_message->catid}'" );
			$topicLocked = $kunena_db->loadResult ();
			$lockedWhat = _FORUM_NOT_ALLOWED; // UNUSED
		}
		// END TOPIC LOCK


		if (count ( $flat_messages ) > 0) {
			foreach ( $flat_messages as $this->kunena_message ) {

				$k = 1 - $k;
				$this->mmm ++;

				if ($this->kunena_message->parent == 0) {
					$fb_thread = $this->kunena_message->id;
				} else {
					$fb_thread = $this->kunena_message->thread;
				}

				//filter out clear html
				$this->kunena_message->name = kunena_htmlspecialchars ( $this->kunena_message->name );
				$this->kunena_message->email = kunena_htmlspecialchars ( $this->kunena_message->email );
				$this->kunena_message->subject = kunena_htmlspecialchars ( $this->kunena_message->subject );

				//Get userinfo needed later on, this limits the amount of queries
				static $uinfocache = array ();
				if (! isset ( $uinfocache [$this->kunena_message->userid] )) {
					$kunena_db->setQuery ( "SELECT  a.*, b.id, b.name, b.username, b.gid FROM #__fb_users AS a INNER JOIN #__users AS b ON b.id=a.userid WHERE a.userid='{$this->kunena_message->userid}'" );
					$userinfo = $kunena_db->loadObject ();
					if ($userinfo == NULL) {
						$userinfo = new stdClass ( );
						$userinfo->userid = 0;
						$userinfo->name = '';
						$userinfo->username = '';
						$userinfo->avatar = '';
						$userinfo->gid = 0;
						$userinfo->rank = 0;
						$userinfo->posts = 0;
						$userinfo->karma = 0;
						$userinfo->gender = _KUNENA_NOGENDER;
						$userinfo->personalText = '';
						$userinfo->ICQ = '';
						$userinfo->location = '';
						$userinfo->birthdate = '';
						$userinfo->AIM = '';
						$userinfo->MSN = '';
						$userinfo->YIM = '';
						$userinfo->SKYPE = '';
						$userinfo->GTALK = '';
						$userinfo->websiteurl = '';
						$userinfo->signature = '';
					}
					$uinfocache [$this->kunena_message->userid] = $userinfo;
				} else
					$userinfo = $uinfocache [$this->kunena_message->userid];

				if ($kunena_config->fb_profile == 'cb') {
					$triggerParams = array ('userid' => $this->kunena_message->userid, 'userinfo' => &$userinfo );
					$kunenaProfile = & CkunenaCBProfile::getInstance ();
					$kunenaProfile->trigger ( 'profileIntegration', $triggerParams );
				}

				//get the username:
				if ($kunena_config->username) {
					$fb_queryName = "username";
				} else {
					$fb_queryName = "name";
				}

				$fb_username = $userinfo->$fb_queryName;

				if ($fb_username == "" || $kunena_config->changename) {
					$fb_username = stripslashes ( $this->kunena_message->name );
				}
				$fb_username = kunena_htmlspecialchars ( $fb_username );

				$msg_html = new StdClass ( );
				$msg_html->id = $this->kunena_message->id;
				$lists ["userid"] = $userinfo->userid;
				$msg_html->username = $this->kunena_message->email != "" && $kunena_my->id > 0 && $kunena_config->showemail ? CKunenaLink::GetEmailLink ( kunena_htmlspecialchars ( stripslashes ( $this->kunena_message->email ) ), $fb_username ) : $fb_username;

				if ($kunena_config->allowavatar) {
					$Avatarname = $userinfo->username;

					if ($kunena_config->avatar_src == "jomsocial") {
						// Get CUser object
						$jsuser = & CFactory::getUser ( $userinfo->userid );
						$msg_html->avatar = '<span class="fb_avatar"><img src="' . $jsuser->getThumbAvatar () . '" alt=" " /></span>';
					} else if ($kunena_config->avatar_src == "cb") {
						$kunenaProfile = & CkunenaCBProfile::getInstance ();
						$msg_html->avatar = '<span class="fb_avatar">' . $kunenaProfile->showAvatar ( $userinfo->userid, '', false ) . '</span>';
					} else if ($kunena_config->avatar_src == "aup") {
						$api_AUP = JPATH_SITE . DS . 'components' . DS . 'com_alphauserpoints' . DS . 'helper.php';
						if (file_exists ( $api_AUP )) {
							($kunena_config->fb_profile == 'aup') ? $showlink = 1 : $showlink = 0;
							$msg_html->avatar = '<span class="fb_avatar">' . AlphaUserPointsHelper::getAupAvatar ( $userinfo->userid, $showlink ) . '</span>';
						}
					} else {
						$avatar = $userinfo->avatar;

						if (! empty ( $avatar )) {
							if (! file_exists ( KUNENA_PATH_UPLOADED . DS . 'avatars/s_' . $avatar )) {
								$msg_html->avatar = '<span class="fb_avatar"><img border="0" src="' . KUNENA_LIVEUPLOADEDPATH . '/avatars/' . $avatar . '" alt="" style="max-width: ' . $kunena_config->avatarwidth . 'px; max-height: ' . $kunena_config->avatarheight . 'px;" /></span>';
							} else {
								$msg_html->avatar = '<span class="fb_avatar"><img border="0" src="' . KUNENA_LIVEUPLOADEDPATH . '/avatars/' . $avatar . '" alt="" style="max-width: ' . $kunena_config->avatarwidth . 'px; max-height: ' . $kunena_config->avatarheight . 'px;" /></span>';
							}
						} else {
							$msg_html->avatar = '<span class="fb_avatar"><img  border="0" src="' . KUNENA_LIVEUPLOADEDPATH . '/avatars/nophoto.jpg" alt="" style="max-width: ' . $kunena_config->avatarwidth . 'px; max-height: ' . $kunena_config->avatarheight . 'px;" /></span>';
						}
					}
				} else {
					$msg_html->avatar = '';
				}

				if ($kunena_config->showuserstats) {
					//user type determination
					$ugid = $userinfo->gid;
					$uIsMod = 0;
					$uIsAdm = 0;
					$uIsMod = in_array ( $userinfo->userid, $catModerators );

					if ($ugid == 0) {
						$msg_html->usertype = _VIEW_VISITOR;
					} else {
						if (CKunenaTools::isAdmin ( $userinfo->id )) {
							$msg_html->usertype = _VIEW_ADMIN;
							$uIsAdm = 1;
						} elseif ($uIsMod) {
							$msg_html->usertype = _VIEW_MODERATOR;
						} else {
							$msg_html->usertype = _VIEW_USER;
						}
					}

					//done usertype determination, phew...
					//# of post for this user and ranking
					if ($userinfo->userid) {
						$numPosts = ( int ) $userinfo->posts;

						//ranking
						$rText = '';
						$showSpRank = false;
						if ($kunena_config->showranking) {
							$showSpRank = $userinfo->rank != '0';
							if ($showSpRank) {
								//special rank
								$kunena_db->setQuery ( "SELECT * FROM #__fb_ranks WHERE rank_id='{$userinfo->rank}'" );
							} else {
								//post count rank
								$kunena_db->setQuery ( "SELECT * FROM #__fb_ranks WHERE ((rank_min <= '{$numPosts}') AND (rank_special = '0')) ORDER BY rank_min DESC", 0, 1 );
							}
							$rank = $kunena_db->loadObject ();
							$rText = $rank->rank_title;
							$rImg = KUNENA_URLRANKSPATH . $rank->rank_image;
						}

						if ($uIsMod and ! $showSpRank) {
							$rText = _RANK_MODERATOR;
							$rImg = KUNENA_URLRANKSPATH . 'rankmod.gif';
						}

						if ($uIsAdm and ! $showSpRank) {
							$rText = _RANK_ADMINISTRATOR;
							$rImg = KUNENA_URLRANKSPATH . 'rankadmin.gif';
						}

						if ($kunena_config->rankimages && isset ( $rImg )) {
							$msg_html->userrankimg = '<img src="' . $rImg . '" alt="" />';
						}

						$msg_html->userrank = $rText;

						$useGraph = 0; //initialization


						if (! $kunena_config->poststats) {
							$msg_html->posts = '<div class="viewcover">' . "<strong>" . _POSTS . " $numPosts" . "</strong>" . "</div>";
						} else {
							$msg_html->myGraph = new phpGraph ( );
							//$msg_html->myGraph->SetGraphTitle(_POSTS);
							$msg_html->myGraph->AddValue ( _POSTS, $numPosts );
							$msg_html->myGraph->SetRowSortMode ( 0 );
							$msg_html->myGraph->SetBarImg ( KUNENA_URLGRAPHPATH . "col" . $kunena_config->statscolor . "m.png" );
							$msg_html->myGraph->SetBarImg2 ( KUNENA_URLEMOTIONSPATH . "graph.gif" );
							$msg_html->myGraph->SetMaxVal ( $this->kunena_max_posts );
							$msg_html->myGraph->SetShowCountsMode ( 2 );
							$msg_html->myGraph->SetBarWidth ( 4 ); //height of the bar
							$msg_html->myGraph->SetBorderColor ( "#333333" );
							$msg_html->myGraph->SetBarBorderWidth ( 0 );
							$msg_html->myGraph->SetGraphWidth ( 64 ); //should match column width in the <TD> above -5 pixels
							//$msg_html->myGraph->BarGraphHoriz();
							$useGraph = 1;
						}
					}
				}
				// Start Integration AlphaUserPoints
				// ****************************
				$api_AUP = JPATH_SITE . DS . 'components' . DS . 'com_alphauserpoints' . DS . 'helper.php';
				if ($kunena_config->alphauserpoints && file_exists ( $api_AUP )) {
					static $maxPoints = false;

					if ($maxPoints == false) {
						//Get the max# of points for any one user
						$kunena_db->setQuery ( "SELECT MAX(points) FROM #__alpha_userpoints" );
						$maxPoints = $kunena_db->loadResult ();
						check_dberror ( "Unable to load AUP max points." );
					}

					$kunena_db->setQuery ( "SELECT points FROM #__alpha_userpoints WHERE `userid`='" . ( int ) $this->kunena_message->userid . "'" );
					$numPoints = $kunena_db->loadResult ();
					check_dberror ( "Unable to load AUP points." );

					$msg_html->myGraphAUP = new phpGraph ( );
					$msg_html->myGraphAUP->AddValue ( _KUNENA_AUP_POINTS, $numPoints );
					$msg_html->myGraphAUP->SetRowSortMode ( 0 );
					$msg_html->myGraphAUP->SetBarImg ( KUNENA_URLGRAPHPATH . "col" . $kunena_config->statscolor . "m.png" );
					$msg_html->myGraphAUP->SetBarImg2 ( KUNENA_URLEMOTIONSPATH . "graph.gif" );
					$msg_html->myGraphAUP->SetMaxVal ( $maxPoints );
					$msg_html->myGraphAUP->SetShowCountsMode ( 2 );
					$msg_html->myGraphAUP->SetBarWidth ( 4 ); //height of the bar
					$msg_html->myGraphAUP->SetBorderColor ( "#333333" );
					$msg_html->myGraphAUP->SetBarBorderWidth ( 0 );
					$msg_html->myGraphAUP->SetGraphWidth ( 64 ); //should match column width in the <TD> above -5 pixels
					$useGraph = 1;
				}
				// End Integration AlphaUserPoints


				//karma points and buttons
				if ($kunena_config->showkarma && $userinfo->userid != '0') {
					$karmaPoints = $userinfo->karma;
					$karmaPoints = ( int ) $karmaPoints;
					$msg_html->karma = "<strong>" . _KARMA . ":</strong> $karmaPoints";

					if ($kunena_my->id != '0' && $kunena_my->id != $userinfo->userid) {
						$msg_html->karmaminus = CKunenaLink::GetKarmaLink ( 'decrease', $catid, $this->kunena_message->id, $userinfo->userid, '<img src="' . (isset ( $kunena_emoticons ['karmaminus'] ) ? (KUNENA_URLICONSPATH . $kunena_emoticons ['karmaminus']) : (KUNENA_URLEMOTIONSPATH . "karmaminus.gif")) . '" alt="Karma-" border="0" title="' . _KARMA_SMITE . '" align="absmiddle" />' );
						$msg_html->karmaplus = CKunenaLink::GetKarmaLink ( 'increase', $catid, $this->kunena_message->id, $userinfo->userid, '<img src="' . (isset ( $kunena_emoticons ['karmaplus'] ) ? (KUNENA_URLICONSPATH . $kunena_emoticons ['karmaplus']) : (KUNENA_URLEMOTIONSPATH . "karmaplus.gif")) . '" alt="Karma+" border="0" title="' . _KARMA_APPLAUD . '" align="absmiddle" />' );
					}
				}
				/*let's see if we should use Missus integration */
				if ($kunena_config->pm_component == "missus" && $userinfo->userid && $kunena_my->id) {
					//we should offer the user a Missus link
					//first get the username of the user to contact
					$PMSName = $userinfo->username;
					$msg_html->pms = "<a href=\"" . JRoute::_ ( 'index.php?option=com_missus&amp;func=newmsg&amp;user=' . $userinfo->userid . '&amp;subject=' . _GEN_FORUM . ': ' . urlencode ( utf8_encode ( $this->kunena_message->subject ) ) ) . "\"><img src='";

					if ($kunena_emoticons ['pms']) {
						$msg_html->pms .= KUNENA_URLICONSPATH . $kunena_emoticons ['pms'];
					} else {
						$msg_html->pms .= KUNENA_URLICONSPATH . $kunena_emoticons ['pms'];
						;
					}

					$msg_html->pms .= "' alt=\"" . _VIEW_PMS . "\" border=\"0\" title=\"" . _VIEW_PMS . "\" /></a>";
				}

				/*let's see if we should use JIM integration */
				if ($kunena_config->pm_component == "jim" && $userinfo->userid && $kunena_my->id) {
					//we should offer the user a JIM link
					//first get the username of the user to contact
					$PMSName = $userinfo->username;
					$msg_html->pms = "<a href=\"" . JRoute::_ ( 'index.php?option=com_jim&amp;page=new&amp;id=' . $PMSName . '&title=' . $this->kunena_message->subject ) . "\"><img src='";

					if ($kunena_emoticons ['pms']) {
						$msg_html->pms .= KUNENA_URLICONSPATH . $kunena_emoticons ['pms'];
					} else {
						$msg_html->pms .= KUNENA_URLICONSPATH . $kunena_emoticons ['pms'];
						;
					}

					$msg_html->pms .= "' alt=\"" . _VIEW_PMS . "\" border=\"0\" title=\"" . _VIEW_PMS . "\" /></a>";
				}
				/*let's see if we should use uddeIM integration */
				if ($kunena_config->pm_component == "uddeim" && $userinfo->userid && $kunena_my->id) {
					//we should offer the user a PMS link
					//first get the username of the user to contact
					$PMSName = $userinfo->username;
					$msg_html->pms = "<a href=\"" . JRoute::_ ( 'index.php?option=com_uddeim&amp;task=new&recip=' . $userinfo->userid ) . "\"><img src=\"";

					if ($kunena_emoticons ['pms']) {
						$msg_html->pms .= KUNENA_URLICONSPATH . $kunena_emoticons ['pms'];
					} else {
						$msg_html->pms .= KUNENA_URLEMOTIONSPATH . "sendpm.gif";
					}

					$msg_html->pms .= "\" alt=\"" . _VIEW_PMS . "\" border=\"0\" title=\"" . _VIEW_PMS . "\" /></a>";
				}
				/*let's see if we should use myPMS2 integration */
				if ($kunena_config->pm_component == "pms" && $userinfo->userid && $kunena_my->id) {
					//we should offer the user a PMS link
					//first get the username of the user to contact
					$PMSName = $userinfo->username;
					$msg_html->pms = "<a href=\"" . JRoute::_ ( 'index.php?option=com_pms&amp;page=new&amp;id=' . $PMSName . '&title=' . $this->kunena_message->subject ) . "\"><img src=\"";

					if ($kunena_emoticons ['pms']) {
						$msg_html->pms .= KUNENA_URLICONSPATH . $kunena_emoticons ['pms'];
					} else {
						$msg_html->pms .= KUNENA_URLEMOTIONSPATH . "sendpm.gif";
					}

					$msg_html->pms .= "\" alt=\"" . _VIEW_PMS . "\" border=\"0\" title=\"" . _VIEW_PMS . "\" /></a>";
				}

				// online - ofline status
				if ($userinfo->userid > 0) {
					static $onlinecache = array ();
					if (! isset ( $onlinecache [$userinfo->userid] )) {
						$sql = "SELECT COUNT(userid) FROM #__session WHERE userid='{$userinfo->userid}'";
						$kunena_db->setQuery ( $sql );
						$onlinecache [$userinfo->userid] = $kunena_db->loadResult ();
					}
					$isonline = $onlinecache [$userinfo->userid];

					if ($isonline && $userinfo->showOnline == 1) {
						$msg_html->online = isset ( $kunena_emoticons ['onlineicon'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['onlineicon'] . '" border="0" alt="' . _MODLIST_ONLINE . '" />' : '  <img src="' . KUNENA_URLEMOTIONSPATH . 'onlineicon.gif" border="0"  alt="' . _MODLIST_ONLINE . '" />';
					} else {
						$msg_html->online = isset ( $kunena_emoticons ['offlineicon'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['offlineicon'] . '" border="0" alt="' . _MODLIST_OFFLINE . '" />' : '  <img src="' . KUNENA_URLEMOTIONSPATH . 'offlineicon.gif" border="0"  alt="' . _MODLIST_OFFLINE . '" />';
					}
				}
				/* PM integration */
				if ($kunena_config->pm_component == "jomsocial" && $userinfo->userid && $kunena_my->id) {
					$onclick = CMessaging::getPopup ( $userinfo->userid );
					$msg_html->pms = '<a href="javascript:void(0)" onclick="' . $onclick . "\">";

					if ($kunena_emoticons ['pms']) {
						$msg_html->pms .= "<img src=\"" . KUNENA_URLICONSPATH . $kunena_emoticons ['pms'] . "\" alt=\"" . _VIEW_PMS . "\" border=\"0\" title=\"" . _VIEW_PMS . "\" />";
					} else {
						$msg_html->pms .= _VIEW_PMS;
					}

					$msg_html->pms .= "</a>";
				}
				//Check if the Integration settings are on, and set the variables accordingly.
				if ($kunena_config->fb_profile == "cb") {
					if ($kunena_config->fb_profile == 'cb' && $userinfo->userid > 0) {
						$msg_html->prflink = CKunenaCBProfile::getProfileURL ( $userinfo->userid );
						$msg_html->profile = "<a href=\"" . $msg_html->prflink . "\">                                              <img src=\"";

						if ($kunena_emoticons ['userprofile']) {
							$msg_html->profile .= KUNENA_URLICONSPATH . $kunena_emoticons ['userprofile'];
						} else {
							$msg_html->profile .= KUNENA_JLIVEURL . "/components/com_comprofiler/images/profiles.gif";
						}

						$msg_html->profile .= "\" alt=\"" . _VIEW_PROFILE . "\" border=\"0\" title=\"" . _VIEW_PROFILE . "\" /></a>";
					}
				} else if ($userinfo->gid > 0) {
					//Kunena Profile link.
					$msg_html->prflink = JRoute::_ ( KUNENA_LIVEURLREL . '&amp;func=fbprofile&amp;task=showprf&amp;userid=' . $userinfo->userid );
					$msg_html->profileicon = "<img src=\"";

					if ($kunena_emoticons ['userprofile']) {
						$msg_html->profileicon .= KUNENA_URLICONSPATH . $kunena_emoticons ['userprofile'];
					} else {
						$msg_html->profileicon .= KUNENA_URLICONSPATH . "profile.gif";
					}

					$msg_html->profileicon .= "\" alt=\"" . _VIEW_PROFILE . "\" border=\"0\" title=\"" . _VIEW_PROFILE . "\" />";
					$msg_html->profile = CKunenaLink::GetProfileLink ( $kunena_config, $userinfo->userid, $msg_html->profileicon );
				}

				// Begin: Additional Info //
				if ($userinfo->gender != '') {
					$gender = _KUNENA_NOGENDER;
					if ($userinfo->gender == 1) {
						$gender = '' . _KUNENA_MYPROFILE_MALE;
						$msg_html->gender = isset ( $kunena_emoticons ['msgmale'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgmale'] . '" border="0" alt="' . _KUNENA_MYPROFILE_GENDER . ': ' . $gender . '" title="' . _KUNENA_MYPROFILE_GENDER . ': ' . $gender . '" />' : '' . _KUNENA_MYPROFILE_GENDER . ': ' . $gender . '';
					}

					if ($userinfo->gender == 2) {
						$gender = '' . _KUNENA_MYPROFILE_FEMALE;
						$msg_html->gender = isset ( $kunena_emoticons ['msgfemale'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgfemale'] . '" border="0" alt="' . _KUNENA_MYPROFILE_GENDER . ': ' . $gender . '" title="' . _KUNENA_MYPROFILE_GENDER . ': ' . $gender . '" />' : '' . _KUNENA_MYPROFILE_GENDER . ': ' . $gender . '';
					}

				}

				if ($userinfo->personalText != '') {
					$msg_html->personal = kunena_htmlspecialchars ( stripslashes ( $userinfo->personalText ) );
				}

				if ($userinfo->ICQ != '') {
					$msg_html->icq = '<a href="http://www.icq.com/people/cmd.php?uin=' . kunena_htmlspecialchars ( stripslashes ( $userinfo->ICQ ) ) . '&action=message"><img src="http://status.icq.com/online.gif?icq=' . kunena_htmlspecialchars ( stripslashes ( $userinfo->ICQ ) ) . '&img=5" title="ICQ#: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->ICQ ) ) . '" alt="ICQ#: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->ICQ ) ) . '" /></a>';
				}
				if ($userinfo->location != '') {
					$msg_html->location = isset ( $kunena_emoticons ['msglocation'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msglocation'] . '" border="0" alt="' . _KUNENA_MYPROFILE_LOCATION . ': ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->location ) ) . '" title="' . _KUNENA_MYPROFILE_LOCATION . ': ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->location ) ) . '" />' : ' ' . _KUNENA_MYPROFILE_LOCATION . ': ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->location ) ) . '';
				}
				if ($userinfo->birthdate != '0001-01-01' and $userinfo->birthdate != '0000-00-00' and $userinfo->birthdate != '') {
					$birthday = strftime ( _KUNENA_DT_MONTHDAY_FMT, strtotime ( $userinfo->birthdate ) );
					$msg_html->birthdate = isset ( $kunena_emoticons ['msgbirthdate'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgbirthdate'] . '" border="0" alt="' . _KUNENA_PROFILE_BIRTHDAY . ': ' . $birthday . '" title="' . _KUNENA_PROFILE_BIRTHDAY . ': ' . $birthday . '" />' : ' ' . _KUNENA_PROFILE_BIRTHDAY . ': ' . $birthday . '';
				}

				if ($userinfo->AIM != '') {
					$msg_html->aim = isset ( $kunena_emoticons ['msgaim'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgaim'] . '" border="0" alt="' . kunena_htmlspecialchars ( stripslashes ( $userinfo->AIM ) ) . '" title="AIM: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->AIM ) ) . '" />' : 'AIM: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->AIM ) ) . '';
				}
				if ($userinfo->MSN != '') {
					$msg_html->msn = isset ( $kunena_emoticons ['msgmsn'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgmsn'] . '" border="0" alt="' . kunena_htmlspecialchars ( stripslashes ( $userinfo->MSN ) ) . '" title="MSN: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->MSN ) ) . '" />' : 'MSN: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->MSN ) ) . '';
				}
				if ($userinfo->YIM != '') {
					$msg_html->yim = isset ( $kunena_emoticons ['msgyim'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgyim'] . '" border="0" alt="' . kunena_htmlspecialchars ( stripslashes ( $userinfo->YIM ) ) . '" title="YIM: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->YIM ) ) . '" />' : ' YIM: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->YIM ) ) . '';
				}
				if ($userinfo->SKYPE != '') {
					$msg_html->skype = isset ( $kunena_emoticons ['msgskype'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgskype'] . '" border="0" alt="' . kunena_htmlspecialchars ( stripslashes ( $userinfo->SKYPE ) ) . '" title="SKYPE: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->SKYPE ) ) . '" />' : 'SKYPE: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->SKYPE ) ) . '';
				}
				if ($userinfo->GTALK != '') {
					$msg_html->gtalk = isset ( $kunena_emoticons ['msggtalk'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msggtalk'] . '" border="0" alt="' . kunena_htmlspecialchars ( stripslashes ( $userinfo->GTALK ) ) . '" title="GTALK: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->GTALK ) ) . '" />' : 'GTALK: ' . kunena_htmlspecialchars ( stripslashes ( $userinfo->GTALK ) ) . '';
				}
				if ($userinfo->websiteurl != '') {
					$msg_html->website = isset ( $kunena_emoticons ['msgwebsite'] ) ? '<a href="http://' . kunena_htmlspecialchars ( stripslashes ( $userinfo->websiteurl ) ) . '" target="_blank"><img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['msgwebsite'] . '" border="0" alt="' . kunena_htmlspecialchars ( stripslashes ( $userinfo->websitename ) ) . '" title="' . kunena_htmlspecialchars ( stripslashes ( $userinfo->websitename ) ) . '" /></a>' : '<a href="http://' . kunena_htmlspecialchars ( stripslashes ( $userinfo->websiteurl ) ) . '" target="_blank">' . kunena_htmlspecialchars ( stripslashes ( $userinfo->websitename ) ) . '</a>';
				}

				// Finish: Additional Info //


				//Show admins the IP address of the user:
				if (CKunenaTools::isModerator($kunena_my->id, $catid)) {
					$msg_html->ip = $this->kunena_message->ip;
				}

				$fb_subject_txt = $this->kunena_message->subject;

				//$table = array_flip ( get_html_translation_table ( HTML_ENTITIES ) );
				//$fb_subject_txt = strtr ( $fb_subject_txt, $table );
				$fb_subject_txt = stripslashes ( $fb_subject_txt );
				//$fb_subject_txt = smile::htmlwrap ( $fb_subject_txt, $kunena_config->wrap );
				$msg_html->subject = $fb_subject_txt;

				$msg_html->date = date ( _DATETIME, $this->kunena_message->time );
				$fb_message_txt = stripslashes ( $this->kunena_message->message );
				$fb_message_txt = smile::smileReplace ( $fb_message_txt, 0, $kunena_config->disemoticons, $smileyList );
				$fb_message_txt = nl2br ( $fb_message_txt );

				// Code tag: restore TABS as we had to 'hide' them from the rest of the logic
				$fb_message_txt = str_replace ( "__FBTAB__", "&#009;", $fb_message_txt );
				$fb_message_txt = smile::htmlwrap ( $fb_message_txt, $kunena_config->wrap );

				$msg_html->text = CKunenaTools::prepareContent ( $fb_message_txt );

				$signature = $userinfo->signature;
				if ($signature) {
					$signature = stripslashes ( smile::smileReplace ( $signature, 0, $kunena_config->disemoticons, $smileyList ) );
					$signature = nl2br ( $signature );
					//wordwrap:
					$signature = smile::htmlwrap ( $signature, $kunena_config->wrap );
					//restore the \n (were replaced with _CTRL_) occurences inside code tags, but only after we have striplslashes; otherwise they will be stripped again
					//$signature = str_replace("_CRLF_", "\\n", stripslashes($signature));
					$msg_html->signature = $signature;
				}

				if (CKunenaTools::isModerator($kunena_my->id, $catid) || (($this->kunena_forum_locked == 0 && $topicLocked == 0) && ($kunena_my->id > 0 || $kunena_config->pubwrite))) {
					//user is allowed to reply/quote
					$msg_html->reply = CKunenaLink::GetTopicPostReplyLink ( 'reply', $catid, $this->kunena_message->id, isset ( $kunena_emoticons ['reply'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['reply'] . '" alt="Reply" border="0" title="' . _VIEW_REPLY . '" />' : _GEN_REPLY );
					$msg_html->quote = CKunenaLink::GetTopicPostReplyLink ( 'quote', $catid, $this->kunena_message->id, isset ( $kunena_emoticons ['quote'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['quote'] . '" alt="Quote" border="0" title="' . _VIEW_QUOTE . '" />' : _GEN_QUOTE );
				} else {
					//user is not allowed to write a post
					if ($topicLocked == 1 || $this->kunena_forum_locked) {
						$msg_html->closed = _POST_LOCK_SET;
					} else {
						$msg_html->closed = _VIEW_DISABLED;
					}
				}

				$showedEdit = 0; //reset this value
				//Offer an moderator the delete link
				if (CKunenaTools::isModerator($kunena_my->id, $catid)) {
					$msg_html->delete = CKunenaLink::GetTopicPostLink ( 'delete', $catid, $this->kunena_message->id, isset ( $kunena_emoticons ['delete'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['delete'] . '" alt="Delete" border="0" title="' . _VIEW_DELETE . '" />' : _GEN_DELETE );
					$msg_html->merge = CKunenaLink::GetTopicPostLink ( 'merge', $catid, $this->kunena_message->id, isset ( $kunena_emoticons ['merge'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['merge'] . '" alt="' . _GEN_MERGE . '" border="0" title="' . _GEN_MERGE . '" />' : _GEN_MERGE );
				}

				if ($kunena_config->useredit && $kunena_my->id != "") {
					//Now, if the viewer==author and the viewer is allowed to edit his/her own post then offer an 'edit' link
					$allowEdit = 0;
					if ($kunena_my->id == $userinfo->userid) {
						if ((( int ) $kunena_config->useredittime) == 0) {
							$allowEdit = 1;
						} else {
							//Check whether edit is in time
							$modtime = $this->kunena_message->modified_time;
							if (! $modtime) {
								$modtime = $this->kunena_message->time;
							}
							if (($modtime + (( int ) $kunena_config->useredittime)) >= CKunenaTools::fbGetInternalTime ()) {
								$allowEdit = 1;
							}
						}
					}
					if ($allowEdit) {
						$msg_html->edit = CKunenaLink::GetTopicPostLink ( 'edit', $catid, $this->kunena_message->id, isset ( $kunena_emoticons ['edit'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['edit'] . '" alt="Edit" border="0" title="' . _VIEW_EDIT . '" />' : _GEN_EDIT );
						$showedEdit = 1;
					}
				}

				if (CKunenaTools::isModerator($kunena_my->id, $catid) && $showedEdit != 1) {
					//Offer a moderator always the edit link except when it is already showing..
					$msg_html->edit = CKunenaLink::GetTopicPostLink ( 'edit', $catid, $this->kunena_message->id, isset ( $kunena_emoticons ['edit'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['edit'] . '" alt="Edit" border="0" title="' . _VIEW_EDIT . '" />' : _GEN_EDIT );
				}

				//(JJ)
				if (file_exists ( KUNENA_ABSTMPLTPATH . '/message.php' )) {
					include (KUNENA_ABSTMPLTPATH . '/message.php');
				} else {
					include (KUNENA_PATH_TEMPLATE_DEFAULT . DS . 'message.php');
				}

				unset ( $msg_html );
				$useGraph = 0;
			} // end for
		}
		?>
		</td>
	</tr>
</table>


<!-- B: List Actions Bottom -->
<table class="fb_list_actions_bottom" border="0" cellspacing="0"
	cellpadding="0" width="100%">
	<tr>
		<td class="fb_list_actions_goto"><?php
		//go to top
		echo '<a name="forumbottom" /> ';
		echo CKunenaLink::GetSamePageAnkerLink ( 'forumtop', isset ( $kunena_emoticons ['toparrow'] ) ? '<img src="' . KUNENA_URLICONSPATH . $kunena_emoticons ['toparrow'] . '" border="0" alt="' . _GEN_GOTOTOP . '" title="' . _GEN_GOTOTOP . '"/>' : _GEN_GOTOTOP );

		echo '</td>';

		if (CKunenaTools::isModerator($kunena_my->id, $catid) || isset ( $thread_reply ) || isset ( $thread_subscribe ) || isset ( $thread_favorite )) {
			echo '<td class="fb_list_actions_forum">';
			echo '<div class="fb_message_buttons_row" style="text-align: center;">';
			if (isset ( $thread_reply ))
				echo $thread_reply;
			if (isset ( $thread_subscribe ))
				echo ' ' . $thread_subscribe;
			if (isset ( $thread_favorite ))
				echo ' ' . $thread_favorite;
			echo '</div>';
			if (CKunenaTools::isModerator($kunena_my->id, $catid)) {
				echo '<div class="fb_message_buttons_row" style="text-align: center;">';
				echo $thread_delete;
				echo ' ' . $thread_move;
				echo ' ' . $thread_sticky;
				echo ' ' . $thread_lock;
				echo '</div>';
			}
			echo '</td>';
		}
		echo '<td class="fb_list_actions_forum" width="100%">';
		if (isset ( $thread_new )) {
			echo '<div class="fb_message_buttons_row" style="text-align: left;">';
			echo $thread_new;
			echo '</div>';
		}
		if (isset ( $thread_merge )) {
			echo '<div class="fb_message_buttons_row" style="text-align: left;">';
			echo $thread_merge;
			echo '</div>';
		}
		echo '</td>';

		echo '<td class="fb_list_pages_all" nowrap="nowrap">';
		echo $pagination;
		echo '</td>';
		?>


		</td>
	</tr>
</table>
<?php
		echo '<div class = "' . KUNENA_BOARD_CLASS . 'forum-pathway-bottom">';
		echo $this->kunena_pathway1;
		echo '</div>';
		?>
<!-- F: List Actions Bottom -->

<!-- B: Category List Bottom -->

<table class="fb_list_bottom" border="0" cellspacing="0" cellpadding="0"
	width="100%">
	<tr>
		<td class="fb_list_moderators"><!-- Mod List --> <?php
		//get the Moderator list for display
		$kunena_db->setQuery ( "SELECT m.*, u.* FROM #__fb_moderation AS m LEFT JOIN #__users AS u ON u.id=m.userid WHERE m.catid={$catid}" );
		$modslist = $kunena_db->loadObjectList ();
		check_dberror ( "Unable to load moderators." );
		?>

		<?php
		if (count ( $modslist ) > 0) {
			?>
		<div class="fbbox-bottomarea-modlist"><?php
			echo '' . _GEN_MODERATORS . ": ";

			$mod_cnt = 0;
			foreach ( $modslist as $mod ) {
				if ($mod_cnt)
					echo ', ';
				$mod_cnt ++;
				echo CKunenaLink::GetProfileLink ( $kunena_config, $mod->userid, ($kunena_config->username ? $mod->username : $mod->name) );
			}
			?>
		</div>
		<?php
		}
		?> <!-- /Mod List --></td>
		<td class="fb_list_categories"><?php
		if ($kunena_config->enableforumjump)
			require (KUNENA_PATH_LIB . DS . 'kunena.forumjump.php');
		?>
		</td>
	</tr>
</table>
<!-- F: Category List Bottom -->

<?php
	}
} else {
	echo _KUNENA_NO_ACCESS;
}

if ($kunena_config->highlightcode) {
	echo '
	<script type="text/javascript" src="' . KUNENA_DIRECTURL . '/template/default/plugin/chili/jquery.chili-2.2.js"></script>
	<script id="setup" type="text/javascript">
	ChiliBook.recipeFolder     = "' . KUNENA_DIRECTURL . '/template/default/plugin/chili/";
	ChiliBook.stylesheetFolder     = "' . KUNENA_DIRECTURL . '/template/default/plugin/chili/";
	</script>
	';
}

?>