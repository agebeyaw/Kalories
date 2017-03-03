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


</table>
