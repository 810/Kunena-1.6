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

defined ( '_JEXEC' ) or die ( 'Restricted access' );

$catid = JRequest::getInt ( 'catid', 0 );
$id = JRequest::getInt ( 'id', 0 );

$kunena_db = &JFactory::getDBO ();
$kunena_config = & CKunenaConfig::getInstance ();
$kunena_my = &JFactory::getUser ();

//Some initial thingies needed anyway:
if (! isset ( $this->kunena_set_focus ))
	$this->kunena_set_focus = 0;
$authorName = stripslashes ( $this->authorName );

CKunenaPolls::call_javascript_form();

include_once (KUNENA_PATH_LIB . DS . 'kunena.bbcode.js.php');

//keep session alive while editing
JHTML::_ ( 'behavior.keepalive' );
?>

<form class="postform"
	action="<?php
	echo JRoute::_ ( KUNENA_LIVEURLREL . '&amp;func=post' );
	?>"
	method="post" name="postform" enctype="multipart/form-data"><input
	type="hidden" name="catid" value="<?php
	echo $this->catid;
	?>" />
<?php
if (! empty ( $this->kunena_editmode )) :
	?>
<input type="hidden" name="do" value="editpostnow" /> <input
	type="hidden" name="id" value="<?php
	echo $this->id;
	?>" />
<?php else: ?>
<input type="hidden" name="action" value="post" /> <input type="hidden"
	name="parentid" value="<?php
	echo $this->parentid;
	?>" />
<?php endif; ?>
	<input type="hidden"
	value="<?php
	echo JURI::base ( true ) . '/components/com_kunena/template/default';
	?>"
	name="templatePath" /> <input type="hidden"
	value="<?php
	echo JURI::base ( true );
	?>/" name="kunenaPath" />
<?php if (! empty ( $this->contentURL )) :?>
<input type="hidden" name="contentURL" value="<?php echo $this->contentURL; ?>" />
<?php endif; ?>

