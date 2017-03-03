<?php

/**
 * UserAdminModule 
 * 
 */
class UserAdminModule extends CWebModule {

    public function init() {
        $this->setImport(array(
            'UserAdmin.models.*',
            'UserAdmin.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            $dir = CHtml::asset(__DIR__ . '/assets');

            Yii::app()->clientScript->registerCssFile($dir . '/style.css');
            Yii::app()->clientScript->registerScriptFile($dir . '/common.js');

            return true;
        } else
            return false;
    }

}
