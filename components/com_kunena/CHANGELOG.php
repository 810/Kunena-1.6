<?php
/**
* @version $Id$
* Kunena Component
* @package Kunena
*
* @Copyright (C) 2008 - 2010 www.kunena.com All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.kunena.com
**/

// no direct access
defined( '_JEXEC' ) or die();

?>
<!--

Changelog
------------
This is a non-exhaustive (but still near complete) changelog for
the Kunena 1.x, including beta and release candidate versions.
The Kunena 1.x is based on the FireBoard releases but includes some
drastic technical changes.
Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Kunena 1.6.0-ALPHA3

23-June-2010 Matias
^ [#15886] Merged revisions 2810-2817 from /branches/1.6-xillibit-fixes-20100620
^ [#20729] Update version info to 1.6.0-ALPHA3

22-June-2010 Xillibit
# [#19288] Add configuration settings for thank you stats
# [#19288] Put old code back for code when user disable code highlighting
# [#19288] Fix Notice: Undefined offset: 1  on kunena.parser.php when the image has no extensions

22-June-2010 Matias
# [#19288] Make sure that all KunenaUser instances have key > 0
+ [#20071] KunenaRoute: Add support for menu links, allow menu to be restricted to one category
# [#20071] KunenaRoute: If no menu item matches, use /component/com_kunena instead of current menu item
# [#20071] KunenaRoute: No need to look for more menu parents when getKunenaRoot() sees view=entrypage
# [#20071] Ignore default menu item detection if we see HTTP POST request in kunena.php
# [#20071] Menu item without children: Find closest match in Kunena Menu and use it instead menu item itself
+ [#20071] Add new class JElementKunenaCategories
+ [#20071] Menu: Change text field to category list to all catid configuration options
# [#19288] KunenaUser: Fix fatal SQL error when loading online status

21-June-2010 Xillibit
# [#19288] Upgrade poll tables structure when migrate from k1.5.x for all versions of hack
# [#19288] Don't hide the time to live input because doesn't work well with calendar
# [#19288] Put in stats the top thank you received and added a part in api

21-June-2010 Severdia
# [#21131] Removed inline styles on avatars in topics

Kunena 1.6.0-ALPHA2

20-June-2010 Xillibit
# [#19288] Update translation of fr-FR.com_kunena.install.ini
# [#19288] Fix undefined constant KUNENA_PATH_TEMPLATE during install
# [#19288] Use form validation instead alert when you edit announcements
# [#19288] Upgrade poll tables structure when migrate from k1.5.x
# [#19288] Fix issue in trash manager: can't delete topics with polls
# [#19288] Fix issue in template.xml: wrong avatar sizes
# [#19288] Show in trash manager the messages on hold=3 when you delete your own message
# [#19288] Add function in configuration panel to revert configuration to previous state

20-June-2010 Matias
^ [#15886] Merged revisions 2782-2793 from /branches/1.6-xillibit-fixes-20100619
# [#19345] Move JavaScript to the header in announcement/edit.php
# [#19345] Simplify #ktop (Kunena header) to div instead of table and remove duplicated html
^ [#15886] Merged revisions 2802-2806 from /branches/1.6-xillibit-fixes-20100620

19-June-2010 Xillibit
+ [#19288] Add code to have higlighted code with geshi (thanks JoniJnm)
# [#19288] Minor change to tooltips
# [#19288] Fix Class 'CKunenaWhoIsOnline' not found in libraries/user.php line 90
# [#19288] Fix Notice: Trying to get property of non-object in libraries/user.php line 272
# [#19288] Button thank you dosesn't display the favorite icon (thanks cerberus)
# [#19288] Make french translation for kunena installer
# [#19288] tsticky icon doesn't placed at the right place (thanks cerberus)
# [#19288] Fix Notice: Undefined variable: userlist in funcs\showcat.php line 198
# [#19288] Hide poll icon on new topic by default

19-June-2010 Matias
^ [#19345] Template Manager - Move avatar size configuration to template
- [#19345] Remove some unused CSS rules and images
# [#19288] Fix regression - Fix CSS for rounded buttons

19-June-2010 Severdia
# [#19356] Fixed RSS icon, moved outside credits
# [#19356] Fixed profile tab widths
# [#19356] Poll cleanup
# [#19356] More poll fixes, semantic markup
+ [#19356] Added source PSD files

19-June-2010 fxstein
^ [#19251] Enhanced user caching

18-June-2010 Severdia
# [#19356] Fixed attachment icon on category list page
# [#19356] Fixed whois & stats icons

18-June-2010 Matias
^ [#15886] Merged revision 2737 from /branches/1.6-xillibit-fixes-20100612
^ [#15886] Merged revisions 2744 and 2765 from /branches/1.6-dragan-fix-20100613 with changes
# [#19288] Fix regression - CKunenaLink::GetSamePageAnkerLink() broken

18-June-2010 @quila
# [#19288] Replace all icons from icons.php to css icons
# [#19288] Remove deprecated configuration New Indicator
# [#19288] New Indicator moved to language file

17-June-2010 Matias
^ [#19380] Update Mootools plugin to latest plgSystemMTUpgrade, uninstall old plugin
# [#20038] Do not install Mootools plugin in J1.6
# [#19251] Reduce 1 SQL call / page in CKunenaConfig; move table creation to installer
- [#19295] Clean up code: we do not need to check if all tables exists, new installer should fix that issue
# [#19288] Fix regression - Too strict permissions in template ini file - Kunena fails to install
# [#19288] Fix regression - Do not include template ini file into distribution as it resets configuration
# [#19251] Reduce 1 SQL call / page in KunenaSession if user has not logged in
# [#19251] Reduce 1 SQL call / page in CKunenaPathway
# [#19251] Implement user caching to greatly reduce number of SQL queries
^ [#19295] Rename FbForum class to TableKunenaCategory
^ [#19295] Clean up code: Deprecate html_entity_decode_utf8(), remove utf8_urldecode(), fbReturnDashed()
# [#19345] Some CSS fixes for Beez2 (J1.6)

16-June-2010 @quila
+ [#19288] Add serbian and serbian latin language files
# [#19288] Added function to load icons in default template

16-June-2010 Matias
^ [#15886] Merged /branches/1.6-@quila-tpl-100607
# [#19345] Template Manager - Make loading template configuration more robust
# [#19288] Fix regression - Remove some Zend warnings (also move javascript out of php file)
# [#19288] Fix regression - Minified CSS does not exist in Kunena SVN version
# [#20038] Joomla 1.6 Admin: Fix template manager, control panel, side panel
# [#20038] Joomla 1.6: Fix KunenaRoute
# [#20038] Joomla 1.6: Frontend should work again
# [#20038] Joomla 1.6: Split install.kunena.php into three parts

15-Jun-2010 Xillibit
+ [#19288] Add french language files

15-June-2010 @quila
# [#19345] Template Manager - some more changes
# [#19288] Fix regression: Moderate Topic buton aligned

15-June-2010 Xillibit
# [#19345] Template Manager - Change xml name installer to kinstaller

15-June-2010 fxstein
+ [#20916] New helper functions to load minified css and js or full version when in forum debug
# [#21032] Fix manifest error that leads to Joomla 1.6 install error message
+ [#21032] Add admin menu definition to manifest for Joomla 1.6 install

15-June-2010 Matias
# [#20833] Thank You: Escape variables inside queries
# [#20833] Thank You: Make button similar to others, place it into message actions list
# [#20833] Thank You: Simplify thank you list
^ [#15886] Merged /branches/1.6-sven-thx-20100531
# [#19345] Template Manager - Check that archive contains templates and install all of them (ignoring the rest)
# [#19345] Template Manager - Delete old version of the template before installing new one
# [#19345] Template Manager - Add class KunenaTemplate (and KunenaFactory::getTemplate()), which loads template configuration
# [#19345] Template Manager - Keep template configuration when installing new version of the template
# [#19345] Template Manager - Do not allow anyone to delete our default template (Blue Eagle)

14-June-2010 @quila
# [#19345] Template Manager - some more changes
# [#19345] Template Manager - initialize.php now loaded from published template
# [#19345] Template Manager - fixed location for template_thumbnail.png (images folder of template)

14-June-2010 Sven
# [#20833] Thank You: undefined variable
^ [#20833] Thank You: naming of the functions (camelCase)
^ [#20833] Thank You: moved code for more flexible into message.thankyou.php
^ [#20833] Thank You: limit all querys with a default limit value of 10
# [#20833] Thank You: Undefined property

14-Jun-2010 Matias
^ [#15886] Merged revisions  2703-2722 from /branches/1.6-xillibit-fixes-20100612
# [#19288] Fix regression - Installation failed

13-June-2010 Matias
# [#19345] Template Manager - Change template even if configuration didn't exist
- [#19293] Remove deprecated configuration option templateimagepath
^ [#19345] Template Manager - Load javascript and css from the template (initialize.php)

13-June-2010 @quila
# [#19345] Template Manager - language strings, Apply button works, some more fix
# [#19345] Template Manager - fixed "Edit CSS" button
# [#19345] Template Manager - delete tmp "kinstall" folder after installation
+ [#19345] Template Manager - added "Uninstall" template function

13-June-2010 Sven
# [#20833] Thank You: correct wrong headers
^ [#20833] Thank You: moved backend statistic to libraries/thankyou.php and libraries/table/kunenathankyou.php
^ [#20833] Thank You: killed catid and id in #__kunena_thankyou
^ [#20833] Thank You: unique (postid,uid)
^ [#20833] Thank You: KEY `userid` (`userid`),	KEY `targetuserid` (`targetuserid`)
^ [#20833] Thank You: language renamed strings thread/post -> message
^ [#20833] Thank You: all querys using JTable

13-Jun-2010 Xillibit
# [#19288] Make configuration setting working for disable version check
# [#19288] Function getRulesHelpDatas removed during merge
^ [#19288] New png icons which replace old gif icons (thanks DTP2)
# [#19288] Fix for videos with missing parameter in array which throw an error (thanks JoniJnm)
# [#19288] Fix for select template by user cookie (thanks JoniJnm)
# [#19288] Fix issue with AUP integration on kimport undefined when you want see the userlist
# [#19288] Uniform tooltips on social icons
# [#19288] Fix issue in RSS (thanks JoniJnm)
^ [#19288] Put png icons for lightbox and group attachments in lightbox on each message

12-June-2010 @quila
+ [#19345] Template Manager - some more changes.

12-Jun-2010 Xillibit
# [#19288] Fix issue on changevote in poll which decreased everytime the poll votes
# [#19288] Put version check data in joomla session and put a configuration setting for disable version check
# [#19288] On edit ban, allow to remove the ban
# [#19288] Select only the item with func for show online user in pathway
# [#19288] Make working poll vote and change vote without ajax

12-Jun-2010 Matias
- [#19244] Remove deprecated ban logic from lib/kunena.moderation.tools.class.php
^ [#15886] Merged feature branch /branches/1.6-@quila-ban-100526
^ [#15886] Merged revisions 2677, 2687 and 2688 from /branches/1.6-@quila-fix-100608
^ [#15886] Merged revisions  2685 and 2686 from /branches/1.6-xillibit-fix
# [#19288] Fix regression - Admin: Undefined variables in report configuration if configuration hasn't been saved
^ [#15886] Merged revisions 2662-2674 from /branches/1.6-810-bugfixes
# [#19345] Template Manager - Make extract template to work

11-June-2010 Sven
# [#20833] Thank You: redirect with right message when user not loged in or session expired
+ [#20833] Thank You: Thank You statistic in kunena cpanel
+ [#20833] Thank You: Language strings for statistic
+ [#20833] Thank You: Where got thx, where said thx in Profile Tab

11-Jun-2010 Matias
# [#19244] Add basis for user caching in KunenaUserBan class
# [#19244] Fix user manager in administration and simplify code
# [#19244] Fix many bugs in ban (classes, profile, templates)
# [#19244] Modify link functions so that they do not need username (simplifies ban template/logic)
# [#19244] Add html escapes to the fields in the profile pages (prevents XSS attacks)

10-June-2010 @quila
# [#19288] Fix regression - Kunena in the footer don't point to kunena official site.
# [#19288] Fix regression - Correction of text in subscription email.

10-Jun-2010 Matias
# [#19288] Fix regression: Fix file upload (wrong permissions) in some environments
^ [#19244] Simplify ban templates as much as possible -- remove extra functionality to get everything to work
+ [#19244] Add new features to ban classes, make them more robust

9-June-2010 Xillibit
^ [#19288] Check new of versions of kunena with xml things
- [#19288] Remove the useless maxlength on links and images links

9-June-2010 severdia
# [#19356] Fixed top margin on attachment section

8-June-2010 810
# [#19288] Small Css fix - Boardcode

8-June-2010 @quila
# [#19288] Fix regression - subject message suffix wrong for new post.

8-Jun-2010 Matias
^ [#19244] Major changes on how ban works internally (JTable)
^ [#19244] Start using new ban class in the code
^ [#19244] Move ban tasks into profile (from class.kunena.php and kunena.php)
^ [#19244] Change minimum PHP requirement to 5.2.3 (we are using json functions)

8-June-2010 fxstein
+ [#20916] Add css and js minification logic to build process
+ [#20916] Add YUI Compressor libraries to build files

7-June-2010 @quila
+ [#19345] Template Manager - added toolbar menu buttons.
+ [#19345] Template Manager - added tasks for toolbar menu.
+ [#19345] Template Manager - added functions for display templates in backend.
+ [#19345] Template Manager - added language strings for html file.
+ [#19345] Template Manager - added functions for template and language strings.
+ [#19345] Template Manager - added icons and images.
+ [#19345] Template Manager - added variable for reading template parameters from params.ini.
+ [#19345] Template Manager - added files templateDetails.xml, params.ini and image template_thumbnail.png
^ [#19345] Template Manager - moved template and templateimagepath configuration from kunena to template manager
^ [#19345] Template Manager - moved Avatar Position configuration from kunena to template manager
^ [#19345] Template Manager - added button in kunena control panel

7-June-2010 810
# [#19288] Small Css fix - Thread action, Threads showcat, Boardcode

7-June-2010 Matias
^ [#15886] Merged revisions 2634-2659 from /branches/1.6-xillibit with changes
^ [#19244] Moderation feature: Rework ban tables, add banned field into user table

7-June-2010 severdia
# [#19356] Fixed rest of CSS underscores to dashes (consistent naming), synchronized styles

7-June-2010 fxstein
# [#19288] Fix regression - CSS fix for category description.

7-June-2010 @quila
# [#19288] Fix regression - active tab menu not working.
# [#19288] Fix regression - announcement don't show.
# [#19288] Fix regression - CSS fix for category description.
# [#19288] Fix regression - klist-avatar rules CSS.

7-June-2010 Xillibit
# [#19288] Use integration classes to show in stats the total number of profile views

6-June-2010 Xillibit
# [#19288] Fix misplaced moderate button, when kunena is in full width (thanks cerberus)
# [#19288] Fix undefined variables in libraries/route.php (Part 2)
# [#19288] Fix issue in notification mail, the word Subject is tripped by JMailHelper::cleanBody()
^ [#19288] Show AUP users medals on kunena profilebox

6-June-2010 fxstein
# [#19251] Fix for user caching: exclude empty userids from cache to avoid sql error

5-June-2010 Sven
+ [#20833] Thank You: usertab gotthankyou and saidthankyou
+ [#20833] Thank You: language strings

5-June-2010 Xillibit
# [#19288] Fix issue with AUP integration which doesn't provide the correct link for userlist with sef
# [#19288] Naming changes into CSS (thanks cerberus)
# [#19288] Fix undefined variables in libraries/route.php
# [#19288] Fix issues with jomsocial integration on loadusers, remove empty values to avoid failed query

4-June-2010 Sven
^ [#20833] Thank You: moved thank you button to subject
+ [#20833] Thank You: language string in front and backend
+ [#20833] Thank You: Option to deaktivate thank you in backend
^ [#20833] Thank You: function getThankyouUser so it also can show realname
^ [#20833] Thank You: added showthankyou row in #__kunena_config

4-June-2010 Matias
# [#20071] Change logic how Kunena detects current menu, fixing issues with missing tab menu in Kunena
# [#20071] Add new entry menuitem for Kunena, which can be used to make unlimited menus for Kunena anywhere in menu trees
# [#20071] Add support for arbitary default pages; fix issue with parameters
^ [#15886] Merged revisions 2619-2626 from /branches/1.6-xillibit with changes

4-June-2010 Xillibit
# [#19288] Check directory permissions on avatar upload and change it if needed

4-June-2010 fxstein
^ [#20841] Change logic for who is online stats to match Joomla

3-June-2010 Sven
+ [#20833] Thank You: kunena.thankyou.php
+ [#20833] Thank You: CKunenaThankYou class
+ [#20833] Thank You: Thankyou button right beside Quote
+ [#20833] Thank You: sql table #__kunena_thankyou

3-June-2010 Xillibit
# [#19288] Fix to avoid the issue rename failed at the end of installation
# [#19288] Remove email adress from report settings to avoid spam
# [#19288] Fix undefined variable on form.php line 86
# [#19288] AUP avatar can't be rezised below 100x100px
^ [#19288] Configuration settings to define the maxlength for url on links and images
# [#19288] Show joomla! tooltip on social icons in message profilebox and in profile
# [#19288] Fix issue which prevent to save poll vote and fix conflict with JHTML::_('behavior.tooltip') which load a new time MT library

3-June-2010 Matias
# [#20071] Make menu items visible in Joomla Menu Manager

1-June-2010 Matias
^ [#20729] Update version info to 1.6.0-ALPHA2
# [#19288] Replace router.php in the beginning of the installation to prevent error messages in frontend during installation
# [#19288] Installer: Better error detection
# [#19288] Installer: Sample data gets inserted too early - installation fails if there were no messages or categories
# [#19288] Undefined variables in CKunenaLatestX class if there are no threads to be shown
# [#19288] Undefined variable userkarma in CKunenaProfile class if karma is disabled

01-Jun-2010 @quila
^ [#19244] Moderation feature: cleanup ban manager

29-May-2010 Xillibit
# [#19244] Escape all database columns, little change on database structure
# [#19244] Add configuration setting to display ban reason in profile, set ban rank when an user is banned

28-May-2010 @quila
^ [#19244] Moderation feature: cleanup ban manager, ban history and add ban pages
^ [#19244] Moderation feature: new language strings for new ban system
# [#19244] Moderation feature: fixed some bugs in ban manager
+ [#19244] Moderation feature: new icons in ban manager

27-May-2010 Xillibit
^ [#19244] Tab ban history is working now
^ [#19244] Tab ban manager is working now and it's displayed only in mod profiles

26-May-2010 @quila
+ [#19244] Moderation feature: add Ban Manager, Ban History and Add Ban tabs in profile page
# [#19244] Moderation feature: improved template in "Add Ban" tab (rules in kunena.forum.css)
# [#19244] Moderation feature: created all language string in "Add Ban" tab

Kunena 1.6.0-ALPHA

30-May-2010 Severdia
^ [#19356] CSS updates for Chrome, etc.

30-May-2010 Matias
# [#20038] Installer: Keep forum offline until installation is complete
# [#19288] Fix regression: Uploaded avatars do not show up
# [#19288] Fix regression: Undefined property: CKunenaLatestX::$threads
# [#19288] Installer: Fix a bug in table migration code
# [#19288] Installer: Add logic to migrate avatars from Kunena / FB
# [#19288] Installer: Fix a bug where upgrade on larger forum does not get reloaded on DB upgrade
# [#19288] Change logic on how we save avatars to be uniform (no quessing)
# [#19288] Change logic on how we save resized avatars, should be a lot faster in large forums

29-May-2010 Severdia
^ [#19356] Changed CSS styles to format using k and dashes
^ [#19312] Cleanup English language file
# [#19356] Fixed IE/FF word wrap bug

29-May-2010 Matias
# [#19312] Cleanup English language file: Use sections/categories instead of categories/forum
# [#19288] Regression in Installer: Mootools 1.2 did not get installed
# [#19288] Regression in Installer: If server is too fast, KunenaFactory does not get loaded
# [#20038] Minimum Joomla version is 1.5.18 (older ones have bug in redirect)
# [#19288] Regression in pathway: Undefined variable: onlineUsersList

28-May-2010 Severdia
# [#19356] CSS fixes for broken layouts caused by no breaks in code tags, new images

28-May-2010 Matias
# [#19288] Regression in Installer: Fix migration when #__kunena_version gets created
# [#19288] Bug in Installer: Upgrade fails if #_kunena_attachments_bak exists and attachments haven't been converted
# [#19288] Fix regression (db error) when user tries to post a message
# [#19288] Upgrade Kunena database tables to use UTC instead of offset in Kunena configuration

27-May-2010 Xillibit
# [#19288] Fix issues when anynomous option is enabled, on new topic the checkbox isn't displayed (Part 2)
# [#19288] Remove queries in rules and help pages and call function instead

27-May-2010 Matias
# [#20038] Minimum Joomla version is 1.5.15
# [#20038] Make forum administration to work in J1.6 (except for ACL)
# [#20038] Edit Profile: Hide edit user information in J1.6 for now
# [#20038] Fix J1.6 incompatibilities in CKunenaPath class
^ [#15886] Merged revisions 2538-2565 from /branches/1.6-xillibit with changes
^ [#15886] Merged revision 2550 from /branches/1.6-@quila-fix-100526

26-May-2010 @quila
# [#19288] Fix regression - CSS and template fixes.

26-May-2010 Xillibit
^ [#19288] Combine #__kunena_banned_users and #_kunena_banned_ips table
# [#19288] Fix issues on javascript in profile moderation

26-May-2010 Matias
# [#19288] Replace old white error screen by less intrusive error messages
# [#19288] Fix regression: Bad category permissions in sample data

25-May-2010 Xillibit
# [#19288] Fix regression on userban and enable user in kunena user manager
# [#19448] Clean html by removing tables in rules, help, login and view.php
# [#19448] Move some code out from pathway , rules and help

25-May-2010 Matias
# [#19288] Fix a few bugs in installer that cause clean installation to fail in some environments
# [#19288] Remove all but one dependency to frontend files during installation
# [#19288] Fix undefined variable during uninstall
^ [#20038] Improve installer, make admin menu image to work in J1.6
# [#20038] Joomla 1.6: Use correct author for sample message (= user who installed Kunena)
# [#20038] Joomla 1.6: Implement isAdmin(), getAllowedCategories() and getSubscribers()
# [#19288] Fixed coloring for guests and global moderators
# [#19288] Fixed missing avatar sometimes when file cannot be found
# [#20038] Joomla 1.6: Make javascript to work (except for shrink/expand)
# [#20038] Joomla 1.6: Make editor to work again

24-May-2010 Matias
# [#20038] Create virtual view to have menu item for Joomla 1.6
^ [#15886] Merged revisions 2525-2532 from /branches/1.6-xillibit with changes

24-May-2010 Xillibit
# [#19288] Fix regression caused by undefined variables on AUP avatar integration class
# [#19288] Add clearstatcache() in kunena.file.class to avoid issues

23-May-2010 Matias
# [#20038] Split installer steps into tasks to avoid timeouts
# [#20038] Fix misc Joomla 1.6 issues in the installer
# [#20038] Move sample data into it's own file, make it more robust
# [#20038] Simplify kunena.install.upgrade.xml by running always install tables
# [#20038] Fix uninstall in Joomla 1.6
# [#20038] Remove dependencies to frontend during installation

23-May-2010 Xillibit
# [#20038] Function to delete menu on joomla 1.6 when kunena is uninstallated
# [#19288] Fix issues when anynomous option is enabled, on new topic the checkbox isn't displayed
# [#19288] Fix undefined variable $this->_app on ban function in class.kunena
# [#19288] Fix issue which doens't diplay avatar in correct size with AUP integration (Part 2)
# [#19288] Remove hard-coded url in anonymous check in new topic tab

21-May-2010 Matias
^ [#15886] Merged revisions 2508-2513 from /branches/1.6-xillibit with changes
# [#20038] Added our own images to installer
^ [#15886] Merged revision 2509 from /branches/1.6-@quila-bugfix

20-May-2010 Matias
# [#20038] Fix misc Joomla 1.6 issues in the installer

19-May-2010 Xillibit
# [#19288] Little change in CKunenaLastestX to be used properly with kunenalatest module
# [#19288] Fix Kunena stats to use proper configuration setting to check which profile integration is enabled
# [#19288] Fix issue which doens't diplay avatar in correct size with AUP integration

18-May-2010 @quila
# [#19288] Fix regression - small template fixes.

17-May-2010 Xillibit
# [#19288] Fix issue with UddeIM integration which doesn't show the unread messages but total messages

17-May-2010 Matias
# [#20038] Fix Joomla 1.6 issues in the installer (status: no menus, 3 queries still fail)

16-May-2010 fxstein
+ [#19251] Re-implement JomSocial user caching to reduce sql queries

16-May-2010 810
^ [#19356] Fix pagination layout

16-May-2010 Matias
^ [#15886] Merged revisions 2477, 2494 from /branches/1.6-@quila-bugfix with changes
^ [#15886] Merged revisions 2481, 2495 from /branches/1.6-810-bugfix with changes
# [#19288] Install Mootools 1.2 if Joomla doesn't already have it
# [#19288] No Replies page showed only less than a month old threads
# [#19288] CSS tweaks
# [#19288] Improve installer to better handle errors
# [#19288] Change internal ZIP files so that installation works with older Joomla releases

15-May-2010 Matias
^ [#20444] Convert our database tables to jos_kunena
^ [#20444] Add jos_fb to jos_kunena migration to installer, while keeping backup for K1.5
^ [#20444] Strip slashes from DB and remove all calls for addslashes() and stripslashes()
# [#20038] Basic Joomla 1.6 support: Installer now redirects to our own installer
# [#20444] Fix migration from J1.5: Attachments table conversion failed

14-May-2010 810
# [#19288] Fix regression: help/rules page Undefined property: KunenaApp::$catid
^ [#19312] Missing language strings added
^ [#19356] Minor HTML/CSS fixes in the backend

14-May-2010 @quila
# [#19288] Fix regression in language file - Who page.
# [#19288] Fix regression - Avatar is too large in top and bottom avatar position.
# [#19288] Fix regression - Number of Popular Polls in statistics.
# [#19288] Fix regression in profile: UddeIM Integration - PM Icon messed up in IE8.
# [#19288] Fix regression - List of Allowed file exstensions is not in tooltip in post page.
^ [#19345] Increased maxlenth for Poll Title (25 -> 100) and Options (25 -> 50), and added size to input.
# [#19356] Fixed template listcat.php. Aligment issue if there are no posts.
+ [#19345] Restyled Frontstats plugin - added stats icon.
+ [#19345] Restyled Who Is Online plugin.
+ [#19345] Added User Color Code Legend in Who Is Online plugin.
+ [#19345] Added more Color Code for Global Moderator, Users and Guests (not working).
+ [#19758] Added function for upload Emoticons in the backend Emoticon Manager.
+ [#19758] Added function for upload Rank Image in the backend Rank Manager.
^ [#19288] Kunena Header table moved from kunena.php to profilebox.php to improve template design.
^ [#19288] Added rss icon in the icons.php to improve template design.
^ [#19288] Removed rigid table from "Code" in kunena.parser.php and added class to improve template design.

14-May-2010 Matias
^ [#15886] Merged revisions 2437-2450 from /branches/1.6-xillibit with changes
^ [#20038] Basic Joomla 1.6 support: Move kunena.files.distribution to media/kunena
# [#20038] Basic Joomla 1.6 support: DB Installer for J1.6
# [#19288] Fix regression in installer: no translations in menus, sample data

13-May-2010 Matias
# [#19288] Fix regression in installer: clean install failed

12-May-2010 Matias
^ [#20038] Basic Joomla 1.6 support: New installer

11-May-2010 Xillibit
^ [#19288] Add user moderation tools or ban functions in kunena users manager and in profile page (Part 2)
^ [#19288] Show user avatar in kunena user manager list
# [#19288] Fix regression on kunena avatar integration which prevents to display avatars from gallery
# [#19288] Ban user or ip doesn't work properly
# [#19288] Add fields into profile to add expriration and message when moderator bans a user

11-May-2010 Severdia
# [#19356] Various CSS fixes for frontend, IE7 compatibility

11-May-2010 Matias
^ [#15886] Merged revisions 2434-2435 from /branches/1.6-xillibit
# [#20038] Basic Joomla 1.6 support: Fix archive and manifest to copy all files (including installer)
# [#19288] Fix regression: Forum ordering was not respected in subcategory level (listcat)
# [#19288] Do not add [attachment] tag for now -- it's not fully implemented

10-May-2010 Xillibit
^ [#19288] Add user moderation tools, ban functions in kunena users manager (not yet finished)

9-May-2010 Matias
^ [#15886] Merged revisions 2429-2431 from /branches/1.6-xillibit
# [#19288] Fix regression in profile: non-existing users cause page to crash

9-May-2010 Xillibit
# [#19288] Fix regression on summary.php on function getInboxLink()
# [#19288] Fix regression Undefined property: CKunenaPosting::$catid in kunena.posting.class.php
# [#19288] Show new bbcode [attachment][/attachment] in textarea when put new attachments
+ [#19288] Add user moderation tools or ban functions (thanks littlejohn)

8-May-2010 Xillibit
+ [#19288] Put links into profile page to access PM boxes
# [#19288] Don't let unregistered users to report message
# [#19288] Do not show login message if visitor tries to post new topic

8-May-2010 Matias
^ [#19448] Move code out of template: Announcements
^ [#19448] Move login.php and profilebox.php from plugins to template dir
^ [#19448] Clean up and simplify Announcements html
^ [#19448] Clean up and simplify Rules, Help & Forumjump html
^ [#19448] Clean up and simplify Search html
^ [#19448] No need to have 2 login areas, simplified login.php
^ [#15886] Merged revisions 2412-2424 from /branches/1.6-xillibit with changes

7-May-2010 Xillibit
# [#19288] Anonymous posting option isn't given when you begin a topic from the top tab new topic
# [#19288] Move report.class.php into lib directory

7-May-2010 Matias
# [#19288] Fix autocompleter in search
+ [#19244] Moderation feature: add autocompleter into userlist (Find User)
^ [#19448] Move code out of template: Userlist

6-May-2010 Xillibit
# [#19288] Fix regresion on who.class.php which break the viewing users in pathway
# [#19288] Put PM links (CB, Uddeim, Jomsocial) in profilebox
^ [#19288] Rewrite report.php as a class

5-May-2010 Matias
^ [#15886] Merged revision 2412 from /branches/1.6-xillibit
# [#19288] Fix regression in listcat: router list had wrong values -> extra queries
# [#19288] Fix regression in CKunenaWhoIsOnline: same task was done 2 times
# [#19255] Fix XHTML validation errors in search

5-May-2010 Xillibit
# [#19288] Fix regression in kunena.who.class.php with method GetCategoryListURL() undefined
# [#19288] Fix regresssion wrong hidden users display in whoisonline
# [#19288] Remove link for social buttons (skype, msn...) because doesn't work under IE

4-May-2010 Matias
^ [#19244] Implement new Moderation features: New topic/post moderation screen (no AJAX yet)
- [#19244] Remove deprecated moderation buttons, for now on every action will be move
# [#19244] Fixed a few bugs in moderator class, simplified logic
# [#19288] Fix regression: Preview is not working
# [#19288] Fix regression: CB/JomSocial installed, no integration: infinite redirect on Profile page
^ [#15886] Merged revisions 2380-2403 from /branches/1.6-xillibit with changes
+ [#19244] Implement new Moderation features: Add some AJAX to the move topic/post screen
+ [#19288] Add debug mode to Kunena
+ [#19244] Implement new Moderation features: Minor improvements to usability

03-May-2010 Xillibit
# [#19288] Put a constructor in the poll class with changes how to use it
# [#19288] Remove the useless query in poll to get parent
# [#19288] Put kunena.who.class.php in lib with a little change
# [#19288] Fix one warning detected in whoisonline.php in html

02-May-2010 Xillibit
# [#19288] Changes on CKunenaWhoIsOnline with functions to load templates : who.php and whoisonline.php
# [#19288] Fix links on who page

01-May-2010 Xillibit
# [#19288] Use CKunenaTimeformat::showDate() in who page
# [#19288] Rewrite who.class.php like a true class with little changes

30-Apr-2010 Xillibit
# [#19288] Fix undefined variables in parser.php on video size
# [#19288] Minimize javascript buttons on the Stats page not working
# [#19288] Add tab in profile to see Uddeim links with unreadmessages

30-Apr-2010 Matias
+ [#19356] New status based topicicons when users cannot pick up their own icons
+ [#19356] Topic icon: add link to first unread (or last) message

29-Apr-2010 Xillibit
# [#19288] Add $title parameter in function GetProfileLink() to be used in kunenalatest module
# [#19288] Extra slash in path of avatars in gallery
# [#19288] Add configuration setting to show or hide list of online users for security purpose
^ [#19288] change getName() function in user.php from protected to public

29-Apr-2010 Matias
# [#19288] Fix regression: JomSocial avatar integration is not working

28-Apr-2010 Severdia
+ [#19356] Tweak select box size on admin side.

28-Apr-2010 Xillibit
# [#19288] Give the possibility to disable or enable easily the topicicons with config settings
+ [#20254] Integration of lightbox on images using script based on MooTools (thanks Cerberus)

28-Apr-2010 Matias
# [#19288] Administration: Escape text input fields before showing them (to show "foo")
# [#19288] Magic Quotes setting in PHP adds slashes to configuration options and category names, desctriptions
# [#19288] Fix regression: Minimizing top profilebox does not work if you're not logged in
# [#19244] Implement new Moderation features: Show unapproved and deleted messages in most screens (if permissions)
# [#19244] Implement new Moderation features: Add func = unapproved/deleted
^ [#15886] Merged revisions 2370-2371 from /branches/1.6-xillibit
# [#19288] Fix regression: If function/category does not exist, show error page
# [#19288] Fix regression: Category administration: do not show non-existent moderators in the list
# [#19288] Allow user to reset Kunena configuration
# [#19288] By default, new category should be moderated
# [#19288] Remove confidential information from quoted text

27-Apr-2010 Xillibit
# [#19288] Hide about me when it's empty
# [#19288] Set standard width and height for video if the user forgot to put them in parser

27-Apr-2010 Matias
^ [#15886] Merged revisions 2360-2363 from /branches/1.6-xillibit with minor changes
# [#19288] Fix regression: Wrong menuitem gets highlighted if default page is not Index
# [#19288] Fix regression: Only one attachment can be deleted in edit
# [#19288] Uninstall does not remove Kunena menu (=> broken links)
# [#19288] Admin: Create menu does not reset kunenamenu, but users expect it to do it
# [#19288] Installing Kunena does not always create menus
# [#19288] Fix regression: Typo in CKunenaModeration::_Delete(): usersid

26-Apr-2010 Xillibit
# [#19288] Display userid in trash manager
# [#19288] Fix little regression on delete perminantly function
# [#19288] Put tooltip to show extensions allowed in form
# [#19288] Profile: Put the personnaltext (about me) below the avatar
# [#19288] Change how the functions Restore and Delete works (hold=2,3)
# [#19288] Fix undefined variable on line 95 on kunena.php (no Itemid)
# [#19288] Wrong width and height for video added by choosing the provider in the list and putting the video ID
# [#19288] Set standard width and height for video if the user forgot to put them
# [#19288] When you save your own avatar for the first time, you have the message JFolder::files: Path is not a folder:

26-Apr-2010 Matias
+ [#20071] KunenaRoute: Remove redirect when not in kunenamenu, set active menu item instead
^ [#15886] Merged revision 2349 from /branches/1.6-xillibit with changes
# [#19288] Make custom avatar galleries to work with SEF (thanks xillibit)
# [#19288] Use CKunenaAttachments in post history
# [#19288] Fix YouTube embed bug where some videos were not showing up
# [#19288] Do not redirect in CKunenaView->display(), fixes a bug in Kunena Discuss plugin

25-Apr-2010 Xillibit
# [#19288] Small change to gallery url

25-Apr-2010 Matias
# [#19288] Fix regression: Do not show gray/unused social icons when viewing a topic
^ [#15886] Merged revision 2345 from /branches/1.6-810
^ [#15886] Merged revision 2343 from /branches/1.6-xillibit with changes
# [#19288] Administration: Improve category lists for users and categories
+ [#19288] User Administration: Add missing Global Moderator option to the category list
# [#19295] Clean up code: remove a few unused or deprecated functions in administration
# [#19288] Fix moderate user layout (thanks Cerberus)
# [#20222] Do Not Use Category IDs: Router cannot decide which catid to use if categories have the same name

24-Apr-2010 Xillibit
# [#19288] Hide button Mark Forum Read if there are no posts in the cat
# [#19288] Show message "There are no posts in this forum" if there are no posts but there are sub-categories
# [#19288] Add a list of extensions file allowed in post form
# [#19288] Show description cat on hover on listcat
# [#19288] Put button delete permanently near to the button delete
# [#19288] Put new configuration setting to exclude or allow specifics cats from recent discussions page

24-Apr-2010 Matias
^ [#15886] Merged revisions 2332, 2333 and 2337 from /branches/1.6-810
^ [#15886] Merged revision 2335 from /branches/1.6-xillibit
# [#19288] Fix regression: Use avatar size/quality on avatar uploads, set maximum size to 200x200px
# [#19288] Use always new avatar class to show avatar (image may not exist)
# [#19288] Fix regression: Fix media URL in administration
# [#19288] Fix regression: In some cases users get attachments to their messages from nowhere
# [#19295] Clean up code: remove old attachment code, use always new CKunenaAttachments class
# [#19251] Reduce the number of SQL calls in forum prune (3x messages + 2x threads + 2 -> 2x threads + 3)
# [#19288] Do not delete files which are used in other attachments or are not really Kunena attachments
# [#19288] Fix regression: Deleting attachments didn't work, they were always deleted during edit

23-Apr-2010 Xillibit
# [#19288] Fix wrong description for social info in edit profile and wrong links
^ [#19288] Change ordering setting in profile by adding a kunena global option
# [#19288] Put karma details with icons minus and plus in profile
# [#19288] Add configuration setting to choose delete behaviour for user

23-Apr-2010 Matias
^ [#15886] Merged revision 2322 from /branches/1.6-810 with changes
# [#19288] Fix regression: Administration: fix IP listing in user manager
# [#19288] Fix last edit 0 minutes ago, if edit time was not saved (import?)
# [#19288] Fix regression: New smiley query in installer was slightly broken
# [#19288] Better error message if upload fails on extension check
# [#19288] Do not resize image if it is within allowed size limits (keeps animated gif working)
# [#19288] Handle correctly transparent images (including blending), keep image format
# [#19288] Save uploaded avatars to avarars/users/user123.jpg and sizeXX_user123.jpg etc
+ [#19288] Show avatar also in Categories page
^ [#19293] Remove deprecated configuration options: make avatar sizes to be template specific instead of global options

23-Apr-2010 810
# [#19288] Fix regression: Check all button didn't work in IE8
^ [#19758] Clean up Admin interface: New edit Forum style in backend
^ [#19758] Clean up Admin interface: New smillies header image fixed (first smiley not yet working)
^ [#19356] Minor HTML/CSS fixes in the backend

22-Apr-2010 severdia
^ [#19758] New smilies and new key combos (including maps to other forums)

22-Apr-2010 810
^ [#19758] Clean up Admin interface: New edit Profile style in backend
# [#19758] Clean up Admin interface: Fixed signature editing
# [#19288] Fix regression: Fix upload browsers

22-Apr-2010 Matias
# [#20203] Administrator has full moderator permissions, but that does not mean that he has to be one
# [#20204] Every moderator gets email when only global moderators and assigned moderators should get it
^ [#15886] Merged revisions 2316, 2318 and 2323 from /branches/1.6-xillibit

22-Apr-2010 Xillibit
# [#19288] Show attachments in post history
^ [#19288] Replace poll field add/remove icons, by icons minus and plus
# [#19288] Put tooltips on profile input field to better understand the format of strings to enter

21-Apr-2010 Xillibit
# [#19288] Fix issue which prevents to display images in browse images in backend (Part 2)
^ [#19764] Add new javascript part for common moderation page (not working yet)

19-Apr-2010 severdia
# [#19758] Fixes for admin UI, cross-browser issues

18-Apr-2010 Matias
^ [#15886] Merged revisions 2279-2288 from /branches/1.6-xillibit

18-Apr-2010 Xillibit
^ [#19764] New configuration setting to choose between multiples buttons or one button for moderation

17-Apr-2010 Xillibit
# [#19288] Fix issue which prevents to display images from not default gallery
# [#19288] Fix issue which prevents to display images in browse images in backend (not totally working)
# [#19288] Fix some language strings and little changes
# [#19288] Some little fixes and changes on backend
# [#19288] Make javascript working on select category when you aren't on new topic and hide poll icon

17-Apr-2010 Matias
# [#19288] Do not list moderators who do not exists (deleted or banned)
^ [#15886] Merged revisions 2239 and 2272 from /branches/1.6-xillibit-fixing with changes

15-Apr-2010 Matias
# [#19288] Fix regression: Fatal error when changing vote in a poll
# [#19288] Fix regression: Topic icon cannot be changed while editing post
# [#19288] Fix regression: Show images for guests and Show attachments for guests = 'No' have no effect
# [#19288] Fix regression: Only allow gif, jpeg, jpg and png images in avatar upload
# [#19288] Fix regression: Fix bug in API which prevented mod_kunenalatest from working with unregistered users

14-Apr-2010 Matias
# [#19288] Fix regression: Some old topics are invisible in current schema -- fix database during install
+ [#19288] Allow administrator to see deleted posts and undelete them
+ [#20050] Add new integration classes: Add new event onAfterUndelete to Activity class
# [#19288] Fix regression: do not allow anyone to reply hidden messages
# [#19288] Fix regression: do not use auto redirect to valid topic in KunenaDiscuss plugin
# [#19288] Fix regression: do not hide "Who is online" when Show Statistics = No
# [#19288] Fix regression: Disable emoticons = Yes has no effect when you write a new message
# [#19288] Fix regression: CommunityBuilder avatar for visitor was broken
# [#19288] Fix regression: Allow Subscriptions = No has no effect in profile page
# [#19288] Fix regression: Allow Favorites = No has no effect in profile page
# [#19288] Fix regression: If configuration option Allow Favorites = No, all topics have been favorited by visitor (part 2)
# [#19288] Fix regression: The NEW indicator doesn't show up in func=showcat
# [#19288] Fix regression: Users should not be able to upload image if only files are allowed and files if only images are allowed

13-Apr-2010 Matias
# [#19288] Anonymous posts should change name to "Anonymous" with a warning if username exists
# [#19288] Fix regression: Forum administration breaks up when there are no categories
# [#19288] Fix regression: Mark all forums read does not work
# [#19295] Clean up code: Delete post should use the same function as moderator and normal user
# [#19288] Fix regression: Delete post button shows up even if there are replies
# [#19288] Fix regression: Empty page in view if limitstart > messagecount (redirect to last page)
# [#19288] Fix regression: In move topic, "Leave ghost message in old forum" has no effect
# [#19288] Fix regression: Configuration option Ranking = No causes func=view to crash
# [#19288] Fix regression: Configuration option Show User Statistics = Yes has no effect in profile
# [#19288] Fix regression: "Rank" is not translated in profile/summary.php
# [#19288] Fix regression: If configuration option Allow Favorites = No, all topics have been favorited by visitor
# [#19288] Fix regression: Fix some minor bugs in router/routing

13-Apr-2010 Xillibit
^ [#19380] List attachments when editing post with checkboxes to delete the attachements

12-Apr-2010 Matias
^ [#20050] Move more code to KunenaParser
# [#19288] Fix regression: facebook gets value from skype when user edits profile
# [#19288] Fix regression: Users cannot post: You are not allowed to change your name!
# [#19288] Fix regression: Fatal error: Unable to load attachments in func=view
# [#19288] Fix regression: &amp;s in redirects - menu disappears
# [#19288] Fix regression: Better checks and error detection when deleting your own message
# [#19288] Fix regression: Allow user to post many attachments with the same name (just rename them)
# [#19288] Allow multipart file extensions: tar.gz etc
# [#19288] Fix regression: Configuration screen did not work in PHP <5.2.4
# [#19288] Fix regression: Edit profile url points to JomSocial (stay in Kunena)
# [#19288] Fix regression: No threads were marked read
# [#19288] Allow catid=0 in func=view (redirect it)
# [#19288] Fix regression: Show attachments while editing message
# [#19288] Fix regression: Profile in menu does not point into CB/JomSocial/AUP profile
# [#19288] Fix regression: Edit/Quote post adds &amp;s into the body

12-Apr-2010 Xillibit
- [#19764] Remove useless functions KUnfavorite() and KUnsubscribe() in class.kunena.php
^ [#19764] Replace all separte pages for moderation (split, move...) by one page (not fully tested)

12-Apr-2010 810
^ [#19356] Minor HTML/CSS fixes

11-Apr-2010 Matias
# [#19288] Fix regression: preview layout issues
# [#19288] Fix regression: anonymous button too large in Opera
# [#19288] Fix regression: some layout issues in func=view
# [#20141] Mark forum read can break your session
# [#19288] Fix regression: UTF8 letters breaks outer tags in bbcode
# [#19288] Fix regression: Allow username to be changed again from profile
# [#19288] Fix regression: Karma layout issue in IE8
+ [#20050] Add new integration classes: Add new events onAfterEdit/Delete to Activity class
^ [#15886] Merged revisions 2196-2213 from /branches/1.6-xillibit-fixing
# [#19288] Fix regression: KunenaRoute uses deprecated class initiation on config
# [#19288] Fix regression: Allow splitting topic into the same category (invalid check fixed)
# [#19288] Fix regression: Image MIME type (%s) is not allowed (%s).
# [#19288] Fix regression: UTF-8 letters will break preview
# [#19288] Fix regression: Birthdate should not use local timezone
# [#19288] Fix regression: Consistent usage of stripslashes() inside CKunenaTools::parseText/parseBBCode/stripBBCode()
# [#19288] Fix regression: More uniform usage of stripslashes() and htmlspecialchars() with bugfixes
+ [#20050] Add new class KunenaParser (html.parser), deprecated CKunenaTools::parseText/parseBBCode/stripBBCode()
# [#19288] Fix regression: Fix avatar/attachment upload not to scale up images

11-Apr-2010 Xillibit
# [#19380] Fix attachments links in message and add generic icons for attachments
# [#19288] Fix regression with post move
^ [#19288] Replace some hard coded text strings
# [#19288] Fix regression in who Undefined variable: kunena_my
# [#19288] Allow merge function to merge with any topics on the forum
# [#19288] When you upload an avatar, it doesn't show

10-Apr-2010 Matias
+ [#20050] Add new integration classes: Activity for CB
^ [#15886] Merged revision 2192 from /branches/1.6-xillibit-fixing with some changes
# [#19288] Fix regression: Search function is not working
# [#19288] Fix regression: Registered user is shown login screen if he does not have permissions to post

10-Apr-2010 Xillibit
# [#20100] Rules and help tabs is always displayed even if the settings are changed
# [#19288] Fix regressions in profile, use now new function for unfavorite and unsubscribe

9-Apr-2010 Matias
+ [#20050] Add new integration classes: Activity for JomSocial, AUP, None
# [#19288] Fix regression: Fixed JomSocial integration detection
^ [#19295] Clean up code: Removed all integration code from posting
^ [#15886] Merged revisions 2142-2160 from /branches/1.6-xillibit-fixing
# [#19288] Fix regression: HTML escaped in message and signature (func=view)

8-Apr-2010 Xillibit
# [#19288] Fix regression with profilebox in top Notice: Undefined property: CKunenaViewMessage::$textpersonal
# [#19288] Fix regression Notice: Undefined property: KunenaUser::$catid in \libraries\user.php  on line 242
# [#19288] Fix regression with AUP Notice: Undefined property: CKunenaViewMessage::$db in funcs\view.php  on line 143
^ [#19356] Replace karmaminus and karmaplus icons by icons in png

8-Apr-2010 Matias
# [#19288] Fix regression: not all $kunena_config parameters were removed from the code

7-Apr-2010 Matias
^ [#19448] Move code out of template: simplify func=view
^ [#19295] Clean up code: remove $kunena_config parameter from CKunenaLink functions

6-Apr-2010 Matias
+ [#20050] Add new integration classes: Avatar and Profile for AUP
+ [#20050] Add new integration classes: Make them configurable
+ [#20050] Add new integration classes: Profile for None
# [#19288] Fix regression: Sub-Categories are not showing up on showcat
# [#19288] Fix regression: Regular users couldn't post / edit messages
# [#19288] Fix regression: Improve user existance detection in KunenaUser
# [#19288] Fix regression: Toggler (show/hide) did not work
- [#19293] Remove deprecated configuration options: discussbot, showlatest, latestcount, latestcountperpage, latestsinglesubject, latestreplysubject, latestsubjectlength, latestshowdate, latestshowhits, latestshowauthor

5-Apr-2010 Matias
# [#20020] Total users number count also disabled users (from K1.5.12)
# [#19288] Fix regression: Restore old behaviour to report emails (send always to mods/admins)
^ [#15886] Merged revisions 2142-2160 from /branches/1.6-xillibit-fixing with some changes
^ [#15886] Merged revision 2154 from /branches/1.6-810

3-Apr-2010 Xillibit
^ [#20050] Fix somes missing things in stats API
# [#19288] Fix regression when you try to log in kunena with a new user
^ [#19356] On profilebox when you have pm enabled and AUP enabled the icons are misplaced

2-Apr-2010 Xillibit
^ [#20050] Stats API finished and frontstats leverages API methods

2-Apr-2010 810
# [#19288] Fix regression: Bug bbcode in internet explorer, changed the class name into kunenaclass in lib/bbcode.js.php

2-Apr-2010 Matias
# [#19288] Fix regression: Break compatibility (white screen) with older GroupJive releases

1-Apr-2010 Matias
# [#20071] KunenaRoute: Add support for default page, fix bug where wrong Itemid got selected
# [#20071] Routing: Add new option &post=new for new topics
# [#20071] KunenaMenu: Change New Topic to use &post=new (fixes suboptimal Itemid in routing)
^ [#20071] Simplify redirect and error handling for empty or illegal func
# [#20071] Routing: alter it to take account all variables in menu item, simplify logic
# [#19288] Fix regression: cannot post, reply topics
^ [#15886] Merged revisions 2124-2133 from /branches/1.6-xillibit-fixing with some changes
# [#19288] Fix regression: Session was not updated in API, causing sql query to fail
^ [#20050] Finish profile integration, remove deprecated code, fix some bugs

31-Mar-2010 Xillibit
# [#19288] The message subject in RSS have slashes
# [#19288] When you set profilebox in top or bottom position, the online image is misplaced
# [#19288] When the user choose last post first in his profile, this has no effect
+ [#19764] Add configuration setting to allow the user let the ghost message box checked or not
^ [#19395] Leverage of a better captcha plugin instead of the crappy thing

31-Mar-2010 Matias
+ [#20050] Add new integration classes: Profile for None, Kunena, CommunityBuilder, JomSocial
+ [#20071] KunenaRoute: make Kunena to find best possible Itemid
+ [#20071] KunenaRoute: Fix bugs in router.php, add support for intelligent routing
^ [#20071] KunenaRoute: Use KunenaRoute::_($url) in CKunenaLink, remove &amp;
# [#20071] KunenaRoute: Fix menuitems to be Joomla compatible
# [#19288] Fix regression: Bugs in Kunena user classes
# [#19288] Fix regression: Anonymous users had users avatar in view

30-Mar-2010 Xillibit
# [#19872] Externals urls in some places are considered like local urls
# [#19764] Delete attachments now delete from old locations
# [#19288] When you use quote function with content with double quote, it's showed in html in editmode
# [#19288] Quick reply function doesn't work, it need that you enter a name
+ [#20050] Add stats functions in API

29-Mar-2010 Matias
+ [#20050] Add new integration classes: Login/Registration for None, CommunityBuilder, JomSocial
+ [#20050] Add new integration classes: Avatar for None, Kunena, CommunityBuilder, JomSocial
# [#19288] Fix regression: Fixed many bugs in KunenaUser class
+ [#20050] Add new integration classes: Private for None, CommunityBuilder, JomSocial, UddeIM

29-Mar-2010 Xillbit
# [#19764] Fix small typo with button move message which doesn't diplay the icon
# [#19358] Fix an issue which prevent to display the poll under some conditions
# [#19764] Some fixes on moderation.class and functions which use this class
# [#20044] Undefined property: CKunenaPost::$email on components\com_kunena\template\default\editor\form.php on line 97

28-Mar-2010 Matias
+ [#20038] Add basic Joomla 1.6 support (no installer, no acl)
# [#20038] Add basic Joomla 1.6 support: use new format in language files
+ [#20039] Add kimport(), new location for libraries and static KunenaFactory class
^ [#20038] Add basic Joomla 1.6 support: move (C)KunenaSession and (C)KunenaUser to libraries
^ [#20038] Add basic Joomla 1.6 support: move access control to KunenaAccess in libraries
+ [#20038] Add basic Joomla 1.6 support: new KunenaIntegration classes, use them for login
# [#19288] Fix regression: Prune forums complains of missing CKunenaTimeformat class
# [#19288] Fix regression: First message in topic missing in func=view
# [#19288] Fix regression: CommunityBuilder profile integration did not fill all the fields
^ [#15886] Merged revisions 2098-2103 from /branches/1.6-xillibit-fixing
# [#19288] Fix regression: Do not mess up Joomla template (local css rules)
# [#19064] Add new bbcodes: Simple working implementation of MAP with external link
+ [#19064] Add new bbcodes: article tag pointing to com_content articles

27-Mar-2010 Xillibit
# [#19764] Fix undefined variables in post.php for merge function when there is only one thread in a cat
^ [#19764] For merge/slpit functions you can directly put the target thread/cat ID instead of search in a long list
^ [#19764] Add in split the possibility to split the actual message and newer messages (doesn't work)

25-Mar-2010 Xillibit
^ [#19764] Add the move function for one message
# [#19288] Fix regression - Fatal error: Class 'JMailHelper' not found in kunena.posting.class.php
^ [#20002] Do not allow moderator to move threads into sections
^ [#19764] Add in profile bulkaction the delete favorite and subscription functions
+ [#20021] Add few options to moderate user

21-Mar-2010 Xillibit
# [#19978] BUG: Editing posts containing quotation marks
# [#19983] Side-by-side preview is not side-by-side
# [#19825] BUG: Redirection on "Mark forum read" fails
^ [#19995] Remove favorites and subscriptions if thread gets deleted/merged (need testing)

21-Mar-2010 Matias
# [#19288] Fix regression: Subscription emails not sent, small bug in posting

20-Mar-2010 Matias
^ [#19277] Clean up and restructure post.php: Use class CKunenaPosting to post/reply message
^ [#19277] Clean up posting: remove deprecated code

18-Mar-2010 Matias
# [#19288] Fix regression: Typo in session handling
# [#19288] Fix regression: Circular class reference does not work with APC
^ [#19277] Clean up and restructure post.php: Use class CKunenaPosting to edit message

17-Mar-2010 Matias
# [#19288] Fix regression: Make CAPTCHA to work again
# [#19295] Clean up code: Improve session handling and fix access for global moderators

16-Mar-2010 Matias
^ [#19277] Clean up and restructure post.php: Make it a class in functions directory
^ [#19277] Clean up and restructure post.php: Split code into functions
^ [#19277] Clean up and restructure post.php: Move all html to the templates (editor & moderate directories)
^ [#19277] Clean up and restructure post.php: Move all code out from the templates
# [#19277] Clean up and fix many misc bugs in funcs/post.php

15-Mar-2010 Matias
- [#19383] Revise Profile Page: remove old profile code
# [#19954] Admin: Differentiate sections from categories, default new category parent to the first section
# [#19654] Edit category: allow public access to be changed to nobody
+ [#19956] Allow anonymous posts from registered users in special categories
+ [#19956] Allow anonymous also in Quick Reply
# [#19288] Fix regression: Do not show reply/quote for hidden posts

14-Mar-2010 Matias
^ [#19383] Revise Profile Page: Save all user information in a single form
^ [#19383] Revise Profile Page: Clean up changing avatar
+ [#19383] Revise Profile Page: Obey configuration

13-Mar-2010 Xillibit
^ [#19383] Make working the various actions for saveavatar, always an issue with avatar uplaoding

12-Mar-2010 Matias
^ [#19383] Revise Profile Page: Add parameters to edit user account
+ [#19383] Revise Profile Page: Add galleries to avatar tab

11-Mar-2010 Matias
^ [#19383] Revise Profile Page: Combine all edit actions under tabs
^ [#19383] Revise Profile Page: Fix layout for edit tabs

10-Mar-2010 Matias
# [#19288] Fix regression: User gender, birthdate, location and website missing from message info
# [#19233] Show Kunena login screen to visitors, if forum is for registered users only
^ [#15886] Merge revisions 2022-2032 from /branches/1.6-xillibit-fixing
- [#19383] Revise Profile Page: cleanup
# [#19380] Many fixes to CKunenaImage, CKunenaAttachments
# [#19383] Fix avatar upload, other logic still missing

10-Mar-2010 Xillibit
+ [#19383] Revise Profile Page: re-write page for edit joomla! and details, forum settings and avatar

07-Mar-2010 Xillibit
^ [#19764] Make moderation part in profile working almost (part 2)
# [#19764] Uncomment the function list_users() in userlist.php, add sortable, put new icons for users search

7-Mar-2010 Matias
^ [#19383] Revise Profile Page: Layout fixes

06-Mar-2010 Xillibit
# [#19649] Put error message when something goes wrong when user delete own post
# [#19764] Some fixes on CKunenaModeration class
^ [#19764] Make moderation part in profile working almost

05-Mar-2010 Xillibit
# [#19764] Fix delete the user from kunena table instead of put empty content
^ [#19764] Put the edit time check into a function in CKunenaTools
+ [#19649] Allow user to edit post while he can edit it

05-Mar-2010 Matias
+ [#19383] Revise Profile Page: added Posts tab

04-Mar-2010 Xillibit
# [#19764] Fix regressions in CKunenaModeration on undefined variable session
# [#19764] Fix undefined variable in post.php line 893
# [#19764] Fix wrong language string for merge in post.php
# [#19288] Fix regression - normal user can not go into read more for the announcement
# [#19764] Put auto-redirect when decreasing/increasing karma

04-Mar-2010 Matias
^ [#15886] Merge latest changes /branches/1.6-xillibit with some fixes and changes (not tested, may contain regression)

01-Mar-2010 Xillibit
+ [#19764] Add user blocking/unblocking functions in kunena users managers like in the j! user managers

28-Feb-2010 Xillibit
^ [#19764] Make split working with CKunenaModeration class
+ [#19607] Add option do hide user profile and information

27-Feb-2010 severdia
+ [#19356] New icons

27-Feb-2010 fxstein
+ [#19380] Extended upload (part 7) display existing attachments in edit mode
^ [#19380] Renamed KImage to CKunenaImage
+ [#19380] Additional AJAX translation strings
+ [#19380] New Ajax helper to delete/remove attachments by author/moderator/admin

27-Feb-2010 Xillibit
^ [#19764] Make merge working for one message and put things for split
+ [#19764] Add functions to logout an user and to delete an user from kunena user manager

26-Feb-2010 severdia
+ [#19356] New inactive icons

26-Feb-2010 Xillibit
^ [#19764] Make working move in message, and bulk delete/move with CKunenaModeration class
^ [#19764] Make working merge for complete thread only with CKunenaModeration class

26-Feb-2010 Matias
+ [#19356] New default rank, used also for visitors
+ [#19356] New greyed out social/message icons (logic)
+ [#19770] API: Implemented most of Kunena, KunenaUserAPI classes

26-Feb-2010 fxstein
+ [#19380] Extended upload (part 6) support gif, png in addition to jpeg; square thumbnails
^ [#19380] Display multiple attachments in a single row - shorten filenames to fit

25-Feb-2010 fxstein
+ [#19380] Extended upload (part 4) filesize display and filename shortener
+ [#19380] Extended upload (part 5) new KImage class

25-Feb-2010 Xillibit
+ [#19332] Change Delete behavior - add search function and now delete attachments with CKunenaModeration on kunena_attachments
+ [#19807] Add in search options, the options to search in trash for moderators
^ [#19764] Make delete a post and delete a thread in message using CKunenaModeration working in frontend

24-Feb-2010 severdia
+ [#19356] New rank image

24-Feb-2010 Matias
^ [#19380] Multi attachments: Plupload upgraded to version 1.1 (but is disabled for now)

24-Feb-2010 severdia
# [#19356] Random CSS fixes for UI
+ [#19356] New greyed out social/message icons (needs logic)

24-Feb-2010 fxstein
+ [#19380] Extended upload (part 2) automatic resize
+ [#19380] Extended upload (part 3) automatic thumbnail creation and display

24-Feb-2010 Xillibit
^ [#19764] Make delete and move functions in CKunenaModeration class functionnals (not fully tested)

23-Feb-2010 Xillibit
+ [#19764] Block/Unblock User in Admin Backend - trash all messages, move to categories and iplog implemented in backend

23-Feb-2010 severdia
^ [#19356] New PM icon
+ [#19380] New attachment CSS styles

23-Feb-2010 fxstein
+ [#19380] New MIME imagetype attachment config option
+ [#19380] New upload file processing based on config option
+ [#19380] Extended upload config options (part 1)

22-Feb-2010 fxstein
+ [#19774] New template loader helper: CKunenaTools::loadTemplate()
+ [#19380] New attachments template (scaffolding)
+ [#19295] Add svn:keywords Id to all new files
+ [#19380] New imagetype attachment config option

22-Feb-2010 Matias
# [#19288] Fix regression: New attachment table broke installation, upgrade works
+ [#19770] Add external API for other components: added api.php
# [#19288] Fix regression: New attachment table broke latestx, showcat, post
+ [#19770] Add external API for other components: added interfaces for user, forum and post

21-Feb-2010 Xillibit
# [#19288] Fix regression: Notice: Use of undefined constant _ANN_EDIT - assumed '_ANN_EDIT' in announcement.php
# [#19288] Fix regression: Notice: Undefined variable: kunena_config in admin.kunena.html.php on line 480
# [#19288] Fix regression: wrong type for the folder field in kunena.install.upgrade.xml for create jos_kunena_attachments
# [#19288] Fix regression: CKunenaTables doesn't check the table jos_kunena_attachments
# [#19690] Add configuration report system in Kunena backend - display kunena configs settings in a table and check for each kunena table which is in utf8
^ [#19358] Display the poll icon only on the first message of the thread
^ [#19358] Take care a bit of Class kunena.moderation.class.php
# [#19668] Show the checkbox for select all the checkboxes only for moderators

21-Feb-2010 severdia
^ [#19758] Clean up admin interface, language fixes

21-Feb-2010 Matias
^ [#19758] Clean up admin interface: move logo to toolbar, change emoticons path etc..
^ [#19758] Clean up admin interface: make logo a bit larger
^ [#19380] Multi attachments: Add basic old style attachments with some JavaScript for backup
# [#19380] Multi attachments: Try to make it to work with Chrome

20-Feb-2010 severdia
^ [#19758] Clean up admin interface, add tabs struture (still needs tab JS)

20-Feb-2010 Matias
# [#19288] Fix regression: Only the first rank image works (wrong url)
+ [#19380] Multi attachments: use new folder, add to database and assign to message

20-Feb-2010 fxstein
+ [#19380] Basic attachments display scaffolding added with sample display data
^ [#19380] Minor changes to attachments upgrade logic
+ [#19380] Multi attachments database integration for messages view

19-Feb-2010 fxstein
^ [#19380] Modified attachments table to support legacy folder structure

19-Feb-2010 Matias
^ [#19690] Rename bbcode [mod] to [confidential] and make small changes to it's logic

18-Feb-2010 Matias
# [#19399] Fixed undefined variable in RSS code

18-Feb-2010 fxstein
^ [#19399] Changed remaining _LISTCAT_RSS occurances to JText
^ [#19312] Changed "Posted at" to "Posted" in language file
+ [#19380] Create new attachment table for advanced multi attachment handling

18-Feb-2010 Matias
# [#19380] Multifile upload: Fixed fixed path to silverlight, flash runtimes

17-Feb-2010 fxstein
+ [#19399] merged new RSS code (part 1 - intial merge from littlejohn branch)
^ [#19399] merged new RSS code (part 2 - language string corrections)
+ [#19399] merged new RSS code (part 3 - dedicated section for RSS settings)
- [#19399] merged new RSS code (part 4 - remove security bypass)

17-Feb-2010 severdia
^ [#19345] Added new styles for pagination, but still needs correct output

17-Feb-2010 Matias
^ [#19345] Restyle Default template: pagination
^ [#15886] Merge latest changes /branches/1.6-xillibit, added minor fixes
# [#19380] Multifile upload: Fixed logic for gears, silverlight, flash uploads

17-Feb-2010 Xillibit
+ [#19690] Add configuration report system in Kunena backend - add new bbcode [mod][/mod] for show content only for mods and admins

15-Feb-2010 Xillibit
+ [#19668] Add parser logic for map

14-Feb-2010 Matias
^ [#19380] Multifile upload: Working logic for html5 uploads (not saved into DB yet)

14-Feb-2010 severdia
# [#19356] More CSS fixes and reworked Report to Mod page

13-Feb-2010 severdia
# [#19356] More CSS fixes for default Joomla templates

13-Feb-2010 Matias
^ [#19380] Multifile upload: Yet another try with plupload 1.0 (supports flash, html5 etc)

13-Feb-2010 Xillibit
# [#19332] Change Delete behavior - add sortables on all items
^ [#19358] Apply some changes on the polls - wrong path for bar.png, remove url in javascript for vote

12-Feb-2010 Xillibit
# [#19690] Add configuration report system in Kunena backend - add function to select all text, add two configurations settings

12-Feb-2010 severdia
# [#19356] CSS fixes for Afterburner

12-Feb-2010 Matias
# [#19288] Fix regression: AJAX Upload broke up during merge

10-Feb-2010 Xillibit
+ [#19690] Add configuration report system in Kunena backend

08-Feb-2010 littlejohn
+ [#19399] New RSS feeds (part 5 - added frontend view and rss class)
- [#19399] New RSS feeds (part 4 - removed old frontend)
# [#19399] New RSS feeds (part 3 - removed trailing space from parser affecting all templates)
^ [#19399] New RSS feeds (part 2 - changed and corrected administrative options)

08-Feb-2010 Xillibit
# [#19332] Change Delete behavior - fixes to solve an issue in trash manager and now put the poll deletion in trash manager

07-Feb-2010 Xillibit
# [#19631] Re-implement quick reply by using mootools - fix a bug which create new threads instead replies
+ [#19668] Re-implement bulkactions with mootools
+ [#19668] Write javascript logic for video in editor

07-Feb-2010 severdia
# [#19356] CSS fixes, rounded tabs (CSS3 only)

07-Feb-2010 Matias
# [#19288] Fix regression: New installation did not work because of old sample data
# [#19288] Fix regression: Missing language strings in installer and in backend
# [#19288] Fix regression: Create menu item: Kunena cannot be selected
# [#19288] Fix regression: Upgrade failed if configuration did not exist

07-Feb-2010 severdia
# [#19312] Language fixes (thanks again to kmilos)

06-Feb-2010 severdia
+ [#19312] Checkbox for check toggle
# [#19356] CSS fixes

05-Feb-2010 fxstein
^ [#19345] Display page creation time in footer
+ [#19251] Jomsocial user prefetch caching to reduce query counts - showcat
! [#19657] Merge latest branch provided by xillibit

05-Feb-2010 Xillibit
# [#19631] Re-implement quick reply by using mootools - little changes
# [#19288] Fix regression - remove deprecated $mainframe put in trash manager

04-Feb-2010 Xillibit
^ [#19639] Add form-validation instead alert
# [#19639] Add form-validation instead alert - some fixes on this, now work like it should

04-Feb-2010 fxstein
^ [#19345] Re-style child board counts to match new template
^ [#19645] More language conversion changes
+ [#19345] Display page creation time in footer
- [#19634] Shorten Changelog to 1.6 changes

04-Feb-2010 severdia
# [#19312] Language fixes (thanks to kmilos)

04-Feb-2010 Matias
# [#19288] Fix regression: Posting new message did not work
# [#19561] Fix poll ajax calls: broken SQL, only first element got matched in JS
# [#19380] Many small fixes to the editor ajax calls (language strings, error handling)
^ [#19645] Convert Language files to native Joomla 1.5/6 ini's
^ [#19645] Convert all language strings to use JText::_()
# [#19645] Fix missing quotes from language strings, use new language files

03-Feb-2010 Xillibit
+ [#19631] Re-implement quick reply by using mootools

03-Feb-2010 Matias
# [#19251] Advanced special user prefetch: bugfix
# [#19380] Multifile upload: didn't work while editing a post
- [#19293] Remove deprecated PM Systems: mypms, missus, jim
- [#19295] Clean up code: remove unused code in kunena.php + PMS options
# [#19288] Fix regression: Installer does not work

03-Feb-2010 fxstein
+ [#19251] Jomsocial user prefetch caching to reduce query counts
^ [#19634] Update package file name for internal night build

03-Feb-2010 littlejohn
^ [#19399] New RSS feeds (part 1 - adding administrative options)

02-Feb-2010 fxstein
+ [#19251] Advanced special user prefetch caching to reduce query counts

02-Feb-2010 Matias
+ [#19380] Multifile upload: upload files to server by using iframe (part 2)
# [#19624] Improve sending moderator/subscription mail (check email addresses, cleanup contents, etc)
- [#19380] Multifile upload: no more Fancy Upload

01-Feb-2010 fxstein
^ [#19236] Revert category overlay colors
# [#19356] Center menu tabs and make spacing font size relative
+ [#19380] Multifile upload (part 1)

01-Feb-2010 severdia
# [#19356] Random CSS fixes for UI

31-Jan-2010 severdia
+ [#19383] Added uknown gender icon/option
+ [#19356] Moved icons to proper folders, new icons
+ [#19356] More new icons

31-Jan-2010 Matias
+ [#19383] Revise Profile Page: added Started Topics and Posted Topics tabs
+ [#19383] Revise Profile Page: show users post count
^ [#19598] Make topic icons configurable in icons.php
# [#19278] Keep topic icon after editing message (make it better)
+ [#19383] Revise Profile Page: hide moderation from myself, regular users
^ [#19383] Revise Profile Page: fix unknown location, gender
# [#19288] Fix regression: Pending messages query
# [#19288] Fix regression: undefined variable during posting
+ [#19599] Moderators should be able to see unapproved messages while reading thread and approve them

31-Jan-2010 fxstein
+ [#19592] Add JFirePHP support
+ [#19592] Add initial profiling info via JFirePHP
+ [#19592] Implement KProfiler

31-Jan-2010 severdia
# [#19356] Added missing social icons, new topic icons
# [#19356] Added CSS for red forum suffix

30-Jan-2010 Xillibit
# [#19561] Put the poll form into the new editor - little changes

29-Jan-2010 fxstein
^ [#19561] Poll ajax interface naming changes

28-Jan-2010 Xillibit
# [#19561] Put the poll form into the new editor - poll options doesn't saved when you edit a post

28-Jan-2010 fxstein
# [#19380] Preliminary video option submenu
+ [#19380] Include fancyupload libraries in project

27-Jan-2010 Xillibit
^ [#19561] Put the poll form into the new editor

27-Jan-2010 fxstein
# [#19356] Fix html regression in message.php
# [#19380] Implement new resize function and modify preview css

26-Jan-2010 severdia
# [#19380] Fixed preview splitter

26-Jan-2010 fxstein
+ [#19380] New insert link function, added poll icon to toolbar
+ [#19380] New insert image link function, new help button and function pointing at our wiki
+ [#19380] Basic split screen preview support added to bbcode editor
+ [#19380] Automatic preview update on change (every 1000ms) added
^ [#19380] Redo preview layout to use a simple div - not table
^ [#19380] Revert poll changes for now

26-Jan-2010 severdia
# [#19356] Reworked profile area on posts

26-Jan-2010 Matias
# [#19288] Fix regression: Broken/missing queries during upgrade
# [#19288] Fix regression: undefined variables, minor bugs
# [#19251] Reduce the number of SQL calls in view
# [#19448] Move code out of template: smile.class.php
- [#19295] Clean up code: remove unused code (plugins/profiletools, plugins/emoticons)
# [#19397] Fix date format in Kunena: use user/site timezone, keep saving with internal time
^ [#19345] Restyle Default template (view): remove viewcovers, change logic from online status
+ [#19303] Add new social icons to profile: ICQ, MSN
^ [#19380] Replace jQuery with Mootools 1.2: convert remaining togglers

26-Jan-2010 Xillibit
^ [#19023] Text filtering not working for title, done in every places

26-Jan-2010 @quila
^ [#19288] Fix regression - remove js folder from manifest.xml

25-Jan-2010 severdia
# [#19356] New icons, removed English folder in images (moved images up one level), refined forum colors

25-Jan-2010 Xillibit
^ [#19395] Add better captcha support with recaptcha - don't show the html tables if the puglin is unpublished, rewrite of language strings
^ [#19288] Fix regression - remove one extra query added in kunena.login.php

25-Jan-2010 fxstein
+ [#19380] New bbcode editor (part 5) - New font size selector, refactor color selector
^ [#19380] Modified text alignment and line heights for text size selector
+ [#19539] Add image sources to svn
+ [#19380] Additional bbcode editor toolbar icons

25-Jan-2010 Matias
# [#19448] Move most of the html from lib/ to default template
# [#19316] Fix remaining double SQL calls, add checks for failed queries

25-Jan-2010 @quila
+ [#19359] Color Code moderator and admin username - different css classes to moderator and admin usernames.

24-Jan-2010 Xillibit
+ [#19395] Add better captcha support with recaptcha (http://www.joomlaez.com/joomla-plugins/joomla-captcha-solution.html)
^ [#19395] Add better captcha support with recaptcha - delete old plugin captcha and set the captcha language which depends of joomla! language

24-Jan-2010 fxstein
+ [#19380] New bbcode editor (part 4) - All alt, title and helptext strings and conditionals added
^ [#19380] New bbcode editor (part 5) - Integrate and refactor base class and java script

24-Jan-2010 @quila
+ [#19233] Add Kunena Login into the new default template

23-Jan-2010 fxstein
+ [#19380] New bbcode editor (part 3) - All Smilies added, message name regression fixed

23-Jan-2010 Matias
# [#18974] Categories and sections mixed up
# [#19253] Do not allow forum parent to be it's own child
^ [#19295] Clean up code: use always new profile, improvements on moved topics
# [#19035] Call to undefined method JDocumentRAW::addCustomTag()
# [#19376] attach file when the file have is extension in capital letters, exemple : myfile.JPG doesn't work
- [#19293] Remove deprecated configuration options: default_view, numchildcolumn, cb_profile

23-Jan-2010 Xillibit
# [#19486] Remove all: die ("Hacking attempt");

22-Jan-2010 fxstein
+ [#19380] New bbcode editor (part 2) - All buttons added as css sprite

22-Jan-2010 Xillibit
^ [#19485] Add AJAX call to check if polls are allowed if category changes

21-Jan-2010 fxstein
+ [#19380] New bbcode editor (part 1)
^ [#19380] New Joomla 1.5.16 / 1.6 style framework bahvior; remove secondary mootools 1.2 libraries

21-Jan-2010 Xillibit
^ [#19332] Change Delete behavior - show in backend too the posts wrote by visitors and sortable list on the title
^ [#19066] Make jomSocial Activity stream integration configurable

20-Jan-2010 Matias
^ [#19295] Clean up code: merge showcat subcategories code with listcat
# [#19251] Do not query SQL for new topics when the information isn't used (latestx, showcat)
# [#19383] Make subscriptions and favorites to work better inside Profile page
# [#19288] Fix regression in showcat: There are no forums in this category!

20-Jan-2010 Xillibit
^ [#19358] Apply some changes on the polls - publish or unpublish a category allowed for polls directly in forum administration

20-Jan-2010 fxstein
^ [#19380] Drop jQuery; rewrite bbcode editor functions using mootools
^ [#19380] Change emoticon to color in preview
^ [#19380] Hide preview section when not active - display and grow on demand
+ [#19295] Add missing index.php files
^ [#19295] Move bbcode editor into seperate file: editor/bbcode.php
+ [#19295] Add svn:keywords Id to all new files

19-Jan-2010 svens LDA
# [#19339] Incorrect implementation of links in CKunenaLink class - Part 3

19-Jan-2010 Matias
# [#19288] Fix regression: add missing directories to manifest.xml
# [#19288] Fix regression: missing info in showcat
^ [#19295] Clean up code: latestx, flat, part of showcat, fix warnings
+ [#19383] Revise Profile Page: add rough version of favorites, subscriptions
- [#19295] Clean up code: remove plugins/fbprofile

19-Jan-2010 fxstein
# [#19358] Fix incorrect install file logic, add upgrade step and cleanup prior changes.
- [#19380] Remove Chili code high lighter as part of transition to mootools

19-Jan-2010 Xillibit
^ [#19234] Hide IP addresses from Moderators - add configuration option in backend
^ [#19358] Apply some changes on the polls - set the categories allowed for polls in forum administration
^ [#19358] Apply some changes on the polls - fix a regression introduced when you post a new thread
# [#19252] Fix slow SQL queries in RSS feed
^ [#19358] Apply some changes on the polls - fix a regression introduced when you post a new thread (part 2)

18-Jan-2010 fxstein
+ [#19067] Add messages in registered only categories to jomsocial activity stream and set access control
^ [#19479] Enable upgrade logic to work in Joomla debug mode

18-Jan-2010 Matias
^ [#19448] Move code out of template: listcat
# [#19251] Reduce the number of SQL calls in listcat

18-Jan-2010 Xillibit
^ [#19358] Apply some changes on the polls - rewrite the javascript to use mootools

18-Jan-2010 severdia
# [#19356] Change CSS and reorder fields on Recent Topics
# [#19356] Cleaned up Profile page, new generic/online buttons, fixed language strings

17-Jan-2010 fxstein
+ [#19244] Ajax/json support class scaffolding; intial autocomplete on moderation page
+ [#19244] Finished initial version of Ajax/json support class; autocomplete on moderation and search
# [#19470] Incorrect user count in stats module - included blocked users

17-Jan-2010 Matias
^ [#19243] Make profile on left/right/top/bottom configurable - move files to their new places
^ [#19448] Move code out of template: showcat - subcategories
# [#19251] Reduce the number of SQL calls in showcat - subcategories

17-Jan-2010 @quila
+ [#19243] Make profile on left/right/top/bottom configurable - Part 2

16-Jan-2010 svens LDA
# [#19339] Incorrect implementation of links in CKunenaLink class
- [#19455] Remove depriciated code in smile.class.php

15-Jan-2010 severdia
# [#19356] Reworked CSS and synced colors and fonts, added palette to CSS header, minor language string fixes

15-Jan-2010 Matias
# [#19447] Deleted messages sometimes showing up in latestx
^ [#19448] Move code out of template: view
# [#19288] Fix regression: cannot view messages if user has been deleted
^ [#19303] Social network icons: Allow values to be put anywhere in URL by using ##VALUE##
^ [#19448] Move code out of template: latestx, showcat

15-Jan-2010 Xillibit
# [#19288] Fix regression after namming changes on move/delete in class.kunena.php
# [#19358] Apply some changes on the polls - fixes regressions detected after last changes on polls
+ [#19235] Add category info to search results
# [#19358] Apply some changes on the polls - fix one another regression on polls
# [#19278] Keep topic icon after editing message

14-Jan-2010 fxstein
^ [#19345] Refactor css class names 'fb' to 'k'
^ [#19437] Update copyright dates to 2010
# [#19397] Preliminary fix for post date issue
# [#19295] Clean up code: Update template chooser
+ [#19064] Add additional common bbcodes to purify
^ [#19438] SVN keywords Id set on all files missing it
+ [#19244] Moderation page scaffolding

14-Jan-2010 Xillibit
+ [#19332] Change Delete behavior - implemented in backend (part 1)
^ [#19332] Change Delete behavior - modfied the delete function in frontend (part 2)

14-Jan-2010 Matias
# [#19288] Fix regression: Undefined fbConfig in kunena.parser.php
# [#19295] Clean up code: Remove forumtools
# [#19295] Clean up code: Remove deprecated plugins/recentposts
^ [#19303] Add social network icons to profile: use layout from profile view
^ [#19295] Clean up code: Use new rank function in view.php

13-Jan-2010 louis
^ [#19380] Added show/hide behavior for statistics and whoisonline blocks.
^ [#19380] Added show/hide behavior for any block based on an a.toggler selector and rel attribute

13-Jan-2010 fxstein
+ [#19244] New moderator tools class added
^ [#19380] Change joomla menu for Kunena to reflect new profile url format
^ [#19425] Security hardening: defined( '_JEXEC' ) or die();
^ [#19345] Modified css class prefix logic
# [#18995] Undefined variables in message.php fixed

13-Jan-2010 Matias
+ [#19380] New profile page: forum/profile. Not yet activated in menu, links
# [#19397] Fix date format in Kunena, make it configurable

13-Jan-2010 Xillibit
# [#19103] Language strings should be escaped in javascript, added in myprofile and tested in write post
+ [#19232] Add option for message numbering

12-Jan-2010 severdia
+ [#19380] Add moderator tab to Profile page, new language strings
^ [#19380] Added JS slider links, needs testing

12-Jan-2010 Xillibit
# [#19288] Fix regression, waring in zend in myprofile_summary.php
^ [#19358] Apply some changes on the polls, allow the user to change her vote
# [#19358] Apply some changes on the polls, regression undefined catid in poll.php
^ [#19377] Allow the maxlength on the personnal text to be modified easily

12-Jan-2010 Matias
# [#19251] Reduce the number of SQL calls when showing frontstats
^ [#19295] Clean up: remove unused code (statsbar) and images
^ [#19295] Clean up: replace module positions by CKunenaTools::showModulePosition()
# [#19313] Minor fix for SVN installer: always run queries
# [#19288] Fix regression: Writing new topic possible without permissions

11-Jan-2010 severdia
# [#19380] Add tabs & code to JS file, profile page
# [#19380] Removed forum section minimizers in prep for MT version, fixed tabs on profile page

11-Jan-2010 Matias
# [#19064] Finalized new bbcodes: fixed preview
# [#19288] Fix regression: warnings in backend after css file moved
- [#19293] Remove deprecated configuration options: poststats, statscolor
# [#19251] Reduce the number of SQL calls in various views
# [#19251] Reduce the number of SQL calls in various views (router in showcat, latestx)
# [#19288] Fix regression: New topic without category not working

11-Jan-2010 fxstein
+ [#19064] Finalized new bbcodes: table, th, tr, td & module (for joomla modules)
^ [#19400] Changed subheader layout, reformated category listings
^ [#19064] Separate bbcode css

10-Jan-2010 svens LDA
# [#19339] Incorrect implementation of links in CKunenaLink class

10-Jan-2010 severdia
# [#19345] Stats page cleanup, Language string cleanup
^ [#19345] Moved smilies from side of new message screen to top, language strings fixed

10-Jan-2010 Matias
# [#19383] Revise Profile Page: remove deprecated functions, minor fixes
+ [#19356] New buttons: added logic to show new buttons
- [#19293] Remove deprecated configuration option: joomlastyle
# [#19032] Moderator moving topic from thread: forum order is wrong
+ [#19298] Add category selection pull down to New Thread
# [#19371] Fix router to accept the new menu items
# [#19288] Fix regression: Fix broken html, remove unused broken code

10-Jan-2010 severdia
^ [#19383] Redesigned profile page

10-Jan-2010 fxstein
# [#19358] Cleanup of polls backend to fix broken configuration
^ [#19371] Change default page behaviour - make it work with new Joomla menus
^ [#19345] Re-style default template: replace <p> with proper <div> in listcat.php
^ [#19369] Proper headers for all views
^ [#19369] Move secondary headers into <body> for proper styling

09-Jan-2010 severdia
# [#19356] Fixed search page accessibility, cleaner CSS
+ [#19356] JS for clickable checkbox fields
+ [#19380] Added Mootools in preparation to replace jQuery

09-Jan-2010 fxstein
+ [#19371] Auto generate joomla menu from control panel and during install
# [#19371] change componentid behaviour for created menus to support sef
^ [#19379] rename faq to help
+ [#19371] Language file strings for new menu creation logic
- [#19371] Remove leagcy menu code including layout.php

08-Jan-2010 810
+ [#19303] Add twitter, facebook to profile
^ [#19303] Add twitter, facebook to profile, edited the images

08-Jan-2010 Xillibit
^# [#19358] Apply some changes on the polls

08-Jan-2010 severdia
^ [#19356] New buttons, rank icons
^ [#19345] Re-style default template

08-Jan-2010 Matias
^ [#19345] Re-style default template: Search Tab
# [#19352] Own favorite star gray when many users have favorited the same topic

08-Jan-2010 fxstein
^ [#19345] Re-style default template
- [#19251] Remove unneeded query for modified posts
# [#19303] Fixed installer regression
^ [#19345] added new column for views in flat.php
+ [#19345] formatLargeNumber(): format numbers >10,000 to 10k >1,000,000 to 1m for various outputs
^ [#19345] proper col span and width for new view column in flat.php

07-Jan-2010 fxstein
+ [#19333] New datamodel table for category subscriptions
+ [#19333] New category subscriptions logic (w/o email notification)
+ [#19333] eMail notifications for New category subscriptions
^ [#19342] Cleanup redirect after post, avoid intermediate page

07-Jan-2010 Xillibit
# [#19029] If moderator edits the post, email address gets replaced

07-Jan-2010 Matias
# [#19316] Fix double SQL calls, add checks for failed queries
# [#18862] New thread is unread after posting it
# [#19288] Fix regression: session expired on every page load
# [#19321] Message text missing from moderator emails if there is no subscriptions
# [#18994] Email to moderators does not send email to global moderators
# [#19323] Flood protection should not block Subscribe and Favorite
# [#18903] Moderator and subscribed to topic: user will receive two emails
# [#19277] Clean up and restructure post.php, part 5: rewrote permissions checks during posting
# [#19029] If moderator edits the post, email address gets replaced (part 2)

06-Jan-2010 Matias
- [#19293] Remove deprecated configuration option: View=flat/thread (leftover code and cookie)

06-Jan-2010 fxstein
+ [#19313] SVN installer option added. Added control panel button to execute installer (only in SVN mode)
# [#19200] Fixed regression in check_dberror that would crash php server due to invalid recusion
# [#19241] A little love for our new polls. Cleaned up install/upgrade, added db checks to all sql
# [#19241] Added missing id and catid parameter definitions

06-Jan-2010 Xillibit
^ [#19241] Add code from kunena.special.upgrade.poll.php to kunena.special.upgrade.1.6.0.php
# [#19304] if Enable Help Page and Show help in Kunena is on no, has not effects on boardcode link
# [#19103] Language strings should be escaped in javascript
# [#19241] Fixes some little bugs in polls (part 2)
# [#19241] Fixes some little bugs in polls
+ [#19241] Add polls feature by applying changes from /branches/1.5-xillibit

05-Jan-2010 fxstein
+ [#19294] New module position: kunena_menu to allow custom Joomla menu to override default tabs
^ [#19236] Changed behaviour of category css suffix logic. Now adds new class to overide only specific features.
^ [#19289] Cleaned up and reformatted kunena.config.class.php
+ [#19289] New config validation function before save and after load to prevent unsupported values

05-Jan-2010 810
# [#19288] Fix some minor bugs on backend part 2
^ [#19295] Clean up and restructure backend

05-Jan-2010 xillibit
# [#19287] Modification for collect_smilies() and collect_ranks() - delete the index.php in display
# [#19287] Modification for collect_smilies() and collect_ranks()
# [#19234] Hide IP addresses from Moderators

05-Jan-2010 Matias
# [#19255] Fix XHTML validation errors while posting a message
# [#19277] Clean up and restructure post.php, part 2
# [#19277] Clean up and restructure post.php, part 3, fix attachments
^ [#16390] Update English language file, trim whitespaces
# [#19277] Clean up and restructure post.php, part 4, more fixes on posting
# [#19290] Bulk delete and move returns to main page
# [#19288] Fix regression: icons and emoticons conflict
# [#19288] Fix regression: PHP5.3 fix broke avatar upload
- [#19293] Remove deprecated configuration option: Word Wrap

05-Jan-2010 @quila
- [#19243] Make profile on left/right configurable - Revert change on message.php

04-Jan-2010 fxstein
^ [#19280] New standard "Registered Users Only" error message
+ [#19236] Updated colors: -green, -red, -orange, -blue, -grey & -pink for category css class suffix

04-Jan-2010 Matias
# [#19031] Quick reply shows > as &gt; in subject (part 2)
# [#19277] Clean up and restructure post.php and fix misc bugs

04-Jan-2010 @quila
+ [#19243] Make profile on left/right configurable

04-Jan-2010 Xillibit
# [#19107] Delete deprecated templates during install (part 2)
+ [#19107] Delete deprecated templates during install

04-Jan-2010 fxstein
# [#19257] Fixed regression: categories work again in backend

03-Jan-2010 severdia
# [#19255] Fixed validation errors. Now valid XHTML.

03-Jan-2010 fxstein
+ [#19236] Add css class suffix support for categories in various views
# [#18995] Undefined variables regression in pdf fixed
^ [#19250] Refactor remaining fb_xxxx files
- [#19254] Remove bottom forumjump dropdown
+ [#19236] Add category css class suffix predefines: -green, -red, -orange, -blue, -grey & -pink

03-Jan-2010 @quila
# [#19037] Add max avatar size into user profiles

03-Jan-2010 Xillibit
# [#18995] Undefined variables
# [#19080] Revert change on myprofile for configuration option "Show join date" has no effect

03-Jan-2010 Matias
# [#19043] Deprecated links to index2.php (part 2)
# [#15946] Fixed regression in: Super Admin in the User List

03-Jan-2010 810
# [#19229] User administration Adding an order + cleaned up
# [#19230] Fix some minor bugs on backend

02-Jan-2010 Matias
# [#19065] Removed many globals, fixed minor bugs
# [#19215] Remove redundant SQL in isModerator() calls

02-Jan-2010 810
+ [#19225] add hide images/files for guests
^ [#19225] add hide images/files for guests

02-Jan-2010 severdia
^ [#18780] Reformatted CSS files
# [#18780] Commented out errors. Both CSS files now validate at W3C

02-Jan-2010 fxstein
- [#19216] Removed Clexus PM integration
# [#19065] More frontend cleanup based on code analysis - fixed various bugs
# [#19065] cleaned up and reformatted myfprofile.php
+ [#19222] New feature: 'No Replies' tab added
# [#19065] final fix for warnings inside flat.php

01-Jan-2010 fxstein
# [#19065] fixed html bugs and warnings and reformatted flat.php
- [#19214] Removed patTemplate globally
# [#19065] Reformatted kunena.php
# [#19065] fixed html bugs and warnings and reformatted fb_write.php, post.php
# [#19065] cleaned up and reformatted views.php
# [#19065] cleaned up and reformatted pathway.php, showcat.php and view.php
# [#19065] cleaned up and reformatted recentposts.php
# [#19065] More frontend cleanup based on code analysis - fixed various bugs

01-Jan-2010 810
^ [#19213] rss image isn't always displayed in config backend
^ [#15946] Fix: Super Admin in the User List

01-Jan-2010 Matias
# [#19065] More frontend cleanup based on code analysis - fixed various bugs
# [#19065] Fixed bugs while posting caused by code cleanup
# [#19065] Remove a lot of unused or deprecated code as part of cleanup
# [#19065] Use JString instead of functions from PHP

01-Jan-2010 Xillibit
^ [#19200] Replace all trigger_dberror() or trigger_dbwarning()

31-Dec-2009 fxstein
# [#19065] More frontend cleanup based on code analysis - fixed various bugs

31-Dec-2009 Xillibit
# [#19201] Fix some php notice or fatal error on the trunk

29-Dec-2009 Matias
# [#19065] More frontend cleanup based on code analysis

28-Dec-2009 fxstein
# [#19065] More frontend cleanup based on code analysis - fixed various bugs

28-Dec-2009 Matias
# [#19065] More frontend cleanup based on code analysis - fixed various bugs

27-Dec-2009 Xillibit
# [#19031] Quick reply shows > as &gt; in subject

26-Dec-2009 fxstein
# [#19065] More frontend cleanup based on code analysis - fixed various bugs

25-Dec-2009 fxstein
# [#19065] More frontend cleanup based on code analysis - fixed various bugs

24-Dec-2009 Xillibit
# [#19030] URLs using HTTPS protocol are not working in img tag

24-Dec-2009 fxstein
+ [#19065] Add definitions of external functions (e.g. CB) to prevent warnings
# [#19065] Cleanup frontend based on code analysis - fixed various bugs

23-Dec-2009 Xillibit
^ [#18975] Backend: Show Avatar on Categories list option misleading
^ [#18902] Replace all remaining deprecated functions in PHP 5.3.x

23-Dec-2009 fxstein
^ [#19065] global rename of various kunena wide variables
^ [#19065] replaced depriciated split() with explode()
^ [#19065] remove depriciated new& construct
# [#19065] Fix regression: Missing backend menu and toolbar
# [#19065] Remove borken Joomla 1.5 dtd from manifest xml

22-Dec-2009 Xillibit
# [#19080] Configuration option "Show join date" has no effect

22-Dec-2009 fxstein
^ [#19090] Combine default and default_ex
# [#19065] Fix regression in uploaded files and images browser

21-Dec-2009 Xillibit
- [#19075] Remove group from userlist / user profile

21-Dec-2009 fxstein
# [#19086] Fix language file regression from 1.5.8
# [#19065] Cleanup backend html based on code analysis - fixed various bugs
# [#19065] Cleanup installer html based on code analysis - fixed various bugs
- [#19065] Removed backend plugin directory tree to remove warnings in unused code
# [#19065] Cleanup frontend based on code analysis - fixed various bugs
- [#19065] Removed old & unused split and merge code
- [#19065] Removed old & unused code in layout.php

20-Dec-2009 Matias
# [#19079] Fix broken layout with too long strings
^ [#18763] Update version info to 1.6.0-DEV

20-Dec-2009 fxstein
+ [#19064] new bbcodes for table, th, tr & td as well as module
# [#19065] fix various warnings and errors identified by zend studio code analysis
- [#19065] remove unsued kunena.pathway.old.php as part of cleanup

19-Dec-2009 Matias
^ [#15886] Merge from /branches/1.5-xillibit:1254-1256,1303-1307,1312-1313

18-Dec-2009 Xillibit
^ [#19033] User list and count shows also disabled users
^ [#19040] Most viewed profiles should use profile integration
# [#19043] Deprecated links to index2.php

17-Dec-2009 Xillibit
^ [#18767] Conflict with sh404sef language strings
# [#19027] Debug does not show MySQL error in trace
# [#19025] Moderators list is always using username, regardless of configuration option
# [#19026] Administration: wrong translations
# [#19022] Moderation: Merge shows extra slashes in topic list
# [#18973] Wrong My profile link in AUP integration

05-Dec-2009 Xillibit
# [#18902] Fixes for all remaining deprecated warning with PHP 5.3.x and remove split() and ereg() functions

04-Dec-2009 Xillibit
# [#18902] Fixes for deprecated warning with PHP 5.3.x and deprecated usage of split() functions
-->