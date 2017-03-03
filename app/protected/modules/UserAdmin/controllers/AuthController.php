<?php

class AuthController extends Controller {

    public $freeAccess = true;

    public function actions() {
        return array(
            'captcha' => array('class' => 'CCaptchaAction')
        );
    }

    /**
     * actionLogin 
     */
    public function actionLogin() {
        // If you don't want use this login page, just uncomment "return false"
        //return false;


        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);

        //$this->layout = 'auth';

        $dir = CHtml::asset(__DIR__ . '/../assets/loginCss');
        Yii::app()->clientScript->registerCssFile($dir . '/bootstrap.min.css');
        Yii::app()->clientScript->registerCssFile($dir . '/style.css');

        Yii::import('UserAdmin.models.forms.*');
        $model = new ULoginForm;

        if (isset($_POST['ULoginForm'])) {
            $model->attributes = $_POST['ULoginForm'];

            if ($model->validate()) {

                // If user have role and this role have home page
                // then we redirect user there
                if (Yii::app()->user->returnUrl)
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    $this->redirect(Yii::app()->homeUrl);
            }
        }

        $this->render('login', compact('model'));
    }

    /**
     * actionLogout 
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * actionRegistration 
     */
    public function actionRegistration() {
        // If you want use this registration page, just delete "return false"
        // return false;


        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);


        //$this->layout = '//layouts/main';

        Yii::import('UserAdmin.models.forms.*');
        $model = new URegistrationForm;

        if (isset($_POST['URegistrationForm'])) {
            $model->attributes = $_POST['URegistrationForm'];

            $model->active = 1;
            $model->is_superadmin = 0;

            if ($model->save()) {
                $this->redirect(Yii::app()->homeUrl);
            }
        }

        $this->render('registration', compact('model'));
    }

}
