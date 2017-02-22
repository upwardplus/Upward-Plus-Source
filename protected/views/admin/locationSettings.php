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

Yii::app()->clientScript->registerCss('appSettingsCss',"
#settings-form {
    padding-bottom: 1px;
}
");

Yii::app()->clientScript->registerScript('updateChatPollSlider', "
$('#settings-form input, #settings-form select, #settings-form textarea').change(function() {
	$('#save-button').addClass('highlight'); 
});

$('#locationTrackingFrequency').change(function() {
	$('#chatPollSlider').slider('value',$(this).val());
});
$('#timeout').change(function() {
	$('#timeoutSlider').slider('value',$(this).val());
});
$('#locationTrackingDistance').change(function(){
    $('#locationTrackingDistanceSlider').slider('value',$(this).val());
});
$('#massActionsBatchSize').change(function(){
    $('#massActionsBatchSizeSlider').slider('value',$(this).val());
});

$('#currency').change(function() {
	if($('#currency').val() == 'other')
		$('#currency2').fadeIn(300);
	else
		$('#currency2').fadeOut(300);
});
", CClientScript::POS_READY);
?>
<div class="page-title"><h2><?php echo Yii::t('admin', 'Location Settings'); ?></h2></div>
<div class="admin-form-container">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'settings-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <div class="form">
        <?php
        echo $form->labelEx($model, 'locationTrackingFrequency');
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value' => $model->locationTrackingFrequency,
            // additional javascript options for the slider plugin
            'options' => array(
                'min' => 1,
                'max' => 60,
                'step' => 1,
                'change' => "js:function(event,ui) {
					$('#locationTrackingFrequency').val(ui.value);
					$('#save-button').addClass('highlight');
				}",
                'slide' => "js:function(event,ui) {
					$('#locationTrackingFrequency').val(ui.value);
				}",
            ),
            'htmlOptions' => array(
                'id' => 'locationTrackingFrequencySlider',
                'style' => 'margin:10px 0;',
                'class'=>'x2-wide-slider'
            ),
        ));

        echo $form->textField($model, 'locationTrackingFrequency', array('id' => 'locationTrackingFrequency'));
        ?><br>
        <?php echo Yii::t('admin', 'Set the time between location requests in minutes.'); ?>
        <br><br>
        <?php echo Yii::t('admin', 'Decreasing this number allows for more instantaneous location fetching, but generates more server requests, so adjust it to taste. The default value is 3600 (1 hour).'); ?>
    </div>
    <!-- <div class="form">
        <?php
        echo $form->timeField ($model, 'locationTrackingFrequency', array('id' => 'locationTrackingFrequency'));
        /*echo $this->widget ('ActiveDateRangeInput', array (
            'model' => $model,
            'startDateAttribute' => $attributeA,
            'endDateAttribute' => $attributeB,
            'namespace' => get_class ($this->formModel).$this->namespace,
            'options' => $options,
        ), true);*/
        /*echo $form->labelEx($model, 'timeout');
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value' => $model->timeout,
            // additional javascript options for the slider plugin
            'options' => array(
                'min' => 5,
                'max' => 1440,
                'step' => 5,
                'change' => "js:function(event,ui) {
					$('#timeout').val(ui.value);
					$('#save-button').addClass('highlight');
				}",
                'slide' => "js:function(event,ui) {
					$('#timeout').val(ui.value);
				}",
            ),
            'htmlOptions' => array(
                'style' => 'margin:10px 0;',
                'class'=>'x2-wide-slider',
                'id' => 'timeoutSlider'
            ),
        ));

        echo $form->textField($model, 'timeout', array('id' => 'timeout'));*/
        ?>
        <br>
        <?php //echo Yii::t('admin', 'Set user session expiration time (in minutes). Default is 60.'); ?><br>
        <br>
        <label for="Admin_sessionLog"><?php //echo Yii::t('admin', 'Log user sessions?'); ?></label>
        <?php //echo $form->checkBox($model, 'sessionLog'); ?>
    </div>-->
    <div class="form">
        <?php
        echo $form->labelEx($model,'locationTrackingDistance');
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value' => $model->locationTrackingDistance,
            // additional javascript options for the slider plugin
            'options' => array(
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'change' => "js:function(event,ui) {
					$('#locationTrackingDistance').val(ui.value);
					$('#save-button').addClass('highlight');
				}",
                'slide' => "js:function(event,ui) {
					$('#locationTrackingDistance').val(ui.value);
				}",
            ),
            'htmlOptions' => array(
                'style' => 'margin:10px 0;',
                'id' => 'locationTrackingDistanceSlider',
                'style' => 'margin:10px 0;',
                'class'=>'x2-wide-slider',
            ),
        ));
        echo $form->textField($model,'locationTrackingDistance',array('style'=>'width:50px;','id'=>'locationTrackingDistance'));
        echo '<p>'.Yii::t('admin','The number in kilometers they have to move in order to track their location.').'</p>';
        
         ?>
         
    </div>
    <!--<div class="form">
        <?php
        /*echo $form->labelEx($model,'massActionsBatchSize');
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value' => $model->massActionsBatchSize,
            // additional javascript options for the slider plugin
            'options' => array(
                'min' => 5,
                'max' => 100,
                'step' => 5,
                'change' => "js:function(event,ui) {
					$('#massActionsBatchSize').val(ui.value);
					$('#save-button').addClass('highlight');
				}",
                'slide' => "js:function(event,ui) {
					$('#massActionsBatchSize').val(ui.value);
				}",
            ),
            'htmlOptions' => array(
                'style' => 'margin:10px 0;',
                'id' => 'massActionsBatchSizeSlider',
                'style' => 'margin:10px 0;',
                'class'=>'x2-wide-slider',
            ),
        ));
        echo $form->textField($model,'massActionsBatchSize',array('style'=>'width:50px;','id'=>'massActionsBatchSize'));
        */?>
    </div>-->
    <div class="form">
        <label class='left-label' for="Admin_locationTrackingSwitch"><?php echo Yii::t('admin', 'Turn on Location Tracking'); ?></label>
            <?php //echo X2Html::hint2 (Yii::t('admin','Enabling strict lock completely disables locked quotes from being edited. While this setting is off, there will be a confirm dialog before editing a locked quote.'));
        echo X2Html::clearfix (); 
        echo $form->checkBox($model, 'locationTrackingSwitch'); ?>
        <br><br>
        <!--<label class='left-label' for="Admin_userActionBackdating"><?php //echo Yii::t('admin', 'Allow Users to Backdate Actions'); ?></label><?php //echo X2Html::hint2 (Yii::t('admin', 'Enabling action backdating will allow any user to change the automatically set date fields (i.e. create date). While this setting is off, only those with Admin access to the Actions module will be allowed to backdate actions.'));
        //echo X2Html::clearfix ();
        //echo $form->checkBox($model, 'userActionBackdating'); ?>
        <br><br>-->
        <?php
        /*echo $form->label ($model, 'disableAutomaticRecordTagging', array (
            'class' => 'left-label',
        ));
        echo X2Html::hint2 (Yii::t('admin', 'Enabling action backdating will allow any user to change the automatically set date fields (i.e. create date). While this setting is off, only those with Admin access to the Actions module will be allowed to backdate actions.'));
        echo X2Html::clearfix ();
        echo $form->checkBox($model, 'disableAutomaticRecordTagging'); */?>
    </div>
    <!-- <div class="form">
        <label class='left-label' for="Admin_historyPrivacy">
            <?php //echo Yii::t('admin', 'Event/Action History Privacy'); ?></label>
            <?php //echo X2Html::hint2 (Yii::t('admin', 'Default will allow users to see actions/events which are public or assigned to them. User Only will allow users to only see actions/events assigned to them. Group Only will allow users to see actions/events assigned to members of their groups.'));
        /*echo X2Html::clearfix ();
        echo $form->dropDownList($model, 'historyPrivacy', array(
            'default' => Yii::t('admin', 'Default'),
            'user' => Yii::t('admin', 'User Only'),
            'group' => Yii::t('admin', 'Group Only'),
        ));*/
        ?>
        <br><br>
        <?php //echo Yii::t('admin', 'Choose a privacy setting for the Action History widget and Activity Feed. Please note that any user with Admin level access to the module that the History is on will ignore this setting. Only users with full Admin access will ignore this setting on the Activity Feed.') ?>
    </div> -->
    <!-- <div class="form">
        <?php //echo $form->labelEx($model, 'properCaseNames'); ?>
        <?php //echo Yii::t('admin', 'Attempt to format Contact names to have proper case?') ?><br>
        <?php //echo $form->dropDownList($model, 'properCaseNames', array(1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No'))); ?>
        <br><br>
        <?php //echo $form->labelEx($model, 'contactNameFormat'); ?>
        <?php //echo Yii::t('admin', 'Select a name format to use for Contact names throughout the app.') ?><br>
