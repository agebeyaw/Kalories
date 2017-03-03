<?php

class ULoginForm extends CFormModel {

    public $login;
    public $password;
    public $rememberMe;

    public function rules() {
        return array(
            array('login, password', 'required'),
            array('login, password', 'purgeXSS'),
            array('rememberMe', 'boolean'),
            array('password', 'auth'),
        );
    }

    public function attributeLabels() {
        return array(
            'login' => Yii::t("UserAdminModule.LoginForm", "Login"),
            'password' => Yii::t("UserAdminModule.LoginForm", "Password"),
            'rememberMe' => Yii::t("UserAdminModule.LoginForm", "Remember me"),
        );
    }

    public function purgeXSS($attr) {
        $this->$attr = htmlspecialchars($this->$attr, ENT_QUOTES);
        return true;
    }

    /**
     * auth 
     */
    public function auth() {
        $user = User::model()->active()->findByAttributes(array(
            'login' => $this->login,
            'password' => User::getHashedPassword($this->password),
        ));

        if (!$user) {
            $this->addError('password', Yii::t("UserAdminModule.LoginForm", "Wrong login or password"));
            return false;
        } else {
            $name = new CUserIdentity($user->id, null);
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($name, $duration);

            return true;
        }
    }

}
