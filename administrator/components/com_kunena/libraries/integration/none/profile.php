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
 **/
//
// Dont allow direct linking
defined( '_JEXEC' ) or die('');

class KunenaProfileNone extends KunenaProfile
{
	public function __construct() {
		$this->priority = 0;
	}

	public function getUserListURL($action='') {}

	public function getProfileURL($user, $task='') {}

	public function showProfile($userid, &$msg_params) {}
}
