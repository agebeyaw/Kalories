<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $active
 * @property string $login
 * @property string $password
 * @property integer $is_superadmin
 *
 */
class User extends CActiveRecord {

    const SALT = 'nlf8BlbU6nsd947haoNwq2Opjhy5nm';

    /**
     * Filled in afterFind() method 
     * 
     * @var string
     */
    public $oldPass;

    /**
     * Used in _form on create and update
     * 
     * @var string
     */
    public $repeat_password;

    /**
     * getHashedPassword 
     * 
     * @param string $password 
     * @return string
     */
    public static function getHashedPassword($password) {
        return md5($password . self::SALT);
    }

    /**
     * getCurrentUser 
     * 
     * @return CActiveRecord User
     */
    public static function getCurrentUser() {
        if (Yii::app()->user->isGuest)
            return null;
        else
            return self::model()->active()->findByPk((int) Yii::app()->user->id);
    }

    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'active = 1 OR is_superadmin = 1',
            ),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'user';
    }

    public function rules() {
        return array(
            array('login, password, repeat_password, is_superadmin', 'required'),
            array('login, password, is_superadmin', 'purgeXSS'),
            array('password', 'compare', 'compareAttribute' => 'repeat_password'),
            array('is_superadmin, active', 'numerical', 'integerOnly' => true),
            array('login', 'length', 'max' => 50),
            array('login', 'unique'),
            array('password', 'length', 'max' => 255),
            array('is_superadmin', 'unsafe', 'on' => array('create', 'update')),
            array('id, login, password, active, is_superadmin, findByRole', 'safe', 'on' => 'search'),
        );
    }

    public function purgeXSS($attr) {
        $this->$attr = htmlspecialchars($this->$attr, ENT_QUOTES);
        return true;
    }

    public function relations() {
        return array(
            'pastSevenDaysTotal' => array(self::STAT, 'Meals', 'user_id', 'select' => 'SUM(number_of_calories)', 'condition' => 'user_id=' . Yii::app()->user->id . ' AND date > DATE_SUB(NOW(), INTERVAL 1 WEEK)'),
            'lastMonthTotal' => array(self::STAT, 'Meals', 'user_id', 'select' => 'SUM(number_of_calories)', 'condition' => 'user_id=' . Yii::app()->user->id . ' AND date > DATE_SUB(NOW(), INTERVAL -1 MONTH)'),
            'thisWeekTotal' => array(self::STAT, 'Meals', 'user_id', 'select' => 'SUM(number_of_calories)', 'condition' => 'user_id=' . Yii::app()->user->id . ' AND WEEKOFYEAR(date)=WEEKOFYEAR(NOW())'),
            'lastWeekTotal' => array(self::STAT, 'Meals', 'user_id', 'select' => 'SUM(number_of_calories)', 'condition' => 'user_id=' . Yii::app()->user->id . ' AND WEEKOFYEAR(date)=WEEKOFYEAR(NOW())-1'),
            'todayTotal' => array(self::STAT, 'Meals', 'user_id', 'select' => 'SUM(number_of_calories)', 'condition' => 'user_id=' . Yii::app()->user->id . ' AND DATE(date) = DATE(NOW())'),
            'currentMonth' => array(self::STAT, 'Meals', 'user_id', 'select' => 'SUM(number_of_calories)', 'condition' => 'user_id=' . Yii::app()->user->id . ' AND YEAR(date) = YEAR(NOW()) AND MONTH(date)=MONTH(NOW())'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'login' => Yii::t("UserAdminModule.label", 'Login'),
            'active' => Yii::t("UserAdminModule.label", 'Active'),
            'password' => Yii::t("UserAdminModule.label", 'Password'),
            'repeat_password' => Yii::t("UserAdminModule.label", 'Repeat password'),
            'is_superadmin' => Yii::t("UserAdminModule.label", 'Superadmin'),
            'findByRole' => Yii::t("UserAdminModule.label", 'Role'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('active', $this->active);

        // Don't show superadmins for others
        if (self::isSuperAdmin())
            $criteria->compare('is_superadmin', $this->is_superadmin);
        else
            $criteria->compare('is_superadmin', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', 20),
            ),
        ));
    }

    //=========== For grid, view etc ===========

    /**
     * getIsSuperAdminList 
     * 
     * @param boolean $withLabelInfo - false for dropDownList
     *
     * @return array
     */
    public static function getIsSuperAdminList($withLabelInfo = true) {
        if ($withLabelInfo) {
            return array(
                '0' => Yii::t("UserAdminModule.admin", "No"),
                '1' => "<span class='label label-info'>" . Yii::t("UserAdminModule.admin", "Yes") . "</span>",
            );
        } else {
            return array(
                '0' => Yii::t("UserAdminModule.admin", "No"),
                '1' => Yii::t("UserAdminModule.admin", "Yes"),
            );
        }
    }

    /**
     * getIsSuperAdminValue 
     * 
     * @param int $value 
     * @return string
     */
    public static function getIsSuperAdminValue($value) {
        $ar = self::getIsSuperAdminList();
        return isset($ar[$value]) ? $ar[$value] : '';
    }

    //-----------  For grid, view etc -----------

    /**
     * afterFind 
     *
     * Save password, so we know beforeSave() if it has been changed
     * and encrypt it
     * 
     * @return void
     */
    protected function afterFind() {
        $this->oldPass = $this->password;
        $this->repeat_password = $this->password;

        parent::afterFind();
    }

    /**
     * beforeSave 
     *
     * Encrypt password if it has been changed
     * 
     * @return boolean
     */
    protected function beforeSave() {
        if ($this->oldPass != $this->password)
            $this->password = self::getHashedPassword($this->password);

        // Make sure that user can't deactive himself
        if (Yii::app()->user->id == $this->id)
            $this->active = 1;

        return parent::beforeSave();
    }

    /**
     * beforeDelete 
     * 
     * Prevent deleting yourself + prevent delet superadmins by not superadmins
     *
     * @return boolean
     */
    protected function beforeDelete() {
        if (Yii::app()->user->id == $this->id)
            return false;

        if (!self::isSuperAdmin() AND ( $this->is_superadmin == 1))
            return false;

        return parent::beforeDelete();
    }

    public static function isSuperAdmin() {
        $user = User::model()->active()->findByPk((int) Yii::app()->user->id);
        if ($user) {
            if ($user->is_superadmin == 1) {
                return true;
            }
        }
        return false;
    }

}
