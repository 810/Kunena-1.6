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

$id = JRequest::getInt('id', 0);
if (!$id) $id = JRequest::getInt('msg_id');
$catid = JRequest::getInt('catid', 0);
$reporter = JRequest::getInt('reporter', 0);
$reason = strval(JRequest::getVar('reason'));
$text = strval(JRequest::getVar('text'));
$type = JRequest::getInt('type', 0); // 0 = send e-mail, 1 = send pm

switch ($do)
{
    case 'report':
        ReportMessage($id, $catid, $reporter, $reason, $text, (int)$type);

        break;

    default:
        ReportForm($id, $catid);

        break;
}

function ReportMessage($id, $catid, $reporter, $reason, $text, $type)
{
    $kunena_my = &JFactory::getUser();
    $kunena_db = &JFactory::getDBO();
    $kunenaConfig =& CKunenaConfig::getInstance();

    if (!$kunena_my->id) {
        JError::raiseError( 403, JText::_("ALERTNOTAUTH") );;
        return;
        }

	if (!empty($reason) && !empty($text))
	{

    $kunena_db->setQuery("SELECT a.*, a.message AS msg_text FROM #__kunena_messages AS a"
    . " WHERE a.id='{$id}'");

    $row = $kunena_db->loadObject();

    $kunena_db->setQuery("SELECT username FROM #__users WHERE id={$row->userid}");
    $baduser = $kunena_db->loadResult();

    $kunena_db->setQuery("SELECT username FROM #__users WHERE id={$reporter}");
    $sender = $kunena_db->loadResult();

    if ($reason) {
        $subject = "[".stripslashes($kunenaConfig->board_title)." "._GEN_FORUM."] "._KUNENA_REPORT_MSG . ": " . $reason;
        }
    else {
        $subject = "[".stripslashes($kunenaConfig->board_title)." "._GEN_FORUM."] "._KUNENA_REPORT_MSG . ": " . stripslashes($row->subject);
        }

	jimport('joomla.environment.uri');
	$uri =& JURI::getInstance(JURI::base());
	$msglink = $uri->toString(array('scheme', 'host', 'port')) . str_replace('&amp;', '&', JRoute::_(KUNENA_LIVEURLREL . "&amp;func=view&amp;catid=" . $row->catid . "&amp;id=" . $row->id) . '#' . $row->id);

    $message  = "" . _KUNENA_REPORT_RSENDER . " " . $sender;
    $message .= "\n";
    $message .= "" . _KUNENA_REPORT_RREASON . " " . $reason;
    $message .= "\n";
    $message .= "" . _KUNENA_REPORT_RMESSAGE . " " . $text;
    $message .= "\n\n";
    $message .= "" . _KUNENA_REPORT_POST_POSTER . " " . $baduser;
    $message .= "\n";
    $message .= "" . _KUNENA_REPORT_POST_SUBJECT . " " . stripslashes($row->subject);
    $message .= "\n";
    $message .= "" . _KUNENA_REPORT_POST_MESSAGE . "\n-----\n" . stripslashes($row->msg_text);
    $message .= "\n-----\n\n";
    $message .= "" . _KUNENA_REPORT_POST_LINK . " " . $msglink;
    $message .= "\n\n\n\n** Powered by Kunena! - http://www.Kunena.com **";
    $message = strtr($message, array('&#32;'=>''));

    //get category moderators
    $kunena_db->setQuery("SELECT userid FROM #__kunena_moderation WHERE catid={$row->catid}");
    $mods = $kunena_db->loadObjectList();
    	check_dberror("Unable to load moderators.");

    //get admins
    $kunena_db->setQuery("SELECT id FROM #__users WHERE gid >= 24");
    $admins = $kunena_db->loadObjectList();
    	check_dberror("Unable to load admin.");

    switch ($type)
    {
        default:
        case '0':
            SendReporttoMail($sender, $subject, $message, $msglink, $mods, $admins);

            break;

        case '1':
            SendReporttoPM($reporter, $subject, $message, $msglink, $mods, $admins);

            break;
    }

    echo '<div align="center">' . _KUNENA_REPORT_SUCCESS;
    echo CKunenaLink::GetAutoRedirectHTML(JRoute::_(KUNENA_LIVEURLREL.'&amp;func=view&amp;catid='.$catid.'&amp;id='.$id).'#'.$id, 3500);

	}
    else
    {
    	echo '<div align="center">';
    	if (empty($reason)) echo _POST_FORGOT_SUBJECT;
    	else if (empty($text)) echo _POST_FORGOT_MESSAGE;

    }
    echo '<br /><br />';
    echo '<a href="' . JRoute::_(KUNENA_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
    echo '<a href="' . JRoute::_(KUNENA_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
    echo '</div>';
}

function SendReporttoMail($sender, $subject, $message, $msglink, $mods, $admins) {
    $kunenaConfig =& CKunenaConfig::getInstance();
    $kunena_db =& JFactory::getDBO();

    //send report to category moderators
    if (count($mods)>0) {
        foreach ($mods as $mod) {
            $kunena_db->setQuery("SELECT email FROM #__users WHERE id={$mod->userid}");
            $email = $kunena_db->loadResult();

            JUtility::sendMail($kunenaConfig->email, $kunenaConfig->board_title, $email, $subject, $message);
            }
    }

    //send report to site admins
    foreach ($admins as $admin) {
        $kunena_db->setQuery("SELECT email FROM #__users WHERE id={$admin->id}");
        $email = $kunena_db->loadResult();
        JUtility::sendMail($kunenaConfig->email, stripslashes($kunenaConfig->board_title)." ".trim(_GEN_FORUM), $email, $subject, $message);
        }
    }

function SendReporttoPM($sender, $subject, $message, $msglink, $mods, $admins) {
    $kunenaConfig =& CKunenaConfig::getInstance();

    $kunena_db = &JFactory::getDBO();

    switch ($kunenaConfig->pm_component)
    {
        case 'no': break;

        //myPMS II Open Source
        case 'pms':
            SendPMS();

            break;

        //uddeIM
        case 'uddeim':
            SendUddeIM();

            break;

        //JIM
        case 'jim':
            SendJIM();

            break;

        case 'missus':
            SendMissus();

            break;
    }
    }

function ReportForm($id, $catid) {
    $app =& JFactory::getApplication();
    $kunenaConfig =& CKunenaConfig::getInstance();
    $kunena_my = &JFactory::getUser();

    $redirect = JRoute::_(KUNENA_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id;

    //$redirect = JRoute::_($redirect);
    if (!$kunena_my->id) {
        $app->redirect($redirect);
        return;
        }

    if ($kunenaConfig->reportmsg == 0) {
        $app->redirect($redirect);
        return;
        }
?>

<div class = "<?php echo $boardclass; ?>_bt_cvr1">
    <div class = "<?php echo $boardclass; ?>_bt_cvr2">
        <div class = "<?php echo $boardclass; ?>_bt_cvr3">
            <div class = "<?php echo $boardclass; ?>_bt_cvr4">
                <div class = "<?php echo $boardclass; ?>_bt_cvr5">
                    <table class = "kunena_blocktable" id = "kunena_forumfaq" border = "0" cellspacing = "0" cellpadding = "0" width = "100%">
                        <thead>
                            <tr>
                                <th>
                                    <div class = "kunena_title_cover">
                                        <span class = "kunena_title"><?php echo _KUNENA_COM_A_REPORT ?></span>
                                    </div>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class = "kunena_faqdesc">
                                    <form method = "post" action = "<?php echo JRoute::_(KUNENA_LIVEURLREL.'&amp;func=report'); ?>">
                                        <table width = "100%" border = "0">
                                            <tr>
                                                <td width = "10%">
<?php echo _KUNENA_REPORT_REASON ?>:
                                                </td>

                                                <td>
                                                    <input type = "text" name = "reason" class = "inputbox" size = "30"/>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan = "2">
<?php echo _KUNENA_REPORT_MESSAGE ?>:
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan = "2">
                                                    <textarea id = "text" name = "text" cols = "40" rows = "10" class = "inputbox"></textarea>
                                                </td>
                                            </tr>
                                        </table>

                                        <input type = "hidden" name = "do" value = "report"/>
                                        <input type = "hidden" name = "id" value = "<?php echo $id;?>"/>
                                        <input type = "hidden" name = "catid" value = "<?php echo $catid;?>"/>
                                        <input type = "hidden" name = "reporter" value = "<?php echo $kunena_my->id;?>"/>
                                        <input type = "submit" name = "Submit" value = "<?php echo _KUNENA_REPORT_SEND ?>"/>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }

?>