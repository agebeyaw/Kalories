<?php
$this->breadcrumbs = array(
    Yii::t("UserAdminModule.breadcrumbs", "Manage users") => array('admin'),
    Yii::t("UserAdminModule.breadcrumbs", "Details")
);
?>

<h2>
    <?php echo Yii::t("UserAdminModule.admin", "User details") . ' - ' . $model->login; ?>
    <?php
    echo CHtml::link(
            Yii::t("UserAdminModule.admin", "Manage"), array("admin"), array("class" => "btn btn-small pull-right")
    );
    ?>
    <?php
    echo CHtml::link(
            Yii::t("UserAdminModule.admin", "Edit"), array("update", "id" => $model->id), array("class" => "btn btn-small pull-right")
    );
    ?>
</h2>

<table class='table table-condensed table-bordered'>
    <tr>
        <th class='grayHeader' width='50%'><h2 class='centered'><?php echo Yii::t("UserAdminModule.admin", "Roles"); ?></h2></th>
<th class='grayHeader' width='50%'><h2 class='centered'><?php echo Yii::t("UserAdminModule.admin", "Additional tasks"); ?></h2></th>
</tr>
<tr>
    <td style='padding:0 10px;'>
            <?php if (Yii::app()->user->getFlash('roleSaved')): ?>
            <h4 class='alert alert-success centered hide-on-click'>
            <?php echo Yii::t("UserAdminModule.admin", "Saved"); ?>
            </h4>
        <?php endif ?>

        <?php $roleForm = $this->beginWidget('CActiveForm'); ?>

        <?php
        echo $roleForm->checkBoxList(
                $model, 'roleIds', CHtml::listData(UserRole::model()->findAll(), 'code', 'name'), array(
            'template' => "<label class='checkbox'>{input} {label}</label>",
            'separator' => '',
                )
        );
        ?>

        <br>
        <?php
        echo CHtml::htmlButton(
                '<i class="icon-ok icon-white"></i> ' . Yii::t("UserAdminModule.admin", "Save"), array(
            'class' => 'btn btn-info',
            'type' => 'submit',
                )
        );
        ?>

        <?php $this->endWidget(); ?>
    </td>

    <td style='padding:0 10px;'>
        <?php if (Yii::app()->user->getFlash('taskSaved')): ?>
            <h4 class='alert alert-success centered hide-on-click'>
            <?php echo Yii::t("UserAdminModule.admin", "Saved"); ?>
            </h4>
        <?php endif ?>

        <?php $taskForm = $this->beginWidget('CActiveForm'); ?>

        <?php
        echo $taskForm->checkBoxList(
                $model, 'taskIds', CHtml::listData(UserTask::model()->findAll("code != 'freeAccess'"), 'code', 'name'), array(
            'template' => "<label class='checkbox'>{input} {label}</label>",
            'separator' => '',
                )
        );
        ?>

        <br>
        <?php
        echo CHtml::htmlButton(
                '<i class="icon-ok icon-white"></i> ' . Yii::t("UserAdminModule.admin", "Save"), array(
            'class' => 'btn btn-info',
            'type' => 'submit',
                )
        );
        ?>

<?php $this->endWidget(); ?>
    </td>
</tr>
</table>
