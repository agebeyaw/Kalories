<?php $this->breadcrumbs = array(Yii::t("UserAdminModule.breadcrumbs", "Manage users")); ?>

<?php $pageSize = Yii::app()->user->getState("pageSize", 20); ?>
<h2><?php echo Yii::t('UserAdminModule.admin', 'User management'); ?></h2>

<?php
echo CHtml::link(
        '<i class="icon-plus-sign icon-white"></i> ' . Yii::t('UserAdminModule.admin', 'Create'), array('create'), array('class' => 'btn btn-info')
);
?>


<?php $form = $this->beginWidget("CActiveForm"); ?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'filter' => $model,
    'type' => 'striped bordered condensed',
    'columns' => array(
        array(
            'header' => '№',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'htmlOptions' => array(
                'width' => '25',
                'class' => 'centered'
            )
        ),
        array(
            'name' => 'login',
            'value' => 'CHtml::link($data->login, array("view", "id"=>$data->id))',
            'type' => 'raw',
        ),
        array(
            'name' => 'is_superadmin',
            'filter' => User::getIsSuperAdminList(false),
            'value' => 'User::getIsSuperAdminValue($data->is_superadmin)',
            'type' => 'raw',
            'visible' => User::isSuperAdmin(),
            'htmlOptions' => array(
                'width' => '55',
                'style' => 'text-align:center',
            )
        ),
        array(
            'name' => 'active',
            'filter' => array(1 => 'On', 0 => 'Off'),
            'value' => 'UHelper::attributeToggler($data, "active")',
            'type' => 'raw',
            'htmlOptions' => array(
                'width' => '55',
                'style' => 'text-align:center',
            )
        ),
        array(
            'id' => 'autoId',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}',
            'htmlOptions' => array('style' => 'width: 50px'),
            'buttons' => array(
                'delete' => array(
                    'visible' => '($data->id != Yii::app()->user->id)',
                ),
            ),
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(20 => 20, 50 => 50, 100 => 100, 200 => 200), array(
                'onchange' => "$.fn.yiiGridView.update('user-grid',{ data:{pageSize: $(this).val() }})",
                'style' => 'width:50px'
            )),
        ),
    ),
));
?>


<script>
    function reloadGrid(data) {
        $.fn.yiiGridView.update('user-grid');
    }
</script>
<!--
<?php echo CHtml::ajaxSubmitButton("", array(), array(), array("style" => "visibility:hidden;")); ?>
<?php
echo CHtml::ajaxSubmitButton(
        Yii::t("UserAdminModule.admin", "Delete selected"), array("deleteSelected"), array("success" => "reloadGrid"), array(
    "class" => "btn btn-small pull-right",
    "confirm" => Yii::t("UserAdminModule.admin", "Delete selected elements ?"),
        )
);
?>
<?php $this->endWidget(); ?>
-->
