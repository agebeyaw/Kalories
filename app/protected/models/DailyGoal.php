<?php

/**
 * This is the model class for table "daily_goal".
 *
 * The followings are the available columns in table 'daily_goal':
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 * @property string $number_of_calories
 *
 * The followings are the available model relations:
 * @property User $user
 */
class DailyGoal extends CActiveRecord {

    public $totalConsumed;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DailyGoal the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'daily_goal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, number_of_calories', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('date', 'date', 'format' => 'yyyy-mm-dd', 'allowEmpty' => false),
            array('number_of_calories', 'numerical', 'integerOnly' => false, 'min' => 0, 'max' => 100000),
            array('date', 'ext.ECompositeUniqueValidator', 'with'=>'user_id'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, date, number_of_calories', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'date' => 'Date',
            'number_of_calories' => 'Calories Limit',
        );
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            $this->user_id = Yii::app()->user->id; //logged in user
            return true;
        }

        return false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('number_of_calories', $this->number_of_calories, true);
        //if (!User::isSuperAdmin()) {
        $criteria->condition = "user_id = " . Yii::app()->user->id;
        // }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date DESC',
            )
        ));
    }

}
