<h1>View DailyGoal #<?php echo $model->id; ?></h1>
<h2>
    <?php
    echo CHtml::link(
            Yii::t("ui", "Manage"), array("admin"), array("class" => "btn btn-small pull-right")
    );
    ?>
</h2>
<br/>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        //'user_id',
        'date',
        'number_of_calories',
        array(
            'header' => 'Consumed',
            'name' => 'totalConsumed',
            'type' => 'raw',
            'value' => Meals::model()->getToatlByDate($model->date, $model->number_of_calories),
        ),
    ),
));
?>
        