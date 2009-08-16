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

defined( '_JEXEC' ) or die('Restricted access');

global $lang;

$kunenaConfig =& CKunenaConfig::getInstance();
$kunenaSession =& CKunenaSession::getInstance();

$Kunena_adm_path = KUNENA_PATH_ADMIN;
//Get right Language file
$Kunena_language_file = "$Kunena_adm_path/language/kunena.$lang.php";

if (file_exists($Kunena_language_file)) {
    require_once($Kunena_language_file);
    }
else {
    $Kunena_language_file = "$Kunena_adm_path/language/kunena.english.php";

    if (file_exists($Kunena_language_file)) {
        require_once($Kunena_language_file);
        }
    }

//Tabber check
//
$source_file = KUNENA_PATH_TEMPLATE_DEFAULT .DS. "plugin/recentposts/tabber.css";
$source_file = KUNENA_PATH_TEMPLATE_DEFAULT .DS. "plugin/recentposts/tabber.js";
$source_file = KUNENA_PATH_TEMPLATE_DEFAULT .DS. "plugin/recentposts/tabber-minimized.js";
$source_file = KUNENA_PATH_TEMPLATE_DEFAULT .DS. "plugin/recentposts/function.tabber.php";
//
$category = trim($kunenaConfig->latestcategory); // 2,3,4
$count = $kunenaConfig->latestcount;
$count_per_page = intval($kunenaConfig->latestcountperpage);
$show_author = $kunenaConfig->latestshowauthor; // 0 = none, 1= username, 2= realname
$singlesubject = $kunenaConfig->latestsinglesubject;
$replysubject = $kunenaConfig->latestreplysubject;
$subject_length = intval($kunenaConfig->latestsubjectlength);
$show_date = $kunenaConfig->latestshowdate;
$show_order_number = "1";
$tooltips_enable = "1";
$show_hits = $kunenaConfig->latestshowhits;

