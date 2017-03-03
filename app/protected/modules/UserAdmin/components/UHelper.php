<?php

class UHelper {

    /**
     * attributeToggler 
     *
     * For CGridView
     * 
     * @param CActiveRecord $model 
     * @param string $attribute 
     * @param array $values - ("On", "Off") or ("Yes", "No") etc.
     * @return CHtml::ajaxLink
     */
    public static function attributeToggler($model, $attribute, $values = array('On', 'Off')) {
        if ($model->{$attribute} == 1) {
            return CHtml::ajaxLink(
                            "<span class='label label-success'>" . $values[0] . "</span>", array('toggleState', 'id' => $model->id, 'attribute' => $attribute, 'value' => 0), array('success' => "reloadGrid")
            );
        } else {
            return CHtml::ajaxLink(
                            "<span class='label label-warning'>" . $values[1] . "</span>", array('toggleState', 'id' => $model->id, 'attribute' => $attribute, 'value' => 1), array('success' => "reloadGrid")
            );
        }
    }

}