<div class="<?php
echo KUNENA_BOARD_CLASS;
?>_bt_cvr1">
<div class="<?php
echo KUNENA_BOARD_CLASS;
?>_bt_cvr2">
<div class="<?php
echo KUNENA_BOARD_CLASS;
?>_bt_cvr3">
<div class="<?php
echo KUNENA_BOARD_CLASS;
?>_bt_cvr4">
<div class="<?php
echo KUNENA_BOARD_CLASS;
?>_bt_cvr5">
<table class="fb_blocktable<?php
echo isset ( $msg_cat->class_sfx ) ? ' fb_blocktable' . $msg_cat->class_sfx : '';
?>"
	id="fb_postmessage" border="0" cellspacing="0" cellpadding="0"
	width="100%">
	<thead>
		<tr>
			<th colspan="2">
			<div class="fb_title_cover fbm"><span class="fb_title fbl">
			<?php
			echo _POST_MESSAGE;
			?>"<?php
			echo kunena_htmlspecialchars ( stripslashes ( $msg_cat->catname ) );
			?>"</span></div>
			</th>
		</tr>
	</thead>

	<tbody id="fb_post_message">
		<tr class="<?php
		echo KUNENA_BOARD_CLASS;
		?>sectiontableentry1">
			<td class="fb_leftcolumn"><strong><?php
			echo _GEN_NAME;
			?></strong>:</td>

			<?php
			if (($kunena_config->regonly == "1" || $kunena_config->changename == '0') && $kunena_my->id != "" && ! CKunenaTools::isModerator ( $kunena_my->id, $this->catid )) {
				?>
			<td><input type="hidden" name="authorname" size="35"
				class="<?php
				echo KUNENA_BOARD_CLASS;
				?>inputbox postinput"
				maxlength="35" value="<?php
				echo $this->authorName;
				?>"><b><?php
				echo $this->authorName;
				?></b></td>
			<?php
			} else {
				if ($this->kunena_registered_user == 1) {
					echo "<td><input type=\"text\" name=\"authorname\" size=\"35\"  class=\"" . KUNENA_BOARD_CLASS . "inputbox postinput\"  maxlength=\"35\" value=\"$authorName\" /></td>";
				} else {
					echo "<td><input type=\"text\" name=\"authorname\" size=\"35\"  class=\"" . KUNENA_BOARD_CLASS . "inputbox postinput\"  maxlength=\"35\" value=\"\" />";
					echo "<script type=\"text/javascript\">document.postform.authorname.focus();</script></td>";
					$this->kunena_set_focus = 1;
				}
			}
			?>
		</tr>

		<?php
		if (($kunena_config->askemail && !$kunena_my->id) || $kunena_config->changename == 1 || CKunenaTools::isModerator ( $kunena_my->id, $this->catid )) {
			echo '<tr class = "' . KUNENA_BOARD_CLASS . 'sectiontableentry2"><td class = "fb_leftcolumn"><strong>' . _GEN_EMAIL . ' *</strong>:</td>';
			echo "<td><input type=\"text\" name=\"email\"  size=\"35\" class=\"" . KUNENA_BOARD_CLASS . "inputbox postinput\" maxlength=\"35\" value=\"$this->email\" /></td>";
			echo '</tr>';
		}
		?>

		<tr class="<?php
		echo KUNENA_BOARD_CLASS;
		?>sectiontableentry1">
			<?php
			if (! $this->kunena_from_bot) {
				?>

			<td class="fb_leftcolumn"><strong><?php
				echo _GEN_SUBJECT;
				?></strong>:</td>

			<td><input type="text"
				class="<?php
				echo KUNENA_BOARD_CLASS;
				?>inputbox postinput"
				name="subject" size="35"
				maxlength="<?php
				echo $kunena_config->maxsubject;
				?>"
				value="<?php
				echo $this->resubject;
				?>" /></td>

			<?php
			} else {
				?>

			<td class="fb_leftcolumn"><strong><?php
				echo _GEN_SUBJECT;
				?></strong>:</td>

			<td><input type="hidden" class="inputbox" name="subject" size="35"
				maxlength="<?php
				echo $kunena_config->maxsubject;
				?>"
				value="<?php
				echo $this->resubject;
				?>" /><?php
				echo $this->resubject;
				?>
			</td>

			<?php
			}
			?>

			<?php
			if ($this->kunena_set_focus == 0 && $this->id == 0 && ! $this->kunena_from_bot) {
				echo "<script type=\"text/javascript\">document.postform.subject.focus();</script>";
				$this->kunena_set_focus = 1;
			}
			?>
		</tr>

		<?php
		if ($this->parentid == 0) {
			?>
		<tr class="<?php
			echo KUNENA_BOARD_CLASS;
			?>sectiontableentry2">
			<td class="fb_leftcolumn"><strong><?php
			echo _GEN_TOPIC_ICON;
			?></strong>:</td>

			<td class="fb-topicicons"><?php
			$topicToolbar = smile::topicToolbar ( 0, $kunena_config->rtewidth );
			echo $topicToolbar;
			?>
			</td>
		</tr>
		<?php
		}
		?>

		<?php
		if ($kunena_config->rtewidth == 0) {
			$useRte = 0;
		} else {
			$useRte = 1;
		}

		$fbTextArea = smile::fbWriteTextarea ( 'message', $this->message_text, $kunena_config->rtewidth, $kunena_config->rteheight, $useRte, $kunena_config->disemoticons, $this->kunena_editmode );
		echo $fbTextArea;

		if ($this->kunena_set_focus == 0) {
			echo '<tr><td style="display:none;"><script type="text/javascript">document.postform.message.focus();</script></td></tr>';
		}

		//check if this user is already subscribed to this topic but only if subscriptions are allowed
		if ($kunena_config->allowsubscriptions == 1) {
			if ($this->id == 0) {
				$fb_thread = - 1;
			} else {
				$kunena_db->setQuery ( "SELECT thread FROM #__fb_messages WHERE id='{$this->id}'" );
				$fb_thread = $kunena_db->loadResult ();
			}

			$kunena_db->setQuery ( "SELECT thread FROM #__fb_subscriptions WHERE userid='{$kunena_my->id}' AND thread='{$fb_thread}'" );
			$fb_subscribed = $kunena_db->loadResult ();

			if ($fb_subscribed == "" || $this->id == 0) {
				$fb_cansubscribe = 1;
			} else {
				$fb_cansubscribe = 0;
			}
		}
		?>

		<?php
		if (($kunena_config->allowimageupload || ($kunena_config->allowimageregupload && $kunena_my->id != 0) || CKunenaTools::isModerator ( $kunena_my->id, $this->catid ))) {
			?>

		<tr class="<?php
			echo KUNENA_BOARD_CLASS;
			?>sectiontableentry1">
			<td class="fb_leftcolumn"><strong><?php
			echo _IMAGE_SELECT_FILE;
			?></strong></td>

			<td><input type='file' class='fb_button' name='attachimage'
				onmouseover="javascript:kunenaShowHelp('<?php
			@print (addslashes(_IMAGE_DIMENSIONS)) . ": " . $kunena_config->imagewidth . "x" . $kunena_config->imageheight . " - " . $kunena_config->imagesize . " KB";
			?>')" /> <input type="button" class="fb_button" name="addImagePH"
				value="<?php
			@print (addslashes(_POST_ATTACH_IMAGE)) ;
			?>"
				style="cursor: auto; width: 4em"
				onclick="bbfontstyle(' [img/] ','');"
				onmouseover="javascript:kunenaShowHelp('<?php
			@print (addslashes(_KUNENA_EDITOR_HELPLINE_IMGPH)) ;
			?>')" /></td>
		</tr>

		<?php
		}
		?>

		<?php
		if (($kunena_config->allowfileupload || ($kunena_config->allowfileregupload && $kunena_my->id != 0) || CKunenaTools::isModerator ( $kunena_my->id, $this->catid ))) {
			?>

		<tr class="<?php
			echo KUNENA_BOARD_CLASS;
			?>sectiontableentry2">
			<td class="fb_leftcolumn"><strong><?php
			echo _FILE_SELECT_FILE;
			?></strong></td>

			<td><input type='file' class='fb_button' name='attachfile'
				onmouseover="javascript:kunenaShowHelp('<?php
			@print (addslashes(_FILE_TYPES)) . ": " . $kunena_config->filetypes . " - " . $kunena_config->filesize . " KB";
			?>')"
				style="cursor: auto" /> <input type="button" class="fb_button"
				name="addFilePH" value="<?php
			@print (_POST_ATTACH_FILE) ;
			?>"
				style="cursor: auto; width: 4em"
				onclick="bbfontstyle(' [file/] ','');"
				onmouseover="javascript:kunenaShowHelp('<?php
			@print (addslashes(_KUNENA_EDITOR_HELPLINE_FILEPH)) ;
			?>')" /></td>
		</tr>

		<?php
		}

		if ($kunena_my->id != 0 && $kunena_config->allowsubscriptions == 1 && $fb_cansubscribe == 1 && ! $this->kunena_editmode) {
			?>

		<tr class="<?php
			echo KUNENA_BOARD_CLASS;
			?>sectiontableentry1">
			<td class="fb_leftcolumn"><strong><?php
			echo _POST_SUBSCRIBE;
			?></strong>:</td>

			<td><?php
			if ($kunena_config->subscriptionschecked == 1) {
				?>

			<input type="checkbox" name="subscribeMe" value="1" checked /> <i><?php
				echo _POST_NOTIFIED;
				?></i>

			<?php
			} else {
				?> <input type="checkbox" name="subscribeMe" value="1" /> <i><?php
				echo _POST_NOTIFIED;
				?></i> <?php
			}
			?></td>
		</tr>

		<?php
		}
        $catsallowed = explode(',',$kunena_config->pollallowedcategories);
        if (in_array($catid, $catsallowed))
        {
        	//Check if it's is a new thread and show the poll
         	if ($kunena_config->pollenabled == "1" && $id == "0" )
         	{
         		if (!isset($polldatasedit[0]->polltimetolive)) {
					$polldatasedit[0]->polltimetolive = '0000-00-00 00:00:00';
				}
        		$pollcalendar = JHTML::_('calendar', $polldatasedit[0]->polltimetolive, 'poll_time_to_live', 'poll_time_to_live');
         ?>
            <tr class = "<?php echo KUNENA_BOARD_CLASS; ?>sectiontableentry2">
                <td class = "fb_leftcolumn">
                    <strong><?php echo _KUNENA_POLL_ADD; ?></strong>
                </td>
                <td>
                	<div style="font-weight:bold;" id="poll_text_write"></div>
                    <div><input type = "text" id = "poll_title" name = "poll_title" value="<?php if(isset($polldatasedit[0]->title)) { echo $polldatasedit[0]->title; } ?>" /><?php echo ' '. _KUNENA_POLL_TITLE; ?></div>
                    <div><?php echo $pollcalendar . ' '. _KUNENA_POLL_TIME_TO_LIVE; ?></div>

                    <!-- The field hidden allow to know the options number chooses by the user -->
                    <?php if($this->kunena_editmode != "1"){ ?>
                    <input type="hidden" name="number_total_options" id="numbertotal">
                    <?php } ?>
                    <input type = "button" class = "fb_button" value = "<?php echo _KUNENA_POLL_ADD_OPTION; ?>" onclick = "javascript:new_field(<?php echo $kunena_config->pollnboptions; ?>);">
                    <input type = "button" class = "fb_button" value = "<?php echo _KUNENA_POLL_REM_OPTION; ?>" onclick = "javascript:delete_field();">
                </td>
            </tr>
           <?php }
        }
		// Begin captcha . Thanks Adeptus
		if ($kunena_config->captcha == 1 && $kunena_my->id < 1) {
			?>
		<tr class="<?php
			echo KUNENA_BOARD_CLASS;
			?>sectiontableentry1">
			<td class="fb_leftcolumn">&nbsp;<strong><?php
			echo _KUNENA_CAPDESC;
			?></strong>&nbsp;</td>
			<td align="left" valign="middle" height="35px">&nbsp;<input
				name="txtNumber" type="text" id="txtNumber" value=""
				class="fb_button" style="vertical-align: top" size="15"> <img
				src="?option=com_kunena&func=showcaptcha" alt="" /></td>
		</tr>
		<?php
		}
		// Finish captcha
		if (($this->kunena_editmode == "1") && $kunena_config->pollenabled == "1")
		{
		    $catsallowed = explode(',',$kunena_config->pollallowedcategories);
        	if (in_array($catid, $catsallowed))
        	{
		      //This query is need because, in this part i haven't access to the variable $parent
		      //I need to determine if the post if a parent or not for display the form for the poll
          	  $mesparent 	= CKunenaPolls::get_parent($id);
              $polloptions  = CKunenaPolls::get_total_options($id);
          	  if ($mesparent->parent == "0"){
          	  	if (!isset($polldatasedit[0]->polltimetolive)) {
					$polldatasedit[0]->polltimetolive = '0000-00-00 00:00:00';
			 	}
        		$pollcalendar = JHTML::_('calendar', $polldatasedit[0]->polltimetolive, 'poll_time_to_live', 'poll_time_to_live');
          	  	$polloptionsstart = $polloptions+1;
            	JApplication::addCustomHeadTag('
      				<script type="text/javascript">
	   				<!--
	   				var number_field = "'.$polloptionsstart.'";
	   				//-->
    				 </script>
				  ');
		?>
		<tr class = "<?php echo KUNENA_BOARD_CLASS; ?>sectiontableentry2">
			<td class = "fb_leftcolumn">
                    <strong><?php echo _KUNENA_POLL_ADD; ?></strong>
            </td>
            <td>
                	<div style="font-weight:bold;" id="poll_text_write"></div>
                    <div><input type = "text" id = "poll_title" name = "poll_title" value="<?php if(isset($polldatasedit[0]->title)) { echo $polldatasedit[0]->title; } ?>" /><?php echo ' '. _KUNENA_POLL_TITLE; ?></div>
                    <div><?php echo $pollcalendar . ' '. _KUNENA_POLL_TIME_TO_LIVE; ?></div>
                    <input type = "button" class = "fb_button" value = "<?php echo _KUNENA_POLL_ADD_OPTION; ?>" onclick = "javascript:new_field(<?php echo $kunena_config->pollnboptions; ?>);">
                    <input type = "button" class = "fb_button" value = "<?php echo _KUNENA_POLL_REM_OPTION; ?>" onclick = "javascript:delete_field();">
                    <input type="hidden" name="number_total_options" id="numbertotalr" value="<?php echo $polloptions; ?>">
            </td>
        </tr>
                <?php
                  if (isset($polloptions)) {
                  	$nboptions = "1";
                    for ($i=0;$i < $polloptions;$i++) {
                    	echo "<tr class=\"".KUNENA_BOARD_CLASS."sectiontableentry2\" id=\"option".$nboptions."\"><td style=\"font-weight: bold\" class=\"fb_leftcolumn\">Option ".$nboptions."</td><td><input type=\"text\" id=\"field_option".$i."\" name=\"field_option".$i."\" value=\"".$polldatasedit[$i]->text."\" /></td></tr>";
                      	$nboptions++;
                    }
                  }
          	  }
        	}
		}
		?>
		<tr id="fb_post_buttons_tr" class="<?php
		echo KUNENA_BOARD_CLASS;
		?>sectiontableentry1">
			<td id="fb_post_buttons" colspan="2" style="text-align: center;"><input
				type="submit" name="submit" class="fb_button"
				value="<?php
				@print (' ' . _GEN_CONTINUE . ' ') ;
				?>"
				onclick="return submitForm()"
				onmouseover="javascript:jQuery('input[name=helpbox]').val('<?php
				@print (_KUNENA_EDITOR_HELPLINE_SUBMIT) ;
				?>')" /> <input type="button" name="preview" class="fb_button"
				value="<?php
				@print (' ' . _PREVIEW . ' ') ;
				?>"
				onclick="fbGetPreview(document.postform.message.value,<?php
				echo KUNENA_COMPONENT_ITEMID?>);"
				onmouseover="javascript:jQuery('input[name=helpbox]').val('<?php
				@print (_KUNENA_EDITOR_HELPLINE_PREVIEW) ;
				?>')" /> <input type="button" name="cancel" class="fb_button"
				value="<?php
				@print (' ' . _GEN_CANCEL . ' ') ;
				?>"
				onclick="javascript:window.history.back();"
				onmouseover="javascript:jQuery('input[name=helpbox]').val('<?php
				@print (_KUNENA_EDITOR_HELPLINE_CANCEL) ;
				?>')" /></td>
		</tr>

		<!-- preview -->
		<tr class="<?php
		echo KUNENA_BOARD_CLASS;
		?>sectiontableentry2"
			id="previewContainer" style="display: none;">
			<td class="fb_leftcolumn"><strong><?php
			echo _PREVIEW;
			?></strong>:</td>
			<td>
			<div class="previewMsg" id="previewMsg"
				style="height: <?php
				echo $kunena_config->rteheight;
				?>px; overflow: auto;"></div>
			</td>
		</tr>
		<!-- /preview -->

		<tr class="<?php
		echo KUNENA_BOARD_CLASS;
		?>sectiontableentry1">
			<td colspan="2"><?php
			if ($kunena_config->askemail) {
				echo $kunena_config->showemail == '0' ? "<em>* - " . _POST_EMAIL_NEVER . "</em>" : "<em>* - " . _POST_EMAIL_REGISTERED . "</em>";
			}
			?>
	</td>
		</tr>

		<tr>
			<td colspan="2"><br />

	<?php
	$no_upload = "0"; //reset the value.. you just never know..


	if ($kunena_config->showhistory == 1) {
		listThreadHistory ( $this->id, $kunena_config, $kunena_db );
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
</form>