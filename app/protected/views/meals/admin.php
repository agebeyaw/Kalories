<?php
Yii::app()->clientScript->registerScript(
        'myHideEffect', '$(".alert-success").animate({opacity: 1.0}, 3000).fadeOut("slow");', CClientScript::POS_READY
);
?>

<?php if (Yii::app()->user->hasFlash('mealSaved')) { ?>
    <div class='alert alert-success centered'>
        <?php echo Yii::app()->user->getFlash('mealSaved'); ?>
    </div>
<?php } ?>

<div class="row">
    <div class="span9">
        <h1>Manage Meals</h1>

        <?php
        echo CHtml::link(
                '<i class="icon-plus-sign icon-white"></i> ' . Yii::t('ui', 'Add Meal'), array('create'), array('class' => 'btn btn-info')
        );
        ?>
        <?php
        echo CHtml::link(
                '<i class="icon-cog icon-white"></i> ' . Yii::t('ui', 'Daily Calories Limit Settings'), array('dailyGoal/admin'), array('class' => 'btn btn-success ')
        );
        ?>
        <br/> <br/>       
        <div class='form form-horizontal well-small'>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'page-form-filter-by-date',
                'enableAjaxValidation' => true,
            ));
            ?>
            <h5>You can filter your records by date (from-to)...</h5>
            <div class="control-group">
                <span class="control-label">From:</span>
                <div class='controls'>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'from_date', // name of post parameter
                        'value' => isset(Yii::app()->request->cookies['from_date']) ? Yii::app()->request->cookies['from_date']->value : '',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <span class="control-label">To:</span>
                <div class='controls'>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'to_date',
                        'value' => isset(Yii::app()->request->cookies['to_date']) ? Yii::app()->request->cookies['to_date']->value : '',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php
            echo CHtml::htmlButton(
                    '<i class="icon-ok icon-white"></i> ' . Yii::t("ui", "Go"), array(
                'class' => 'btn btn-primary controls',
                'type' => 'submit',
                    )
            );
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="span3">

        <h4>Calories Taken: Quick Stats</h4>
        <hr />
        <table class="table-bordered table">
            <tr class="info" >
                <th>Today</th>
                <td><?php echo User::getCurrentUser()->todayTotal; ?></td>
            </tr>
            <tr class="info">
                <th>This Week</th>
                <td><?php echo User::getCurrentUser()->thisWeekTotal; ?></td>
            </tr>
            <tr class="info">
                <th>Last Week</th>
                <td><?php echo User::getCurrentUser()->lastWeekTotal; ?></td>
            </tr>
            <tr class="info">
                <th>This Month</th>
                <td><?php echo User::getCurrentUser()->currentMonth; ?></td>
            </tr>
            <tr class="info">
                <th>Last Month</th>
                <td><?php echo User::getCurrentUser()->lastMonthTotal; ?></td>
            </tr>
            <tr class="info">
                <th>Past 7 Days</th>
                <td><?php echo User::getCurrentUser()->pastSevenDaysTotal; ?></td>
            </tr>
        </table>

    </div>
</div>
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
        array('name' => 'time', 'header' => 'Time'),
        array('name' => 'text', 'header' => 'Text'),
        array(
            'name' => 'number_of_calories',
            'type' => 'text',
            'header' => 'Number Of Calories',
            'footer' => "Total: <b>" . $model->fetchTotalCalories($model->search()->getData()) . "</b>",
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        ),
    ),
));
?>