<?php //echo $form->dropDownList($model, 'contactNameFormat', array('firstName lastName' => '{'.Yii::t('contacts', 'First Name').'} {'.Yii::t('contacts', 'Last Name').'}', 'lastName, firstName' => '{'.Yii::t('contacts', 'Last Name').'}, {'.Yii::t('contacts', 'First Name').'}')); ?>
    </div> -->

    <!--<div class="form">
        <?php //echo $form->labelEx($model, 'currency'); ?>
            <?php //echo Yii::t('admin', 'Select a default currency for quotes and invoices.') ?><br>
        <select name="currency" id="currency">
            <?php
            //$curFound = false;
            //foreach(Yii::app()->params->supportedCurrencies as $currency):
                ?>
                <option value="<?php //echo $currency ?>"<?php// if($model->currency == $currency){
                    //$curFound = true;
                    //echo ' selected="true"';
                //} ?>><?php //echo $currency; ?></option>
        <?php //endforeach; ?>
            <option value="other"<?php //if(!$curFound){
            //echo ' selected="true"';
        //} ?>><?php //echo Yii::t('admin', 'Other'); ?></option>
        </select>
        <input type="text" name="currency2" id="currency2" style="width:120px;<?php //if($curFound) echo 'display:none;'; ?>" value="<?php //echo $curFound ? '' : $model->currency; ?>" />
    </div>-->
    
    <div class="error">
<?php echo $form->errorSummary($model); ?>
    </div>

<?php echo CHtml::submitButton(Yii::t('app', 'Save'), array('class' => 'x2-button', 'id' => 'save-button'))."\n"; ?>
<?php //echo CHtml::resetButton(Yii::t('app','Cancel'),array('class'=>'x2-button'))."\n";  ?>
<?php $this->endWidget(); ?>
</div>
