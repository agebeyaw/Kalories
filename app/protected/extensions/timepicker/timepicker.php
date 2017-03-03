<?php

class timepicker extends CWidget {

    public $assets = '';
    public $options = array();
    public $skin = 'default';
    public $model;
    public $name;
    public $language;
    public $select = 'datetime'; # also avail 'time' and 'date'

    public function init() {
        $this->assets = Yii::app()->assetManager->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');

        Yii::app()->clientScript
                ->registerCoreScript('jquery')
                ->registerCoreScript('jquery.ui')
                ->registerScriptFile($this->assets . '/js/jquery.ui.timepicker.js')
                // ->registerCssFile($this->assets . '/css/ui.theme.smoothness/jquery-ui-1.7.3.css')
                ->registerCssFile($this->assets . '/css/timepicker.css');


        $default = array(
            'dateFormat' => 'yy-mm-dd',
            'timeFormat' => 'hh:mm:ss',
            'showOn' => 'button',
            'showSecond' => false,
            'changeMonth' => false,
            'changeYear' => false,
            'value' => '',
            'tabularLevel' => null,
        );

        $this->options = array_merge($default, $this->options);

        $options = empty($this->options) ? '' : CJavaScript::encode($this->options);

        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->id, "
			jQuery('#{$this->id}')." . $this->select . "picker($options);
		");

        parent::init();
    }

    public function run() {
        $this->render($this->skin);
    }

}

?>