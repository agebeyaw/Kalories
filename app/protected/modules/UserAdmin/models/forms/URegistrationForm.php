<?php

class URegistrationForm extends User {

    public $captcha;
    public $login;
    public $password;
    public $repeat_password;

    public function rules() {
        return array(
            array('captcha', 'captcha'),
            array('login, password, repeat_password, captcha', 'required'),
            array('password', 'compare', 'compareAttribute' => 'repeat_password'),
            array('login', 'unique'),
            array('login', 'length', 'max' => 50),
            array('login', 'forbiddenNames'),
            array('login, password', 'purgeXSS'),
        );
    }

    /**
     * forbiddenNames 
     *
     * Don't allow register with some names
     */
    public function forbiddenNames() {
        foreach ($this->_getForbiddenNamesList() as $forbiddenName) {
            if (stripos($this->login, $forbiddenName) !== false) {
                $this->addError('login', Yii::t("UserAdminModule.LoginForm", "Choose another login please"));
                return false;
            }
        }

        return true;
    }

    /**
     * _getForbiddenNamesList 
     * 
     * @return array
     */
    private function _getForbiddenNamesList() {
        return array(
            'admin',
            'moderator',
        );
    }

    public function attributeLabels() {
        return array(
            'captcha' => Yii::t("UserAdminModule.LoginForm", "Captcha"),
            'login' => Yii::t("UserAdminModule.LoginForm", "Login"),
            'password' => Yii::t("UserAdminModule.LoginForm", "Password"),
            'repeat_password' => Yii::t("UserAdminModule.LoginForm", 'Repeat password'),
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
            'password' => $this->password, // Already hashed after save in User
        ));

        if (!$user) {
            $this->addError('password', Yii::t("UserAdminModule.LoginForm", "Wrong login or password"));
            return false;
        } else {
            $name = new CUserIdentity($user->id, null);
            Yii::app()->user->login($name, 0);

            return true;
        }
    }

}
