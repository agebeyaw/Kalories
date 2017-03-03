

<h1>View Meals #<?php echo $model->id; ?></h1>
<h2>
    <?php
    echo CHtml::link(
            Yii::t("ui", "Manage"), array("admin"), array("class" => "btn btn-small pull-right")
    );
    ?>
</h2>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'date',
        'time',
        'text',
        'number_of_calories',
    ),
));
?>
