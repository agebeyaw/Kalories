<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".alert-success").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>

<?php if (Yii::app()->user->hasFlash('dialyGoalSaved')) { ?>
    <div class='alert alert-success centered'>
        <?php echo Yii::app()->user->getFlash('dialyGoalSaved'); ?>
    </div>
<?php } ?>

<h1>Manage Daily Calories Limit</h1>

<?php
echo CHtml::link(
        '<i class="icon-plus-sign icon-white"></i> ' . Yii::t('ui', 'New Daily Calories Limit'), array('create'), array('class' => 'btn btn-info')
);
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'template' => "{items}",
    'columns' => array(
        array(
            'name' => 'date',
            'header' => 'Date',
            'type' => 'raw',
            'value' => 'CHtml::link($data->date,Yii::app()->createUrl("meals/view", array("id"=>$data->id)))',
        ),
        array(
            'name' => 'number_of_calories',
            'type' => 'text',
            'header' => 'Calories Limit',
        ),
        array(
            'header' => 'Consumed',
            'name' => 'totalConsumed',
            'type' => 'raw',
            'value' => 'Meals::model()->getToatlByDate($data->date, $data->number_of_calories)',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        ),
    ),
));
?>
