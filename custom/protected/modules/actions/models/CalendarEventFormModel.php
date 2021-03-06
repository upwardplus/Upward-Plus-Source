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

class CalendarEventFormModel extends EventFormModel {
    
    public $invite;
    public $emailAddresses;
    public $reminder;
    public $notificationUsers = 'assigned';
    public $notificationTime = 15;
    
    public function attributeLabels(){
        return array_merge(parent::attributeLabels(), array(
            'allDay' => Yii::t('actions', 'All Day'),
            'eventSubtype' => Yii::t('actions', 'Task Type'), // Event Subtype
            'eventStatus' => Yii::t('actions', 'Status'), // Event Status
            'associationType' => Yii::t('actions', 'Association Type'),
            'color' => Yii::t('actions', 'Calendar Color'), // Color
            'emailAddresses' => Yii::t('actions','Enter email addresses, one per line'),
        ));
    }
    
    public function rules(){
        return array_merge(parent::rules(),array(
            array(
                'invite', 'numerical', 'integerOnly'=>true,
            ),
            array (
                'emailAddresses, reminder, notificationUsers, notificationTime', 'safe',
            ),
        ));
    }
    
     public function validate ($attributes=null, $clearErrors=true) {
        $valid = parent::validate ();
        $attributes = $this->getAttributes ();
        $this->action->setX2Fields ($attributes);
        $this->action->type = $this->type;
        if($this->invite){
            $this->action->attachBehavior('CalendarInviteBehavior', array(
                'class' => 'CalendarInviteBehavior',
                'emailAddresses' => array_map('chop', explode("\n", $this->emailAddresses)),
            ));
        }
        $valid &= $this->action->validate ();
        // synchronize errors
        $this->addErrors ($this->action->getErrors ());
        $this->action->addErrors ($this->getErrors ());
        return $valid;
    }

    public function renderReminderConfig() {
        if ($this->action)
            return $this->action->renderReminderConfig(array('style' => 'display: none'), $this);
    }
}

?>
