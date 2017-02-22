<?php
/***********************************************************************************
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
 **********************************************************************************/

mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');

if (Yii::app()->params->profile) {
    $preferences = Yii::app()->params->profile->theme;
} else {
    $preferences = array ();
}
$jsVersion = '?'.Yii::app()->params->buildDate;

// blueprint CSS framework
$themeURL = Yii::app()->theme->getBaseUrl();
Yii::app()->clientScript->registerCssFile($themeURL.'/css/screen.css'.$jsVersion,'screen, projection');
Yii::app()->clientScript->registerCssFile($themeURL.'/css/print.css'.$jsVersion,'print');
Yii::app()->clientScript->registerCssFile($themeURL.'/css/main.css'.$jsVersion,'screen, projection');
Yii::app()->clientScript->registerCssFile($themeURL.'/css/form.css'.$jsVersion,'screen, projection');
Yii::app()->clientScript->registerCssFile($themeURL.'/css/ui-elements.css'.$jsVersion,'screen, projection');

if (AuxLib::getIEVer() < 9) {
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/lib/aight/aight.js');
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/lib/jquery-migrate-1.2.1.js');


$backgroundImg = '';
$defaultOpacity = 1;
$themeCss = '';

$checkResult = false;
$checkFiles = array(
	'themes/x2engine/images/x2footer.png'=>'1393e4af54ababdcf76fac7f075b555b',
	'themes/x2engine/images/x2-mini-icon.png'=>'153d66b514bf9fb0d82a7521a3c64f36',
);
foreach($checkFiles as $key=>$value) {
	if(!file_exists($key) || hash_file('md5',$key) != $value)
		$checkResult = true;
}
$theme2Css = '';
if($checkResult)
	$theme2Css = 'html * {background:url('.CHtml::normalizeUrl(array('/site/warning')).') !important;} #bg{display:none !important;}';


Yii::app()->clientScript
    ->registerCss('applyTheme2',$theme2Css,'screen',CClientScript::POS_HEAD)
    ->registerCssFile(Yii::app()->theme->getBaseUrl().'/css/login.css')
    ->registerCssFile(Yii::app()->theme->getBaseUrl().'/css/fontAwesome/css/font-awesome.css')
    ->registerScriptFile(Yii::app()->getBaseUrl().'/js/auxlib.js')
    ->registerScriptFile(Yii::app()->getBaseUrl().'/js/X2Forms.js');


?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Yii::app()->language; ?>" lang="<?php echo Yii::app()->language; ?>">
<head>
<meta charset="UTF-8" />
<meta name="language" content="<?php echo Yii::app()->language; ?>" />

<meta name="description" content="X2Engine - Open Source Sales CRM - Sales Software">
<meta name="keywords" content="X2Engine,X2CRM,open source sales CRM,sales software">

<link rel="icon" href="<?php echo Yii::app()->getFavIconUrl (); ?>" type="image/x-icon">
<link rel="shortcut-icon" href="<?php echo Yii::app()->getFavIconUrl (); ?>" type="image/x-icon">
<link rel="icon" href="<?php echo Yii::app()->getFavIconUrl (); ?>" type="image/x-icon">
<link rel="shortcut-icon" href="<?php echo Yii::app()->getFavIconUrl (); ?>" type="image/x-icon">

<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo $themeURL; ?>/css/ie.css" media="screen, projection" />
<![endif]-->
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<style>
body#body-tag.login {
    background: transparent url("https://upwardplus.com/common-images/desktop.jpg") no-repeat fixed left bottom / cover;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
}
#login-form-logo {
  margin-bottom: 25px;
}
#login-page {
	background: rgba(243,243,243,0.9);
}
#up-signin-button {
	display: inline-block;
	box-sizing: border-box;
	height: 40px;
	padding: 10px 25px;
	margin: 10px 0 5px;
	width: 80%;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 17px;
	line-height: 15px;
	font-weight: 400;
	text-align: center;
	text-transform: uppercase;
	text-decoration: none !important;
	text-shadow: 1px 1px 2px #666666;
	border-radius: 5px;
	box-shadow: none;
	cursor: pointer;
}

