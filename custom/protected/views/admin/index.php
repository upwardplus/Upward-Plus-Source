<?php
/* * *********************************************************************************
 * X2CRM is a customer relationship management program developed by
 * X2Engine, Inc. Copyright (C) 2011-2016 X2Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2ENGINE, X2ENGINE DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. P.O. Box 66752, Scotts Valley,
 * California 95067, USA. on our website at www.x2crm.com, or at our
 * email address: contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 * ******************************************************************************** */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/views/admin/index.css');

ThemeGenerator::removeBackdrop();

$admin = &Yii::app()->settings;

$loginHistoryDataProvider = new CActiveDataProvider('SuccessfulLogins',
        array(
    'sort' => array('defaultOrder' => 'timestamp DESC'),
        ));
$failedLoginsDataProvider = new CActiveDataProvider('FailedLogins',
        array(
    'sort' => array('defaultOrder' => 'lastAttempt DESC'),
        ));
?>

<div class="spanMax cell admin-screen">

    <?php //echo Yii::t('app','Welcome to the administration tool set.'); ?>
    <?php
    if (Yii::app()->session['versionCheck'] == false && $admin->updateInterval > -1
            && ($admin->updateDate + $admin->updateInterval < time()) && !in_array($admin->unique_id,
                    array('none', Null))) {
        echo '<span style="color:red;">';
        echo Yii::t('app',
                'A new version is available! Click here to update to version {version}',
                array(
            '{version}' => Yii::app()->session['newVersion'] . ' ' . CHtml::link(Yii::t('app',
                            'Update'), 'updater', array('class' => 'x2-button'))
        ));
        echo "</span>\n";
    }
    ?>
    <div class="form x2-layout-island license-info-section">
        <div class="row" style="margin-left: 0px;">
            <div class='cell span-10'>
                <b>Upward Plus+ - Small Business Accelerated</b><br>
            </div>
            <div class='cell span-9'>
                <b><?php echo Yii::t('app', 'Version') . " " . Yii::app()->params->version; ?></b><br>
            </div>
        </div>
        <div class="row">
            <?php
            echo Yii::t('app', 'Web: {website}',
                    array('{website}' => CHtml::link('www.upwardplus.com',
                        'https://www.upwardplus.com',array('target'=>'_blank'))));
            ?> | 
            <?php
            echo Yii::t('app', 'Email: {email}',
                    array('{email}' => CHtml::link('contact@upwardplus.com',
                        'mailto:contact@upwardplus.com')));
            ?>
        </div>
    </div>
    <div class="page-title x2-layout-island">
        <h2 style="padding-left:0"><?php
            echo Yii::t('app', 'Administration Tools');
            ?></h2>
        <?php
		/*
        if (X2_PARTNER_DISPLAY_BRANDING) {
            $partnerAbout = Yii::getPathOfAlias('application.partner') . DIRECTORY_SEPARATOR . 'aboutPartner.php';
            $partnerAboutExample = Yii::getPathOfAlias('application.partner') . DIRECTORY_SEPARATOR . 'aboutPartner_example.php';
            echo CHtml::link(Yii::t('app', 'About {product}',
                            array('{product}' => CHtml::encode(X2_PARTNER_PRODUCT_NAME))),
                    array('/site/page', 'view' => 'aboutPartner'),
                    array('class' => 'x2-button right'));
        } */

        echo CHtml::link(Yii::t('admin', 'About Upward Plus+'),
                'https://upwardplus.com',
                array('class' => 'x2-button right', 'id' => 'up-about-button'));
        ?>
    </div>
    <div class=" x2-layout-island" id="main-admin-panel" style="display:none;">
        <div id="tabs" class="form">
            <ul>
                <li data-attr="tabs-10"><div id="admin-settings"><a href="#tabs-10"><?php
                            echo Yii::t('admin', 'Settings');
                            ?></a></div></li>
                <li data-attr="tabs-9"><div id="admin-x2studio"><a href="#tabs-9"><?php
                            echo Yii::t('admin', 'Customization');
                            ?></a></div></li>
                <li data-attr="tabs-4"><div id="admin-ui-settings"><a href="#tabs-4"><?php
                            echo Yii::t('admin', 'User Interface');
                            ?></a></div></li>
                <li data-attr="tabs-6"><div id="admin-workflow"><a href="#tabs-6"><?php
                            echo Yii::t('admin', 'Automation Settings');
                            ?></a></div></li>
                <li data-attr="tabs-3"><div id="admin-users"><a href="#tabs-3"><?php
                            echo Yii::t('admin', 'User Management');
                            ?></a></div></li>
                <li data-attr="tabs-5"><div id="admin-lead-capture"><a href="#tabs-5"><?php
                            echo Yii::t('admin', 'Web Lead Settings');
                            ?></a></div></li>
                <li data-attr="tabs-7"><div id="admin-email"><a href="#tabs-7"><?php
                            echo Yii::t('admin', 'Email Settings');
                            ?></a></div></li>
                <li data-attr="tabs-11"><div id="admin-security"><a href="#tabs-11"><?php
                            echo Yii::t('admin', 'Security Settings');
                            ?></a></div></li>					
                <li data-attr="tabs-8"><div id="admin-import-export"><a href="#tabs-8"><?php
                            echo Yii::t('admin', 'Data Migration');
                            ?></a></div></li>
				<li data-attr="tabs-1"><div id="admin-support"><a href="#tabs-1"><?php
                            echo Yii::t('admin', 'Help & Support');
                            ?></a></div></li>
				<!-- ADD BACK LATER -->
                <li data-attr="tabs-2" style="display: none; "><div id="admin-doc-and-videos"> <a href="#tabs-2"><?php
                            echo Yii::t('admin', 'Documentation & Videos');
                            ?></a></div></li>
				<!-- REMOVED PERMANENTLY -->
                <li data-attr="tabs-12" style="display: none; "><div id="admin-hub"><a href="#tabs-12"><?php
                            echo Yii::t('admin', 'Hub Services');
                            ?></a></div></li>
            </ul>
            <div id="tabs-1">

                <h2 id="admin-support"><?php
                    echo Yii::t('admin', 'Help & Support');
                    ?></h2>
                <div class="cell span-6">
				<?php
                    echo CHtml::link(Yii::t('admin', 'Upward Plus+ CRM'),'https://www.upwardplus.com',array('target'=>'_blank'));
                ?><br>
				<?php
                    echo Yii::t('admin', 'Upward Plus+ Homepage');
                ?>
                </div>
				
				<!-- ADD BACK LATER -->
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'File a Support Case'),
                            'https://www.upwardplus.com/comingsoon',array('target'=>'_blank'));
                    ?><br><?php
                    echo Yii::t('admin', 'Coming Soon')
                    ?>
                </div>
				
				<!-- ADD BACK LATER -->
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Upward Plus+ Community'),
                            'https://upwardplus.com/comingsoon',array('target'=>'_blank'));
                    ?>
                    <br><?php
                    echo Yii::t('admin', 'Coming Soon')
                    ?>
                </div>

            </div>
            <div id="tabs-2">

                <h2 id="admin-doc-and-videos"><?php
                    echo Yii::t('admin', 'Documentation & Videos');
                    ?></h2>
                <div class="cell span-6"><?php
                    echo CHtml::link(
                            Yii::t('admin', 'User Reference Guide'),
                            'http://www.upwardplus.com/comingsoon',array('target'=>'_blank'));
                    ?><br><?php
                    echo Yii::t('admin', 'Coming Soon - Information for end users of Upward Plus+',array('target'=>'_blank'));
                    ?>
                </div>
                <div class="cell span-6">
                    <?php
                    echo CHtml::link(
                            Yii::t('admin', 'Workflow Reference'),
                            'https://www.upwardplus.com/comingsoon',array('target'=>'_blank'));
                    ?><br>
                    <?php
                    echo Yii::t('admin',
                            'Coming Soon - Information for workflow users and administrators')
                    ?>
                </div>

                <div class="cell span-6"><?php
                    echo CHtml::link(
                            Yii::t('admin', 'Tutorial Videos'),
                            'https://www.upwardplus.com/comingsoon',array('target'=>'_blank'));
                    ?><br><?php
                    echo CHtml::encode(
                            Yii::t('admin', 'User and admin tutorial videos'));
                    ?>
                </div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(
                            Yii::t('admin', 'Developer Wiki'),
                            'https://www.upwardplus.com/comingsoon',array('target'=>'_blank'));
                    ?><br><?php
                    echo Yii::t('admin', 'Technical Documentation');
                    ?>
                </div>
                <div class="cell span-6">
                    <?php
                    echo CHtml::link(
                            Yii::t('admin', 'Upward Plus+ Academy'),
                            'https://www.upwardplus.com/comingsoon',array('target'=>'_blank'));
                    ?><br>
                    <?php
                    echo Yii::t('admin',
                            'Coming Soon - Online training to take your automation to the next level.')
                    ?>
                </div>

            </div>
            <div id="tabs-3">

                <h2 id="admin-users"><?php
                    echo Yii::t('admin', 'User Management');
                    ?></h2>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('users', 'Create User'),
                            array('/users/users/create'));
                    ?>
                    <br>
                    <?php
                    echo CHtml::encode(Yii::t('app',
                                    'Create a user account'));
                    ?>
                </div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('users', 'Manage Users'),
                            array('/users/users/admin'));
                    ?>
                    <br>
                    <?php
                    echo CHtml::encode(Yii::t('app',
                                    'Manage user accounts'));
                    ?>
                </div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('users', 'Invite Users'),
                            array('/users/users/inviteUsers'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Send invitation emails to create user accounts');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin',
                                    'Edit User Permissions & Access Rules'),
                            array('/admin/editRoleAccess'));
                    ?><br><?php
                    echo Yii::t('admin', 'Change access rules for roles');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Manage Roles'),
                            array('/admin/manageRoles'));
                    ?><br><?php
                    echo Yii::t('admin', 'Create and manage user roles');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('app', 'Groups'),
                            array('/groups/groups/index'));
                    ?><br><?php
                    echo Yii::t('admin', 'Create and manage user groups');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'View User Changelog'),
                            array('/admin/viewChangelog'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'View a log of everything that has been changed');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'User View History'),
                            array('/admin/userViewLog'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'See a history of which records users have viewed');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'User Location History'),
                            array('/admin/userLocationHistory'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'See a history of where users have been');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Manage Sessions'),
                            array('/admin/manageSessions'));
                    ?><br><?php echo Yii::t('admin', 'Manage user sessions');
                    ?></div>
                <?php if (Yii::app()->settings->sessionLog) { ?>
                    <div class="cell span-6"><?php
                        echo CHtml::link(Yii::t('admin', 'View Session Log'),
                                array('/admin/viewSessionLog'));
                        ?><br><?php
                        echo Yii::t('admin',
                                'View a log of user sessions with timestamps and statuses');
                        ?></div>
                <?php } ?>


                <div class="cell span-6">
                    <?php
                    echo CHtml::link(Yii::t('users', 'User Login History'),
                            array('admin/userHistory'));
                    ?>
                    <br>
                    <?php
                    echo Yii::t('app',
                            'Manage user account history, including failed and successful logins');
                    ?>
                </div>

            </div>
            <div id="tabs-4">

                <h2 id="admin-ui-settings"><?php
                    echo Yii::t('admin', 'User Interface');
                    ?></h2>
                <div class="cell span-6" style="display: none; ">
                    <?php
                    echo CHtml::link(Yii::t('admin',
                                    'Change the Application Name'),
                            array('/admin/changeApplicationName'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Change the name of the application as displayed on page titles');
                    ?>
                </div>

                <div class="cell span-6" style="display: none; ">
                    <?php
                    echo CHtml::link(Yii::t('admin', 'Set a Default Theme'),
                            array('/admin/setDefaultTheme'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Set a default theme which will automatically be set for all new users');
                    ?>
                </div>

                <div class="cell span-6">
                    <?php
                    echo CHtml::link(Yii::t('admin',
                                    'Manage Action Publisher Tabs'),
                            array('/admin/manageActionPublisherTabs'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Enable or disable tabs in the action publisher');
                    ?>
                </div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Manage Menu Items'),
                            array('/admin/manageModules'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Re-order, add, or remove top bar links');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Upload Your Logo'),
                            array('/admin/uploadLogo'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Upload your own logo for the top menu bar and login screen');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Add Top Bar Link'),
                            array('/admin/createPage'));
                    ?><br><?php
                    echo Yii::t('admin', 'Add a link to the top bar');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Edit Global CSS'),
                            array('/admin/editGlobalCss'));
                    ?><br><?php
                    echo Yii::t('admin', 'Edit globally-applied stylesheet');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Mobile App Form Editor'),
                            array('/admin/editMobileForms'));
                    ?><br><?php
                    echo Yii::t('admin', 'Edit form layouts for touch devices.');
                    ?></div>

            </div>
            <div id="tabs-5">

                <h2 id="admin-lead-capture"><?php
                    echo Yii::t('admin', 'Web Lead Settings');
                    ?></h2>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('marketing', 'Web Lead Form'),
                            array('/marketing/marketing/webleadForm'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Create a public form to receive new contacts');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Set Web Lead Distribution'),
                            array('/admin/setLeadRouting'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Change how new web leads are distributed');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Add Custom Lead Rules'),
                            array('/admin/roundRobinRules'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Manage rules for the "Custom Round Robin" lead distribution setting');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Service Case Web Form'),
                            array('/services/services/createWebForm'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Create a public form to receive new service cases');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin',
                                    'Set Service Case Distribution'),
                            array('/admin/setServiceRouting'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Change how service cases are distributed');
                    ?></div>
					
				<!-- ADD BACK LATER -->
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Web Tracker Setup'),
                            array('/marketing/marketing/webTracker'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure and embed visitor tracking on your website');
                    ?></div>

            </div>
            <div id="tabs-6">

                <h2 id="admin-workflow"><?php
                    echo Yii::t('admin', 'Automation Settings');
                    ?></h2>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Workflow'),
                            array('/studio/flowIndex'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Program Upward Plus+ with custom automation directives using a visual design interface');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin',
                                    'Manage Sales & Service Processes'),
                            array('/workflow/index'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Create and manage processes for Sales, Service, or Custom modules');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Process Settings'),
                            array('/admin/workflowSettings'));
                    ?><br><?php
                    echo Yii::t('admin', 'Change advanced process settings');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Workflow Settings'),
                            array('/admin/flowSettings'));
                    ?><br><?php
                    echo Yii::t('admin', 'Workflow configuration options');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Import Workflow'),
                            array('/studio/importFlow'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Import automation flows created using the Workflow design studio');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin',
                                    'Manage Notification Criteria'),
                            array('/admin/addCriteria'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Manage which events will trigger user notifications');
                    ?></div>

            </div>
            <div id="tabs-7">

                <h2 id="admin-email"><?php
                    echo Yii::t('admin', 'Email Settings');
                    ?></h2>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Email Settings'),
                            array('/admin/emailSetup'));
                    ?><br><?php
                    echo Yii::t('admin', 'Configure the Upward Plus+ email settings');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Create Email Campaign'),
                            array('/marketing/marketing/create'));
                    ?><br><?php
                    echo Yii::t('admin', 'Create an email marketing campaign');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Manage Campaigns'),
                            array('/marketing/marketing/index'));
                    ?><br><?php
                    echo Yii::t('admin', 'Manage your marketing campaigns');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Email Capture'),
                            array('/admin/emailDropboxSettings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Settings for the "email dropbox", which allows Upward Plus+ to receive and record email');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Convert Template Images'),
                            array('/admin/convertEmailTemplates'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Fix dead image links in email templates resulting from the 5.2/5.3 media module change');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Google Integration'),
                            array('/admin/googleIntegration'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure and enable Google integration');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Twitter Integration'),
                            array('/admin/twitterIntegration'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Enter your Twitter app settings for Twitter widget');
                    ?></div>

                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Jasper Server Integration'),
                            array('/admin/jasperIntegration'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Enter your Jasper Server settings for external reporting');
                    ?></div>

            </div>
            <div id="tabs-8">

                <h2 id="admin-import-export"><?php
                    echo Yii::t('admin', 'Data Migration');
                    ?></h2>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Import Records'),
                            array('/admin/importModels'));
                    ?><br><?php
                    echo Yii::t('admin', 'Import records using a CSV template');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Export Records'),
                            array('/admin/exportModels'));
                    ?><br><?php
                    echo Yii::t('admin', 'Export records to a CSV file');
                    ?></div>

                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Import All Data'),
                            array('/admin/import'));
                    ?><br><?php
                    echo Yii::t('admin', 'Import from a global export file');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Export All Data'),
                            array('/admin/export'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Export all data (useful for making backups)');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Tag Manager'),
                            array('/admin/manageTags'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'View a list of all used tags with options for deletion');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Rollback Import'),
                            array('/admin/rollbackImport'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Delete all records created by a previous import');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Revert Merges'),
                            array('/admin/undoMerge'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Revert record merges which users have performed in the app');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(
                            Yii::t('admin', 'Mass Dedupe Tool'),
                            array('/admin/massDedupe'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'View a list of all duplicates in the system and resolve them in bulk.');
                    ?></div>

            </div>
            <div id="tabs-9">

                <h2 id="admin-x2studio"><?php
                    echo Yii::t('admin', 'Customization');
                    ?></h2>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Create a Module'),
                            array('/admin/createModule'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Create a custom module to add to the top bar');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Rename a module'),
                            array('/admin/renameModules'));
                    ?><br><?php
                    echo Yii::t('admin', 'Change module titles on top bar');
                    ?></div>

                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Packager'),
                            array('/admin/packager'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Import and Export packages to easily share and use system customizations');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Form Editor'),
                            array('/admin/editor'));
                    ?><br><?php
                    echo Yii::t('admin', 'Drag and drop editor for forms');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Delete a module or Page'),
                            array('/admin/deleteModule'));
                    ?><br><?php
                    echo Yii::t('admin', 'Remove a custom module or page');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Convert Modules'),
                            array('/admin/convertCustomModules'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Convert your custom modules to be compatible with the latest version');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Import a module'),
                            array('/admin/importModule'));
                    ?><br><?php
                    echo Yii::t('admin', 'Import a .zip of a module');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Export a module'),
                            array('/admin/exportModule'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Export one of your custom modules to a .zip');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Manage Fields'),
                            array('/admin/manageFields'));
                    ?><br><?php
                    echo Yii::t('admin', 'Customize fields for the modules');
                    ?></div>


                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Dropdown Editor'),
                            array('/admin/manageDropDowns'));
                    ?><br><?php
                    echo Yii::t('admin', 'Manage dropdowns for custom fields');
                    ?></div>

            </div>
            <div id="tabs-10">

                <h2 id="admin-settings"><?php
                    echo Yii::t('admin', 'Settings');
                    ?></h2>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Updater Settings'),
                            array('/admin/updaterSettings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure automatic updates and registration');
                    ?></div>
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Update Upward Plus+'),
                            array('/admin/updater'));
                    ?><br><?php
                    echo Yii::t('admin', 'IMPORTANT!- PLEASE CONTACT YOUR ACCOUNT MANAGER BEFORE USING THIS FEATURE');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'General Settings'),
                            array('/admin/appSettings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure session timeout and chat poll rate.');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Activity Feed Settings'),
                            array('/admin/activitySettings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure global settings for the activity feed');
                    ?></div>
                <div class="cell span-6" style="display: none; ">
                    <?php
                    echo CHtml::link(Yii::t('admin', 'Public Info Settings'),
                            array('/admin/publicInfo'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Miscellaneous settings that control publicly-visible data');
                    ?>
                </div>
                <div class="cell span-6" style="display: none; ">
                    <?php
                    echo CHtml::link(Yii::t('admin', 'Cron Table'),
                            array('/admin/x2CronSettings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Control the interval at which the application will check for and run scheduled tasks');
                    ?>
                </div>
				
				<!-- ADD BACK LATER -->
                <div class="cell span-6" style="display: none; "><?php
                    echo CHtml::link(Yii::t('admin', 'Location Settings'),
                            array('/admin/locationSettings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure location tracking and tracking rate.');
                    ?></div>

            </div>
            <div id="tabs-11">

                <h2 id="admin-security"><?php
                    echo Yii::t('admin', 'Security Settings');
                    ?></h2>
                <div class="cell span-6" style="display: none; ">
                    <?php
                    echo CHtml::link(Yii::t('admin', 'Lock or Unlock Upward Plus+'),
                            array('/admin/lockApp'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Set the application into maintenance mode, where only administrators can access it');
                    ?>
                </div>
                <div class="cell span-6" style="display: none; ">
                    <?php
                    echo CHtml::link(Yii::t('admin', 'REST API'),
                            array('/admin/api2Settings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Advanced API security and access control settings');
                    ?>
                </div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin',
                                    'Advanced Security Settings'),
                            array('/admin/securitySettings'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure IP access control, failed login penalties, and user password requirements to help prevent unauthorized access to the system');
                    ?></div>

            </div>
            <!-- <div id="tabs-12">

                <h2 id="admin-hub"><?php
                    echo Yii::t('admin', 'Hub Services');
                    ?></h2>
                <p class="cell">
                    <?php echo Yii::t('admin', 'Hub Services is a cloud information service provided by X2Engine Inc. It includes connectors for security, calendaring, mapping, speech, email, text, and other network services. For more information and to purchase a subscription, please visit {url}.', array('{url}' => CHtml::link('https://www.x2crm.com/', 'https://www.x2crm.com/', array('target' => '_blank')))); ?>
                </p>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin',
                                    'Obtain A Hub License Key'),'https://x2crm.com/products/');
                    ?><br><?php
                    echo Yii::t('admin',
                            'Obtain a license key to use with Hub Services.');
                    ?></div>
                <div class="cell span-6"><?php
                    echo CHtml::link(Yii::t('admin', 'Configure X2 Hub Integration'),
                            array('/admin/x2HubIntegration'));
                    ?><br><?php
                    echo Yii::t('admin',
                            'Configure your Hub settings to enable external connectors');
                    ?></div>

            </div> -->
        </div>
    </div>
</div>     
<br><br>
<script>
    $(function () {
        var ordering = $.cookie('admin-tab-ordering');
        if (ordering !== null) {
            ordering = JSON.parse(ordering);
            var $ul = $("#tabs ul");
            var reordered = [];
            for (var i = ordering.length - 1; i >= 0; i--) {
                reordered.push($ul.find("[data-attr='" + ordering[i] + "']"));
            }
            $ul.empty();
            for (var i = 0; i < reordered.length; i++) {
                $ul.prepend(reordered[i]);
            }
        }
        $("#tabs").tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
        $("#tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");
    });
    //Makes tabs sortable widgets
    $(function () {
        var tabs = $("#tabs").tabs();
        tabs.find(".ui-tabs-nav").sortable({
            axis: "y",
            update: function (event, ui) {
                // This will trigger after a sort is completed
                var ordering = [];
                var $columns = $(".ui-tabs-nav li");
                $columns.each(function (index, column) {
                    ordering.push($(column).attr("data-attr"));
                });
                $.cookie("admin-tab-ordering", JSON.stringify(ordering));
            },
            stop: function () {
                tabs.tabs("refresh");
            }
        });
        $("#main-admin-panel").show();
    });
</script>