$topic_emoticons = array ();
$topic_emoticons[0] = KUNENA_URLEMOTIONSPATH . 'default.gif';
$topic_emoticons[1] = KUNENA_URLEMOTIONSPATH . 'exclam.gif';
$topic_emoticons[2] = KUNENA_URLEMOTIONSPATH . 'question.gif';
$topic_emoticons[3] = KUNENA_URLEMOTIONSPATH . 'arrow.gif';
$topic_emoticons[4] = KUNENA_URLEMOTIONSPATH . 'love.gif';
$topic_emoticons[5] = KUNENA_URLEMOTIONSPATH . 'grin.gif';
$topic_emoticons[6] = KUNENA_URLEMOTIONSPATH . 'shock.gif';
$topic_emoticons[7] = KUNENA_URLEMOTIONSPATH . 'smile.gif';
?>
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<table class = "kunena_blocktable" id = "kunena_recentposts" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
    <thead>
        <tr>
            <th colspan = "5">
                <div class = "kunena_title_cover kunenam">
                    <span class = "kunena_title kunenal"><?php echo _RECENT_RECENT_POSTS; ?></span>
                </div>

                <img id = "BoxSwitch_recentposts__recentposts_tbody" class = "hideshow" src = "<?php echo KUNENA_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
            </th>
        </tr>
    </thead>

    <tbody id = "recentposts_tbody">
        <tr>
            <td valign = "top">
                <?php

				// find messages
				$sq1 = ($category)?"AND msg2.catid in ($category)":"";
				if ($kunenaConfig->latestsinglesubject) {
					$sq2 = "SELECT msg1.* FROM (SELECT msg2.* FROM #__kunena_messages msg2"
						. " WHERE msg2.hold='0' AND moved='0' AND msg2.catid IN ($kunenaSession->allowed) $sq1 ORDER BY msg2.time"
						. (($kunenaConfig->latestreplysubject)?" DESC":"") . ") msg1"
						. " GROUP BY msg1.thread";
				} else {
					$sq2 = "SELECT msg2.* FROM #__kunena_messages msg2"
						. " WHERE msg2.hold='0' AND moved='0' AND msg2.catid IN ($kunenaSession->allowed) $sq1";
				}
				$query = " SELECT u.id, IFNULL(u.username, '"._KUNENA_GUEST."') AS username, IFNULL(u.name,'"._KUNENA_GUEST."') AS name,"
					. " msg.subject, msg.id AS kunenaid, msg.catid, from_unixtime(msg.time) AS date,"
					. " thread.hits AS hits, msg.locked, msg.topic_emoticon, msg.parent, cat.id AS catid, cat.name AS catname"
					. " FROM ($sq2) msg"
					. " LEFT JOIN #__users u ON u.id = msg.userid"
					. " LEFT JOIN #__kunena_categories cat ON cat.id = msg.catid"
					. " LEFT JOIN #__kunena_messages thread ON thread.id = msg.thread"
					. " ORDER BY msg.time DESC";
				$kunena_db->setQuery($query, 0, $count);
                $rows = $kunena_db->loadObjectList();
                	check_dberror("Unable to load recent messages.");

                // cycle through the returned rows displaying them in a table
                // with links to the content item
                // escaping in and out of php is now permitted
                $numitems = count($rows);

                if ($numitems > $count_per_page) {
                    include_once(KUNENA_PATH_TEMPLATE_DEFAULT .DS. "plugin/recentposts/function.tabber.php");
                    $tabs = new my_tabs(1, 1);
                    $tabs->my_pane_start('mod_kunena_last_subjects-pane');
                    $tabs->my_tab_start(1, 1);
                    }

                $i = 0;
                $tabid = 1;
                $k = 2;
                echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                echo "<tr  class = \"kunena_sth\" >";
                echo "<th class=\"th-1  " . $boardclass . "sectiontableheader  kunenas\" width=\"1%\" align=\"center\" > </th>";
                echo "<th class=\"th-2  " . $boardclass . "sectiontableheader kunenas\" align=\"left\" >" . _RECENT_TOPICS . "</th>";

                switch ($show_author)
                {
                    case '0': break;

                    case '1':
                        echo "<th class=\"th-3  " . $boardclass . "sectiontableheader kunenas\" width=\"10%\"  align=\"center\" >" . _RECENT_AUTHOR . "</th>";

                        break;

                    case '2':
                        echo "<th class=\"th-3  " . $boardclass . "sectiontableheader kunenas\" width=\"10%\" align=\"center\" >" . _RECENT_AUTHOR . "</th>";

                        break;
                }

                echo "<th class=\"th-4  " . $boardclass . "sectiontableheader kunenas\"   width=\"20%\" align=\"left\" >" . _RECENT_CATEGORIES . "</th>";

                if ($show_date) {
                    echo "<th class=\"th-5  " . $boardclass . "sectiontableheader kunenas\"  width=\"20%\" align=\"left\" >" . _RECENT_DATE . "</th>";
                    }

                if ($show_hits) {
                    echo "<th  class=\"th-6  " . $boardclass . "sectiontableheader kunenas\"  width=\"5%\" align=\"center\" >" . _RECENT_HITS . "</th></tr>";
                    }

                if ($rows) foreach ($rows as $row) {
                    $i++;
                    $overlib = "<table>";
                    //$row->subject = html_entity_decode_utf8($row->subject, ENT_QUOTES);
                    $overlib .= "<tr><td valign=top>" . _GEN_TOPIC . "</td><td>$row->subject</td></tr>";
                    $row_catname = kunena_htmlspecialchars(stripslashes($row->catname));
                    $row_username = stripslashes($row->username);
                    $row_date = JHTML::_( 'date', $row->date, '%d/%m' );
                    $row_lock = ($row->locked ? _KUNENA_LOCKED : '');
                    $overlib .= "<tr><td valign=top>" . _GEN_CATEGORY . "</td><td>$row_catname</td></tr>";
                    $overlib .= "<tr><td valign=top>" . ucfirst(_GEN_BY) . "</td><td>$row_username</td></tr>";
                    $overlib .= "<tr><td valign=top>" . _GEN_DATE . "</td><td>$row_date</td></tr>";

                    if (!$row->parent) {
                        $overlib .= "<tr><td valign=top>" . _GEN_HITS . "</td><td>$row->hits</td></tr>";
                        }

                    $overlib .= "<tr><td valign=top>" . ucfirst(_GEN_LOCK) . "</td><td>$row_lock</td></tr>";
                    $overlib .= "</table>";
                    $link = JRoute::_(KUNENA_LIVEURLREL . "&amp;func=view&amp;id=$row->kunenaid" . "&amp;catid=$row->catid#$row->kunenaid");

                    $tooltips = '';

                    if ($tooltips_enable == 1) {
                        //$title = _GEN_POSTS_DISPLAY;
                        //$tooltips = " onmouseout='return nd();'" . " onmouseover=\"return overlib('$overlib',CAPTION,'$title',BELOW,RIGHT);\"";
                        }

                    $k = 3 - $k;
                ?>

                    <tr class = "<?php echo $boardclass ;?>sectiontableentry<?php echo "$k"; ?>">
                <?php
                        echo "<td class=\"td-1\"  align=\"center\" >";
                        //echo '<img src="' . KUNENA_URLEMOTIONSPATH  . 'resultset_next.gif"  border="0"   alt=" " />';
                        echo "<img src=\"" . $topic_emoticons[$row->topic_emoticon] . "\" alt=\"emo\" />";
                        echo "</td>";
                        echo "<td class=\"td-2 kunenam\"  align=\"left\" >";
                        echo " <a class=\"kunenarecent kunenam\" href='$link' >";
                        echo substr(html_entity_decode_utf8(stripslashes($row->subject)), 0, $subject_length);
                        echo "</a>";
                        echo "</td>";

                        switch ($show_author)
                        {
                            case '0': break;

                            case '1':
                                echo "<td  class=\"td-3 kunenam\"  align=\"center\"  >";
				echo CKunenaLink::GetProfileLink($kunenaConfig, $row->id, $row->username);
                                echo "</td>";
                                break;

                            case '2':
                                echo "<td  class=\"td-3 kunenam\"  align=\"center\"  >";
				echo CKunenaLink::GetProfileLink($kunenaConfig, $row->id, $row->name);
                                echo "</td>";
                                break;
                        }

                        echo "<td class=\"td-4 kunenam\"  align=\"left\" >";
                        echo $row_catname;
                        echo "</td>";

                        if ($show_date) {
                            echo "<td  class=\"td-5 kunenam\"  align=\"left\" >";
                            if (empty($date_format)) $date_format = _KUNENA_DT_DATETIME_FMT;
                            echo JHTML::_('date', $row->date, $date_format);
                            echo "</td>";
                            }

                        if ($show_hits) {
                            echo "<td  class=\"td-6 kunenam\"  align=\"center\"  >";
                            echo $row->hits;
                            echo "</td>";
                            }

                        echo "</tr>";

                        if ($numitems > $count_per_page) {
                            if (($i % $count_per_page == 0) and ($i <> $numitems)) {
                                echo($show_order_number ? "</table>" : "</ul>");
                                $tabs->my_tab_end();
                                $tabid++;
                                $tabs->my_tab_start($tabid, $tabid);
                                $order_start = $i + 1;
                                echo(
                                    $show_order_number ? "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr  class = \"kunena_sth\" ><th width=\"1%\"  align=\"center\" class=\"th-1 " . $boardclass . "sectiontableheader kunenas\"> </th><th class=\"th-2 " . $boardclass . "sectiontableheader kunenas\"  align=\"left\" >" . _RECENT_TOPICS. "</th><th width=\"10%\"  class=\"th-3 " . $boardclass . "sectiontableheader kunenas\"   align=\"center\" >" . _RECENT_AUTHOR . "</th><th   align=\"left\"  width=\"20%\"  class=\"th-4 " . $boardclass . "sectiontableheader kunenas\">" . _RECENT_CATEGORIES . "</th><th class=\"th-5 " . $boardclass . "sectiontableheader kunenas\" width=\"20%\"  align=\"left\"  >" . _RECENT_DATE . "</th><th  class=\"th-6 " . $boardclass . "sectiontableheader kunenas\" width=\"5%\"   align=\"center\" >" . _RECENT_HITS . "</th></tr>" : "<ul>");
                                }
                            }
                    }

                echo($show_order_number ? "</table>" : "</ul>");

                if ($numitems > $count_per_page) {
                    $tabs->my_tab_end();
                    $tabs->my_pane_end();
                    }
                ?>
            </td>
        </tr>
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>