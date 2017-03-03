<?php

/**
 * This is the model class for table "meals".
 *
 * The followings are the available columns in table 'meals':
 * @property integer $id
 * @property integer $user_id
 * @property integer $date
 * @property string $text
 * @property string $number_of_calories
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Meals extends CActiveRecord {

    public $from_date;
    public $to_date;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Meals the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'meals';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
        array('date, time, number_of_calories', 'required'),        
        array('time', 'date', 'format' => 'hh:mm:ss', 'allowEmpty' => false),
        array('date', 'date', 'format' => 'yyyy-mm-dd', 'allowEmpty' => false),
        array('user_id', 'numerical', 'integerOnly' => true),
        array('text', 'length', 'max' => 50),
        array('number_of_calories', 'numerical', 'integerOnly' => false, 'min' => 0, 'max' => 10000),
        // The following rule is used by search().
// Please remove those attributes that should not be searched.
        array('id, user_id, date, text, number_of_calories,from_date, to_date', 'safe', 'on' => 'search'),
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
            'time' => 'Time',
            'text' => 'Text',
            'number_of_calories' => 'Number Of Calories',
        );
    }

    public function fetchTotalCalories($records) {
        $calories = 0;
        foreach ($records as $record)
            $calories+=$record->number_of_calories;
        return $calories;
    }

    public function getToatlByDate($date, $estimated) {
        $totalConsumed = Yii::app()->db->createCommand("SELECT SUM(number_of_calories) FROM meals where user_id=" . Yii::app()->user->id . " AND date='" . $date . "'")->queryScalar();
        if ($totalConsumed > $estimated) {
            return "<b><font color='red'>" . $totalConsumed . "</font></b>";
        } else {
            return "<b><font color='green'>" . $totalConsumed . "</font></b>";
        }
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

        $criteria = new CDbCriteria;

        if (!empty($this->from_date) && empty($this->to_date)) {
            $criteria->condition = "date >= '" . $this->from_date . "'";  // date is database date column field
        } elseif (!empty($this->to_date) && empty($this->from_date)) {
            $criteria->condition = "date <= '" . $this->to_date . "'";
        } elseif (!empty($this->to_date) && !empty($this->from_date)) {
            $criteria->condition = "date >= '" . $this->from_date . "' and date <= '" . $this->to_date . "'";
        }
        // if (!User::isSuperAdmin()) {
        $criteria->addCondition("user_id = " . Yii::app()->user->id, "AND");
        // }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date DESC',
            )
        ));
    }

}
