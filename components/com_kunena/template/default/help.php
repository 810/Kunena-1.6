<?php
/**
* @version $Id$
* Kunena Component
* @package Kunena
*
* @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
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
defined( '_JEXEC' ) or die();


$kunena_db = &JFactory::getDBO();
$kunena_config =& CKunenaConfig::getInstance();
$document=& JFactory::getDocument();

$document->setTitle(_GEN_HELP . ' - ' . stripslashes($kunena_config->board_title));

?>
<div class="k_bt_cvr1">
<div class="k_bt_cvr2">
<div class="k_bt_cvr3">
<div class="k_bt_cvr4">
<div class="k_bt_cvr5">
<table class = "kblocktable" id ="kforumhelp" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
            <thead>
                <tr>
                    <th>
                        <div class = "ktitle_cover km">
                        <span class="ktitle kl" ><?php echo _COM_FORUM_HELP; ?></span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
            <tr>
            <td class="khelpdesc" valign="top">

        <?php
          $kunena_db->setQuery("SELECT introtext, id FROM #__content WHERE id='{$kunena_config->help_cid}'");
		  $j_introtext = $kunena_db->loadResult();

           ?>
            <?php echo $j_introtext; ?>


         </td>
         </tr>
         </tbody>
         </table>
</div>
</div>
</div>
</div>
</div>
                     <!-- Begin: Forum Jump -->
<div class="k_bt_cvr1">
<div class="k_bt_cvr2">
<div class="k_bt_cvr3">
<div class="k_bt_cvr4">
<div class="k_bt_cvr5">
<table class = "kblocktable" id="kbottomarea"  border="0" cellspacing="0" cellpadding="0" width="100%">
  <thead>
    <tr>
       <th class="th-right">
       <?php
//(JJ) FINISH: CAT LIST BOTTOM
if ($kunena_config->enableforumjump)
require_once (KUNENA_PATH_LIB .DS. 'kunena.forumjump.php');
?></th>
    </tr>
  </thead>
  <tbody><tr><td></td></tr></tbody>
  </table>
  </div>
</div>
</div>
</div>
</div>
  <!-- Finish: Forum Jump -->