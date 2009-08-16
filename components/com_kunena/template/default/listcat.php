<?php
/**
* @version $Id$
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
defined( '_JEXEC' ) or die('Restricted access');
$kunena_my = &JFactory::getUser();
$kunenaConfig =& CKunenaConfig::getInstance();
//securing passed form elements
$catid = (int)$catid;

//resetting some things:
$moderatedForum = 0;
$lockedForum = 0;
// Start getting the categories
$kunena_db->setQuery("SELECT * FROM #__kunena_categories WHERE parent='0' and published='1' ORDER BY ordering");
$allCat = $kunena_db->loadObjectList();
	check_dberror("Unable to load categories.");

$threadids = array ();
$categories = array ();

$smileyList = smile::getEmoticons(0);

// set page title
$document=& JFactory::getDocument();
$document->setTitle(_GEN_FORUMLIST . ' - ' . stripslashes($kunenaConfig->board_title));

if (count($allCat) > 0)
{
    foreach ($allCat as $category)
    {
        $threadids[] = $category->id;
        $categories[$category->parent][] = $category;
    }
}

//Let's check if the only thing we need to show is 1 category
if (in_array($catid, $threadids))
{
    //Yes, so now $threadids should contain only the current $catid:
    unset ($threadids);
    $threadids[] = $catid;
    //get new categories list for this category only:
    unset ($categories);
    $kunena_db->setQuery("SELECT * FROM #__kunena_categories WHERE parent='0' AND published='1' and id='{$catid}' ORDER BY ordering");
    $categories[$category->parent] = $kunena_db->loadObjectList();
    	check_dberror("Unable to load category.");
}

//get the allowed forums and turn it into an array
$allow_forum = ($kunenaSession->allowed <> '')?explode(',', $kunenaSession->allowed):array();

// (JJ) BEGIN: ANNOUNCEMENT BOX
if ($kunenaConfig->showannouncement > 0)
{
?>
<!-- B: announcementBox -->
<?php
    if (file_exists(KUNENA_ABSTMPLTPATH . '/plugin/announcement/announcementbox.php')) {
        require_once (KUNENA_ABSTMPLTPATH . '/plugin/announcement/announcementbox.php');
    }
    else {
        require_once (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'plugin/announcement/announcementbox.php');
    }
?>
<!-- F: announcementBox -->
<?php
}
// (JJ) FINISH: ANNOUNCEMENT BOX

// load module

if (JDocumentHTML::countModules('kunena_announcement'))
{
?>

    <div class = "kunena_kunena_2">
        <?php
        	$document	= &JFactory::getDocument();
        	$renderer	= $document->loadRenderer('modules');
        	$options	= array('style' => 'xhtml');
        	$position	= 'kunena_announcement';
        	echo $renderer->render($position, $options, null);
        ?>
    </div>

<?php
}
?>
<!-- B: Pathway -->
<?php
if (file_exists(KUNENA_ABSTMPLTPATH . '/kunena_pathway.php')) {
    require_once (KUNENA_ABSTMPLTPATH . '/kunena_pathway.php');
}
else {
    require_once (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'kunena_pathway.php');
}
?>
<!-- F: Pathway -->
<?php
if (count($categories[0]) > 0)
{
    foreach ($categories[0] as $cat)
    {
        $obj_kunena_cat = new jbCategory($kunena_db, $cat->id);

        $is_Mod = kunena_has_moderator_permission($kunena_db, $obj_kunena_cat, $kunena_my->id, $is_admin);

        if (in_array($cat->id, $allow_forum))
        {
?>
            <!-- B: List Cat -->
<div class="<?php echo $boardclass; ?>_bt_cvr1" id="kunena_block<?php echo $cat->id ; ?>">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
            <table class = "kunena_blocktable<?php echo $cat->class_sfx; ?>"  width="100%" id = "kunena_cat<?php echo $cat->id ; ?>" border = "0" cellspacing = "0" cellpadding = "0">
                <thead>
                    <tr>
                        <th colspan = "5">
                            <div class = "kunena_title_cover kunenam" >
                                <?php
                                echo CKunenaLink::GetCategoryLink('listcat', $cat->id, kunena_htmlspecialchars(stripslashes($cat->name)), 'follow', $class='kunena_title kunenal');

                                if ($cat->description != "") {
                                    $tmpforumdesc = stripslashes(smile::smileReplace($cat->description, 0, $kunenaConfig->disemoticons, $smileyList));
							        $tmpforumdesc = nl2br($tmpforumdesc);
							        $tmpforumdesc = smile::htmlwrap($tmpforumdesc, $kunenaConfig->wrap);
									echo $tmpforumdesc;
                                }
                                ?>
                            </div>
                            <img id = "BoxSwitch_<?php echo $cat->id ; ?>__catid_<?php echo $cat->id ; ?>" class = "hideshow" src = "<?php echo KUNENA_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                        </th>
                    </tr>
                </thead>
                <tbody id = "catid_<?php echo $cat->id ; ?>">
                    <tr class = "kunena_sth kunenas ">
                        <th class = "th-1 <?php echo $boardclass; ?>sectiontableheader" width="1%">&nbsp;</th>
                        <th class = "th-2 <?php echo $boardclass; ?>sectiontableheader" align="left"><?php echo _GEN_FORUM; ?></th>
                        <th class = "th-3 <?php echo $boardclass; ?>sectiontableheader" align="center" width="5%"><?php echo _GEN_TOPICS; ?></th>

                        <th class = "th-4 <?php echo $boardclass; ?>sectiontableheader" align="center" width="5%">
<?php echo _GEN_REPLIES; ?>
                        </th>

                        <th class = "th-5 <?php echo $boardclass; ?>sectiontableheader" align="left" width="25%">
<?php echo _GEN_LAST_POST; ?>
                        </th>
                    </tr>

                    <?php
                    //    show forums within the categories
                    $kunena_db->setQuery(
                    "SELECT c.*, m.id AS mesid, m.subject, m.catid, m.name AS mname, m.userid, u.id AS uid, u.username, u.name AS uname
                    FROM #__kunena_categories AS c
                    LEFT JOIN #__kunena_messages AS m ON c.id_last_msg = m.id
                    LEFT JOIN #__users AS u ON u.id = m.userid
                    WHERE c.parent='{$cat->id}' AND c.published='1'
                    ORDER BY ordering");
                    $rows = $kunena_db->loadObjectList();
                    	check_dberror("Unable to load categories.");

                    $tabclass = array
                    (
                        "sectiontableentry1",
                        "sectiontableentry2"
                    );

                    $k = 0;

                    if (sizeof($rows) == 0) {
                        echo '' . _GEN_NOFORUMS . '';
                    }
                    else
                    {
                        foreach ($rows as $singlerow)
                        {

                            $obj_kunena_cat = new jbCategory($kunena_db, $singlerow->id);
                            $is_Mod = kunena_has_moderator_permission($kunena_db, $obj_kunena_cat, $kunena_my->id, $is_admin);

                            if (in_array($singlerow->id, $allow_forum))
                            {
                                //    $k=for alternating row colors:
                                $k = 1 - $k;

                                $numtopics = $singlerow->numTopics;
                                $numreplies = $singlerow->numPosts;
                                $lastPosttime = $singlerow->time_last_msg;
                                $lastptime = KUNENA_timeformat(CKunenaTools::kunenaGetShowTime($singlerow->time_last_msg));

                                $forumDesc = stripslashes(smile::smileReplace($singlerow->description, 0, $kunenaConfig->disemoticons, $smileyList));
						        $forumDesc = nl2br($forumDesc);
						        $forumDesc = smile::htmlwrap($forumDesc, $kunenaConfig->wrap);

                                //    Get the forumsubparent categories :: get the subcategories here
                                $kunena_db->setQuery("SELECT id, name, numTopics, numPosts FROM #__kunena_categories WHERE parent='{$singlerow->id}' AND published='1' ORDER BY ordering");
                                $forumparents = $kunena_db->loadObjectList();
                                	check_dberror("Unable to load categories.");

								foreach ($forumparents as $childnum=>$childforum)
								{
									if (!in_array($childforum->id, $allow_forum)) unset ($forumparents[$childnum]); 
								}
								$forumparents = array_values($forumparents);

                                if ($kunena_my->id)
                                {
                                    //    get all threads with posts after the users last visit; don't bother for guests
                                    $kunena_db->setQuery("SELECT DISTINCT thread FROM #__kunena_messages WHERE catid='{$singlerow->id}' AND hold='0' AND time>'{$prevCheck}' GROUP BY thread");
                                    $newThreadsAll = $kunena_db->loadObjectList();
                                    	check_dberror("Unable to load message threads.");

                                    if (count($newThreadsAll) == 0) {
                                        $newThreadsAll = array ();
                                    }
                                }

                                // get pending messages if user is a Moderator for that forum
                                $kunena_db->setQuery("SELECT userid FROM #__kunena_moderation WHERE catid='{$singlerow->id}'");
                                $moderatorList = $kunena_db->loadObjectList();
                                	check_dberror("Unable to load moderators.");
                                $modIDs[] = array ();

                                array_splice($modIDs, 0);

                                if (count($moderatorList) > 0)
                                {
                                    foreach ($moderatorList as $ml) {
                                        $modIDs[] = $ml->userid;
                                    }
                                }

                                $nummodIDs = count($modIDs);
                                $numPending = 0;

                                if ((in_array($kunena_my->id, $modIDs)) || $is_admin == 1)
                                {
                                    $kunena_db->setQuery("SELECT COUNT(*) FROM #__kunena_messages WHERE catid='{$singlerow->id}' AND hold='1'");
                                    $numPending = $kunena_db->loadResult();
                                    $is_Mod = 1;
                                }

                                $numPending = (int)$numPending;
                                //    get latest post info
                                unset($thisThread);
                                $kunena_db->setQuery(
                                "SELECT m.thread, COUNT(*) AS totalmessages
                                FROM #__kunena_messages AS m
                                LEFT JOIN #__kunena_messages AS mm ON m.thread=mm.thread
                                WHERE m.id='{$singlerow->id_last_msg}'
                                GROUP BY m.thread");
                                $thisThread = $kunena_db->loadObject();
                                if (!is_object($thisThread))
                                {
                                	$thisThread = new stdClass();
                                	$thisThread->totalmessages = 0;
                                	$thisThread->thread = 0;
                                }
                                $latestthreadpages = ceil($thisThread->totalmessages / $kunenaConfig->messages_per_page);
                                $latestthread = $thisThread->thread;
                                $latestname = $singlerow->mname;
                                $latestcatid = stripslashes($singlerow->catid);
                                $latestid = $singlerow->id_last_msg;
                                $latestsubject = html_entity_decode_utf8(stripslashes($singlerow->subject));
                                $latestuserid = $singlerow->userid;
                    ?>

                                <tr class = "<?php echo ''.$boardclass.'' . $tabclass[$k] . ''; ?>" id="kunena_cat<?php echo $singlerow->id ?>">
                                    <td class = "td-1" align="center">
                                        <?php
                                        $tmpIcon = '';
                                        $cxThereisNewInForum = 0;
                                        if ($kunenaConfig->shownew && $kunena_my->id != 0)
                                        {
                                            //Check if unread threads are in any of the forums topics
                                            $newPostsAvailable = 0;

                                            foreach ($newThreadsAll as $nta)
                                            {
                                                if (!in_array($nta->thread, $read_topics)) {
                                                    $newPostsAvailable++;
                                                }
                                            }

                                            if ($newPostsAvailable > 0 && count($newThreadsAll) != 0)
                                            {
                                                $cxThereisNewInForum = 1;

                                                // Check Unread    Cat Images
                                                if (is_file(KUNENA_ABSCATIMAGESPATH . $singlerow->id . "_on.gif"))
                                                {
                                                    $tmpIcon = '<img src="'.KUNENA_URLCATIMAGES.$singlerow->id.'_on.gif" border="0" class="forum-cat-image"alt=" " />';
                                                }
                                                else
                                                {
                                                    $tmpIcon = isset($kunenaIcons['unreadforum']) ? '<img src="'.KUNENA_URLICONSPATH.$kunenaIcons['unreadforum'].'" border="0" alt="'._GEN_FORUM_NEWPOST.'" title="'._GEN_FORUM_NEWPOST.'" />' : stripslashes($kunenaConfig->newchar);
                                                }
                                            }
                                            else
                                            {
                                                // Check Read Cat Images
                                                if (is_file(KUNENA_ABSCATIMAGESPATH . $singlerow->id . "_off.gif"))
                                                {
                                                    $tmpIcon = '<img src="'.KUNENA_URLCATIMAGES.$singlerow->id.'_off.gif" border="0" class="forum-cat-image" alt=" " />';
                                                }
                                                else
                                                {
                                                    $tmpIcon = isset($kunenaIcons['readforum']) ? '<img src="'.KUNENA_URLICONSPATH.$kunenaIcons['readforum'].'" border="0" alt="'._GEN_FORUM_NOTNEW.'" title="'._GEN_FORUM_NOTNEW.'" />' : stripslashes($kunenaConfig->newchar);
                                                }
                                            }
                                        }
                                        // Not Login Cat Images
                                        else
                                        {
                                            if (is_file(KUNENA_ABSCATIMAGESPATH . $singlerow->id . "_notlogin.gif")) {
                                                $tmpIcon = '<img src="'.KUNENA_URLCATIMAGES.$singlerow->id.'_notlogin.gif" border="0" class="forum-cat-image" alt=" " />';
                                            }
                                            else {
                                                $tmpIcon = isset($kunenaIcons['notloginforum']) ? '<img src="'.KUNENA_URLICONSPATH.$kunenaIcons['notloginforum'].'" border="0" alt="'._GEN_FORUM_NOTNEW.'" title="'._GEN_FORUM_NOTNEW.'" />' : stripslashes($kunenaConfig->newchar);
                                            }
                                        }
                                        echo CKunenaLink::GetCategoryLink('showcat', $singlerow->id, $tmpIcon);
                                        ?>
                                    </td>

                                    <td class = "td-2" align="left">
                                        <div class = "<?php echo $boardclass ?>thead-title kunenal">
                                            <?php //new posts available
                                            echo CKunenaLink::GetCategoryLink('showcat', $singlerow->id, kunena_htmlspecialchars(stripslashes($singlerow->name)));

                                            if ($cxThereisNewInForum == 1 && $kunena_my->id > 0) {
                                                echo '<sup><span class="newchar">&nbsp;(' . $newPostsAvailable . ' ' . $kunenaConfig->newchar . ")</span></sup>";
                                            }

                                            $cxThereisNewInForum = 0;
                                            ?>

                                            <?php
                                            if ($singlerow->locked)
                                            {
                                                echo isset($kunenaIcons['forumlocked']) ? '&nbsp;&nbsp;<img src="' . KUNENA_URLICONSPATH . $kunenaIcons['forumlocked']
                                                         . '" border="0" alt="' . _GEN_LOCKED_FORUM . '" title="' . _GEN_LOCKED_FORUM . '"/>' : '&nbsp;&nbsp;<img src="' . KUNENA_URLEMOTIONSPATH . 'lock.gif"  border="0" alt="' . _GEN_LOCKED_FORUM . '">';
                                                $lockedForum = 1;
                                            }

                                            if ($singlerow->review)
                                            {
                                                echo isset($kunenaIcons['forummoderated']) ? '&nbsp;&nbsp;<img src="' . KUNENA_URLICONSPATH . $kunenaIcons['forummoderated']
                                                         . '" border="0" alt="' . _GEN_MODERATED . '" title="' . _GEN_MODERATED . '"/>' : '&nbsp;&nbsp;<img src="' . KUNENA_URLEMOTIONSPATH . 'review.gif" border="0"  alt="' . _GEN_MODERATED . '">';
                                                $moderatedForum = 1;
                                            }
                                            ?>
                                        </div>

                                        <?php
                                        if ($forumDesc != "")
                                        {
                                        ?>

                                            <div class = "<?php echo $boardclass ?>thead-desc kunenam">
<?php echo $forumDesc ?>
                                            </div>

                                        <?php
                                        }

                                        // loop over subcategories to show them under
                                        if (count($forumparents) > 0)
                                        {
                                        ?>

                                            <div class = "<?php echo $boardclass?>thead-child">
                                                <div class = "<?php echo $boardclass?>cc-childcat-title kunenas">
                                                    <b><?php if(count($forumparents)==1) { echo _KUNENA_CHILD_BOARD; } else { echo _KUNENA_CHILD_BOARDS; } ?>:</b>
                                                </div>

                                                <table cellpadding = "0" cellspacing = "0" border = "0" class = "<?php echo $boardclass?>cc-table">
                                                    <?php
                                                    //row index
                                                    $ir9 = 0;
                                                    $cfg_numforums = $kunenaConfig->numchildcolumn>0 ? $kunenaConfig->numchildcolumn : 2;
                                                    $num_rows = ceil(count($forumparents) / $cfg_numforums);

                                                    //     foreach ($forumparents as $forumparent)
                                                    for ($row_count = 0; $row_count < $num_rows; $row_count++)
                                                    {
                                                        echo '<tr>';

                                                        for ($col_count = 0; $col_count < $cfg_numforums; $col_count++)
                                                        {
                                                            echo '<td width="' . floor(100 / $cfg_numforums) . '%" class="' . $boardclass . 'cc-sectiontableentry1 kunenam">';

                                                            $forumparent = @$forumparents[$ir9];

                                                            if ($forumparent)
                                                            {

                                                                //Begin: parent read unread iconset
                                                                if ($kunenaConfig->showchildcaticon)
                                                                {
                                                                    //
                                                                    if ($kunenaConfig->shownew && $kunena_my->id != 0)
                                                                    {
                                                                        //    get all threads with posts after the users last visit; don't bother for guests
                                                                        $kunena_db->setQuery("SELECT thread FROM #__kunena_messages WHERE catid='{$forumparent->id}' AND hold='0' AND time>'{$prevCheck}' GROUP BY thread");
                                                                        $newPThreadsAll = $kunena_db->loadObjectList();
                                                                        	check_dberror("Unable to load messages.");

                                                                        if (count($newPThreadsAll) == 0) {
                                                                            $newPThreadsAll = array ();
                                                                        }
                                                    ?>

                                                    <?php
                                                                        //Check if unread threads are in any of the forums topics
                                                                        $newPPostsAvailable = 0;

                                                                        foreach ($newPThreadsAll as $npta)
                                                                        {
                                                                            if (!in_array($npta->thread, $read_topics)) {
                                                                                $newPPostsAvailable++;
                                                                            }
                                                                        }

                                                                        if ($newPPostsAvailable > 0 && count($newPThreadsAll) != 0)
                                                                        {
                                                                            // Check Unread    Cat Images
                                                                            if (is_file(KUNENA_ABSCATIMAGESPATH . $forumparent->id . "_on_childsmall.gif")) {
                                                                                echo "<img src=\"" . KUNENA_URLCATIMAGES . $forumparent->id . "_on_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                                                            }
                                                                            else {
                                                                                echo isset($kunenaIcons['unreadforum']) ? '<img src="' . KUNENA_URLICONSPATH . $kunenaIcons['unreadforum_childsmall'] . '" border="0" alt="' . _GEN_FORUM_NEWPOST . '" title="' . _GEN_FORUM_NEWPOST . '" />' : stripslashes($kunenaConfig->newchar);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            // Check Read Cat Images
                                                                            if (is_file(KUNENA_ABSCATIMAGESPATH . $forumparent->id . "_off_childsmall.gif")) {
                                                                                echo "<img src=\"" . KUNENA_URLCATIMAGES . $forumparent->id . "_off_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                                                            }
                                                                            else {
                                                                                echo isset($kunenaIcons['readforum']) ? '<img src="' . KUNENA_URLICONSPATH . $kunenaIcons['readforum_childsmall'] . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : stripslashes($kunenaConfig->newchar);
                                                                            }
                                                                        }
                                                                    }
                                                                    // Not Login Cat Images
                                                                    else
                                                                    {
                                                                        if (is_file(KUNENA_ABSCATIMAGESPATH . $forumparent->id . "_notlogin_childsmall.gif")) {
                                                                            echo "<img src=\"" . KUNENA_URLCATIMAGES . $forumparent->id . "_notlogin_childsmall.gif\" border=\"0\" class='forum-cat-image' alt=\" \" />";
                                                                        }
                                                                        else {
                                                                            echo isset($kunenaIcons['notloginforum']) ? '<img src="' . KUNENA_URLICONSPATH . $kunenaIcons['notloginforum_childsmall'] . '" border="0" alt="' . _GEN_FORUM_NOTNEW . '" title="' . _GEN_FORUM_NOTNEW . '" />' : stripslashes($kunenaConfig->newchar);
                                                                        }
                                                    ?>

                                                    <?php
                                                                    }
                                                                //
                                                                }
                                                                // end: parent read unread iconset
                                                    ?>

                                                    <?php
                                                                echo CKunenaLink::GetCategoryLink('showcat', $forumparent->id, kunena_htmlspecialchars(stripslashes($forumparent->name)));
                                                                echo '<span class="kunena_childcount kunenas">('.$forumparent->numTopics."/".$forumparent->numPosts.')</span>';
                                                            }
                                                            echo "</td>";
                                                            $ir9++;
                                                        } // inner column loop

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </table>
                                            </div>

                                        <?php
                                        }

                                        //get the Moderator list for display
                                        $kunena_db->setQuery("SELECT * FROM #__kunena_moderation AS m LEFT JOIN #__users AS u ON u.id=m.userid WHERE m.catid='{$singlerow->id}'");
                                        $modslist = $kunena_db->loadObjectList();
                                        	check_dberror("Unable to load moderators.");

                                        // moderator list
                                        if (count($modslist) > 0)
                                        {
                                        ?>

                                            <div class = "<?php echo $boardclass ;?>thead-moderators kunenas">
<?php echo _GEN_MODERATORS; ?>:

                                                <?php
												$mod_cnt = 0;
                                                foreach ($modslist as $mod) {
					                               	if ($mod_cnt) echo ', '; 
					                               	$mod_cnt++;
													echo CKunenaLink::GetProfileLink($kunenaConfig, $mod->userid, ($kunenaConfig->username ? $mod->username : $mod->name));
                                                }
                                                ?>
                                            </div>

                                        <?php
                                        }

                                        if ($is_Mod)
                                        {
                                            if ($numPending > 0)
                                            {
                                                echo '<div class="kunenas"><font color="red"> ';
                                                echo CKunenaLink::GetPendingMessagesLink($singlerow->id, $numPending.' '._SHOWCAT_PENDING);
                                                echo '</font></div>';
                                            }
                                        }
                                        ?>
                                    </td>

                                    <td class = "td-3  kunenam" align="center" ><?php echo $numtopics; ?></td>

                                    <td class = "td-4  kunenam" align="center" >
<?php                                   echo $numreplies; ?>
                                    </td>

                                    <?php
                                    if ($numtopics != 0)
                                    {
                                    ?>

                                        <td class = "td-5" align="left">
                                            <div class = "<?php echo $boardclass ?>latest-subject kunenam">
<?php
                                               echo CKunenaLink::GetThreadPageLink($kunenaConfig, 'view', $singlerow->catid, $latestthread, $latestthreadpages, $kunenaConfig->messages_per_page, $latestsubject, $latestid);
?>
                                            </div>

                                            <div class = "<?php echo $boardclass ?>latest-subject-by kunenas">
<?php
                                                echo _GEN_BY.' ';
                                                echo CKunenaLink::GetProfileLink($kunenaConfig, $latestuserid, $latestname);
                                                echo ' | '.$lastptime.' ';
                                                echo CKunenaLink::GetThreadPageLink($kunenaConfig, 'view', $singlerow->catid, $latestthread, $latestthreadpages, $kunenaConfig->messages_per_page,
                                                isset($kunenaIcons['latestpost']) ? '<img src="'.KUNENA_URLICONSPATH.$kunenaIcons['latestpost'].'" border="0" alt="'._SHOW_LAST.'" title="'. _SHOW_LAST.'"/>' :
                                                                         '<img src="'.KUNENA_URLEMOTIONSPATH.'icon_newest_reply.gif" border="0"  alt="'._SHOW_LAST.'"/>', $latestid);
?>
                                            </div>
                                        </td>
                                </tr>

                                    <?php
                                    }
                                    else
                                    {
                                    ?>

                                        <td class = "td-5"  align="left">
<?php echo _NO_POSTS; ?>
                                        </td>

                                        </tr>

                    <?php
                                    }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>


 </div>
 </div>
 </div>
 </div>
 </div>
<!-- F: List Cat -->

<?php
        }
    }
?>

<?php
    //(JJ) BEGIN: RECENT POSTS
    if ($kunenaConfig->showlatest)
    {
        if (file_exists(KUNENA_ABSTMPLTPATH . '/plugin/recentposts/recentposts.php')) {
            include (KUNENA_ABSTMPLTPATH . '/plugin/recentposts/recentposts.php');
        }
        else {
            include (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'plugin/recentposts/recentposts.php');
        }
    }

    //(JJ) FINISH: RECENT POSTS

	if ($kunenaConfig->showstats)
    {

		//(JJ) BEGIN: STATS
		if (file_exists(KUNENA_ABSTMPLTPATH . '/plugin/stats/stats.class.php')) {
			include_once (KUNENA_ABSTMPLTPATH . '/plugin/stats/stats.class.php');
		}
		else {
			include_once (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'plugin/stats/stats.class.php');
		}

		if (file_exists(KUNENA_ABSTMPLTPATH . '/plugin/stats/frontstats.php')) {
			include (KUNENA_ABSTMPLTPATH . '/plugin/stats/frontstats.php');
		}
		else {
			include (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'plugin/stats/frontstats.php');
		}
	}

    //(JJ) FINISH: STATS

	if ($kunenaConfig->showwhoisonline)
    {

		//(JJ) BEGIN: WHOISONLINE
		if (file_exists(KUNENA_ABSTMPLTPATH . '/plugin/who/whoisonline.php')) {
			include (KUNENA_ABSTMPLTPATH . '/plugin/who/whoisonline.php');
		}
		else {
			include (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'plugin/who/whoisonline.php');
		}
		//(JJ) FINISH: WHOISONLINE

	}

    //(JJ) FINISH: CAT LIST BOTTOM
    if (file_exists(KUNENA_ABSTMPLTPATH . '/kunena_category_list_bottom.php')) {
        include (KUNENA_ABSTMPLTPATH . '/kunena_category_list_bottom.php');
    }
    else {
        include (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'kunena_category_list_bottom.php');
    }
?>

<?php
}
else
{
?>

    <div>
        <?php
        echo _LISTCAT_NO_CATS . '<br />';
        echo _LISTCAT_ADMIN . '<br />';
        echo _LISTCAT_PANEL . '<br /><br />';
        echo _LISTCAT_INFORM . '<br /><br />';
        echo _LISTCAT_DO . ' <img src="' . KUNENA_URLEMOTIONSPATH . 'wink.png"  alt="" border="0" />';
        ?>
    </div>

<?php
}
?>