#up-signin-button,
#up-signin-button.blue {
	color: #ffffff;
	border: 1px solid #015f9d;
	background: #019ae1;
	background-image: -webkit-linear-gradient(top, #019ae1, #007bc2);
	background-image: -moz-linear-gradient(top, #019ae1, #007bc2);
	background-image: -ms-linear-gradient(top, #019ae1, #007bc2);
	background-image: -o-linear-gradient(top, #019ae1, #007bc2);
	background-image: linear-gradient(to bottom, #019ae1, #007bc2);
}

#up-signin-button:hover,
#up-signin-button.blue:hover {
	color: #ffffff;
	border: 1px solid #015f9d;
	background: #007bc2;
	background-image: -webkit-linear-gradient(top, #007bc2, #019ae1);
	background-image: -moz-linear-gradient(top, #007bc2, #019ae1);
	background-image: -ms-linear-gradient(top, #007bc2, #019ae1);
	background-image: -o-linear-gradient(top, #007bc2, #019ae1);
	background-image: linear-gradient(to bottom, #007bc2, #019ae1);
}

#up-signin-button.gray {
	color: #ffffff;
	border: 1px solid #808487;
	background: #a3a3a3;
	background-image: -webkit-linear-gradient(top, #a3a3a3, #4d4d4d);
	background-image: -moz-linear-gradient(top, #a3a3a3, #4d4d4d);
	background-image: -ms-linear-gradient(top, #a3a3a3, #4d4d4d);
	background-image: -o-linear-gradient(top, #a3a3a3, #4d4d4d);
	background-image: linear-gradient(to bottom, #a3a3a3, #4d4d4d);
}

#up-signin-button.gray:hover {
	color: #ffffff;
	border: 1px solid #808487;
	background: #4d4d4d;
	background-image: -webkit-linear-gradient(top, #4d4d4d, #a3a3a3);
	background-image: -moz-linear-gradient(top, #4d4d4d, #a3a3a3);
	background-image: -ms-linear-gradient(top, #4d4d4d, #a3a3a3);
	background-image: -o-linear-gradient(top, #4d4d4d, #a3a3a3);
	background-image: linear-gradient(to bottom, #4d4d4d, #a3a3a3);
}

#up-signin-button.black {
	color: #ffffff;
	border: 1px solid #808487;
	background: #6b6a6b;
	background-image: -webkit-linear-gradient(top, #6b6a6b, #000000);
	background-image: -moz-linear-gradient(top, #6b6a6b, #000000);
	background-image: -ms-linear-gradient(top, #6b6a6b, #000000);
	background-image: -o-linear-gradient(top, #6b6a6b, #000000);
	background-image: linear-gradient(to bottom, #6b6a6b, #000000);
}

#up-signin-button.black:hover {
	color: #ffffff;
	border: 1px solid #808487;
	background: #000000;
	background-image: -webkit-linear-gradient(top, #000000, #6b6a6b);
	background-image: -moz-linear-gradient(top, #000000, #6b6a6b);
	background-image: -ms-linear-gradient(top, #000000, #6b6a6b);
	background-image: -o-linear-gradient(top, #000000, #6b6a6b);
	background-image: linear-gradient(to bottom, #000000, #6b6a6b);
}

#up-signin-button.green {
	color: ffffff;
	border: 1px solid #808487;
	background: #0aa834;
	background-image: -webkit-linear-gradient(top, #0aa834, #1d8016);
	background-image: -moz-linear-gradient(top, #0aa834, #1d8016);
	background-image: -ms-linear-gradient(top, #0aa834, #1d8016);
	background-image: -o-linear-gradient(top, #0aa834, #1d8016);
	background-image: linear-gradient(to bottom, #0aa834, #1d8016);
}

#up-signin-button.green:hover {
	color: ffffff;
	border: 1px solid #808487;
	background: #1d8016;
	background-image: -webkit-linear-gradient(top, #1d8016, #0aa834);
	background-image: -moz-linear-gradient(top, #1d8016, #0aa834);
	background-image: -ms-linear-gradient(top, #1d8016, #0aa834);
	background-image: -o-linear-gradient(top, #1d8016, #0aa834);
	background-image: linear-gradient(to bottom, #1d8016, #0aa834);
}

div.cell.x2touch-cell {
  display: none !important;
}

a#dark-theme-button {
  display: none !important;
}

</style>


</head>
<?php
echo X2Html::openBodyTag ($preferences, array (
    'id' => 'body-tag',
    'class' => 'login',
));
?>
<meta name="viewport" content="width=device-width, initial-scale=0.8, user-scalable=no">
<!--<div class="ie-shadow" style="display:none;"></div>-->

<?php echo $content; ?>

<div class='background2'>

</div>

<?php 
LoginThemeHelper::render() 
?>
</body>
</html>
