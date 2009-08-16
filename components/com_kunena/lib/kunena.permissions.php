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

/**
 * Checks if a user has postpermission in given thread
 * @param database object
 * @param int
 * @param int
 * @param int
 * @param boolean
 * @param boolean
 *
 * @pre: kunena_has_read_permission()
 */
function kunena_has_post_permission(&$kunena_db,$catid,$replyto,$userid,$pubwrite,$ismod) {
    $kunenaConfig =& CKunenaConfig::getInstance();
    if ($ismod)
        return 1; // moderators always have post permission
    if($replyto != 0) {
        $kunena_db->setQuery("SELECT thread FROM #__kunena_messages WHERE id='{$replyto}'");
        $topicID=$kunena_db->loadResult();
        if ($topicID != 0) //message replied to is not the topic post; check if the topic post itself is locked
            $sql="SELECT locked FROM #__kunena_messages WHERE id='{$topicID}'";
        else
            $sql="SELECT locked FROM #__kunena_messages WHERE id='{$replyto}'";
        $kunena_db->setQuery($sql);
        if ($kunena_db->loadResult()==1)
        return -1; // topic locked
    }

    //topic not locked; check if forum is locked
    $kunena_db->setQuery("SELECT locked FROM #__kunena_categories WHERE id='{$catid}'");
    if ($kunena_db->loadResult()==1)
        return -2; // forum locked

    if ($userid != 0|| $pubwrite)
        return 1; // post permission :-)
    return 0; // no public writing allowed
}
/**
 * Checks if user is a moderator in given forum
 * @param dbo
 * @param int
 * @param int
 * @param bool
 */

function kunena_has_moderator_permission(&$kunena_db,&$obj_kunena_cat,$int_kunena_uid,$bool_kunena_isadmin) {
    if ($int_kunena_uid == 0)
	return 0; // Anonymous never has moderator permission
    if ($bool_kunena_isadmin)
        return 1;
    if (is_object($obj_kunena_cat) && $obj_kunena_cat->getModerated()) {
        $kunena_db->setQuery("SELECT userid FROM #__kunena_moderation WHERE catid='".$obj_kunena_cat->getId()."' AND userid='{$int_kunena_uid}'");
        
        if ($kunena_db->loadResult()!='')
            return 1;
     }
// Check if we have forum wide moderators - not limited to particular categories 
    $kunena_db->setQuery("SELECT moderator FROM #__kunena_users WHERE userid='{$int_kunena_uid}'");
    if ($kunena_db->loadResult()==1) // moderator YES
    {
        $kunena_db->setQuery("SELECT userid FROM #__kunena_moderation WHERE userid='{$int_kunena_uid}'");
        if ($kunena_db->loadResult()=='') // not limited to a specific category - as we checked for those above
        {
            return 1;
        }
    }         
    return 0;
}


/**
 * Checks if user has read permission in given forum
 * @param object
 * @param array
 * @param int
 * @param obj
 */
function kunena_has_read_permission(&$obj_kunenacat,&$allow_forum,$groupid,&$kunena_acl) {
    $kunena_acl = &JFactory::getACL();
    if ($obj_kunenacat->getPubRecurse())
        $pub_recurse="RECURSE";
    else
        $pub_recurse="NO_RECURSE";

    if ($obj_kunenacat->getAdminRecurse())
        $admin_recurse="RECURSE";
    else
        $admin_recurse="NO_RECURSE";
      if ($obj_kunenacat->getPubAccess() == 0 || ($obj_kunenacat->getPubAccess() == -1 && $groupid > 0) || (sizeof($allow_forum)> 0 && in_array($obj_kunenacat->getId(),$allow_forum))) {
      //this is a public forum; let 'Everybody' pass
      //or this forum is for all registered users and this is a registered user
      //or this forum->id is already in the cookie with allowed forums
         return 1;
      }
      else {
          //access restrictions apply; need to check

        if( $groupid == $obj_kunenacat->getPubAccess()) {
            //the user has the same groupid as the access level requires; let pass
            return 1;
        }
        else {
            if ($pub_recurse=='RECURSE') {
                //check if there are child groups for the Access Level
                $group_childs=array();
                $group_childs=$kunena_acl->get_group_children( $obj_kunenacat->getPubAccess(), 'ARO', $pub_recurse );

                if ( is_array( $group_childs ) && count( $group_childs ) > 0) {
                    //there are child groups. See if user is in any ot them
                    if ( in_array($groupid, $group_childs) ) {
                        //user is in here; let pass
                        return 1;
                    }
               }
            }
        }//esle
        //no valid frontend users found to let pass; check if this is an Admin that should be let passed:

        if( $groupid == $obj_kunenacat->getAdminAccess() ) {
            //the user has the same groupid as the access level requires; let pass
            return 1;
        }
        else {
            if ($admin_recurse=='RECURSE') {
                //check if there are child groups for the Access Level
                $group_childs=array();
                $group_childs=$kunena_acl->get_group_children( $obj_kunenacat->getAdminAccess(), 'ARO', $admin_recurse );

                if (is_array( $group_childs ) && count( $group_childs ) > 0) {
                    //there are child groups. See if user is in any ot them
                      if ( in_array($groupid, $group_childs) ) {
                        //user is in here; let pass
                         return 1;
                    }
                }
            }
         }    //esle
    } // esle
    //passage not allowed
    return 0;
}
?>