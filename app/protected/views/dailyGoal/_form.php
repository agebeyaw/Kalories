<?php
/* @var $this DailyGoalController */
/* @var $model DailyGoal */
/* @var $form CActiveForm */
?>

<div class='form form-horizontal well well-small'>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'daily-goal-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'date', array('class' => 'control-label')); ?>
        <div class='controls'>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date',
                'name' => 'date',
                'value' => Yii::app()->dateFormatter->format("y-M-d", $model->date),
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd',
                    'defaultDate' => Yii::app()->dateFormatter->format("y-M-d", time()),
                    'altFormat' => 'yy-mm-dd',
                    'changeMonth' => true,
                    'changeYear' => true,
                    'appendText' => 'yyyy-mm-dd',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            //echo $form->textField($model, 'date'); 
            ?>
            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>
    <?php //echo $form->hiddenField($model, 'user_id', array('value' => Yii::app()->user->id)); ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'number_of_calories', array('class' => 'control-label')); ?>
        <div class='controls'>
            <?php echo $form->textField($model, 'number_of_calories', array('size' => 6, 'maxlength' => 6)); ?>
            <?php echo $form->error($model, 'number_of_calories'); ?>
        </div>
    </div>

    <br>
    <?php
    echo CHtml::htmlButton(
            $model->isNewRecord ?
                    '<i class="icon-plus-sign icon-white"></i> ' . Yii::t("UserAdminModule.admin", "Create") :
                    '<i class="icon-ok icon-white"></i> ' . Yii::t("UserAdminModule.admin", "Save"), array(
        'class' => 'btn btn-info controls',
        'type' => 'submit',
            )
    );
    ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->