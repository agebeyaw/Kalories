<?php

class SiteController extends Controller {

    public $freeAccess = true; 
    /* 
     * TO GO INTO MAINTENANCE
     * 
     * 1. change the default action here to 'maintenance'
     * 2. change the default controller on config to 'site'
     * 
     */
    public $defaultAction = 'setup';

    /**
     * Declares the behaviors.
     * @return array the behaviors
     */

    public function behaviors() {
        return array(
            'seo' => 'ext.seo.components.SeoControllerBehavior',
        );
    }

    /**
     * Declares class-based actions.
     * @return array the actions
     */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }


    public function actionSetup() {
        $parser = new CMarkdownParser();
        Yii::app()->clientScript->registerCss('TextHighligther', file_get_contents($parser->getDefaultCssFile()));

        $this->render('setup', array(
            'parser' => $parser,
        ));
    }

    public function actionMaintenance() {
        $this->layout = '/layouts/maintenance';
        $this->render('maintenance');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
