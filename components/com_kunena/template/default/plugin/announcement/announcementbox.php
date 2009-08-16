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

$kunenaConfig =& CKunenaConfig::getInstance();

# Check for Editor rights  $kunenaConfig->annmodid
$user_fields = @explode(',', $kunenaConfig->annmodid);

if (in_array($kunena_my->id, $user_fields) || $kunena_my->usertype == 'Administrator' || $kunena_my->usertype == 'Super Administrator') {
    $is_editor = true;
    }
else {
    $is_editor = false;
    }

$is_user = (strtolower($kunena_my->usertype) <> '');
?>

<?php
// BEGIN: BOX ANN
$kunena_db->setQuery("SELECT id, title, sdescription, description, created, published, showdate FROM #__kunena_announcement WHERE published='1' ORDER BY created DESC", 0, 1);

$anns = $kunena_db->loadObjectList();
check_dberror("Unable to load announcements.");
if (count($anns) == 0) return;
$ann = $anns[0];
$annID = $ann->id;
$anntitle = stripslashes($ann->title);

$smileyList = smile::getEmoticons(0);
$annsdescription = stripslashes(smile::smileReplace($ann->sdescription, 0, $kunenaConfig->disemoticons, $smileyList));
$annsdescription = nl2br($annsdescription);
$annsdescription = smile::htmlwrap($annsdescription, $kunenaConfig->wrap);

$anndescription = stripslashes(smile::smileReplace($ann->description, 0, $kunenaConfig->disemoticons, $smileyList));
$anndescription = nl2br($anndescription);
$anndescription = smile::htmlwrap($anndescription, $kunenaConfig->wrap);

$anncreated = KUNENA_timeformat(strtotime($ann->created));
$annpublished = $ann->published;
$annshowdate = $ann->showdate;

if ($annID > 0) {
?>
    <!-- ANNOUNCEMENTS BOX -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
    <table class = "kunena_blocktable" id = "kunena_announcement" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
        <thead>
            <tr>
                <th align="left">
                    <div class = "kunena_title_cover kunenam">
                        <span class = "kunena_title kunenal"><?php echo $anntitle; ?></span>
                    </div>

                    <img id = "BoxSwitch_announcements__announcements_tbody" class = "hideshow" src = "<?php echo KUNENA_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                </th>
            </tr>
        </thead>

        <tbody id = "announcements_tbody">
            <?php
            if ($is_editor) {
            ?>

                    <tr class = "kunena_sth">
                        <th class = "th-1 <?php echo $boardclass ;?>sectiontableheader kunenam" align="left">
                            <a href = "<?php echo CKunenaLink::GetAnnouncementURL($kunenaConfig, 'edit', $annID); ?>"><?php echo _ANN_EDIT; ?> </a> |
                        <a href = "<?php echo CKunenaLink::GetAnnouncementURL($kunenaConfig, 'delete', $annID); ?>"><?php echo _ANN_DELETE; ?> </a> | <a href = "<?php echo CKunenaLink::GetAnnouncementURL($kunenaConfig, 'add');?>"><?php echo _ANN_ADD; ?> </a> | <a href = "<?php echo CKunenaLink::GetAnnouncementURL($kunenaConfig, 'show');?>"><?php echo _ANN_CPANEL; ?> </a>
                        </th>
                    </tr>

            <?php
                }
            ?>

                <tr class = "<?php echo $boardclass ;?>sectiontableentry2">
                    <td class = "td-1 kunenam" align="left">
                        <?php
                        if ($annshowdate > 0) {
                        ?>

                            <div class = "anncreated">
<?php echo $anncreated; ?>
                            </div>

                        <?php
                            }
                        ?>

                        <div class = "anndesc">
<?php echo $annsdescription; ?>

<?php
if (!empty($anndescription)) {
?>

    &nbsp;&nbsp;&nbsp;<a href = "<?php echo CKunenaLink::GetAnnouncementURL($kunenaConfig, 'read', $annID);?>"> <?php echo _ANN_READMORE; ?></a>

<?php
    }
?>
                        </div>
                    </td>
                </tr>
        </tbody>
    </table>
    </div>
</div>
</div>
</div>
</div>
    <!-- / ANNOUNCEMENTS BOX -->

<?php
    }
// FINISH: BOX ANN
?>