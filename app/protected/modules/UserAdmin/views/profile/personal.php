<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".alert-success").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>

<?php if (Yii::app()->user->hasFlash('profileSaved')) { ?>
    <div class='alert alert-success centered'>
        <?php echo Yii::app()->user->getFlash('profileSaved'); ?>
    </div>
<?php } ?>
<h4 class='centered'>You can change your password (or other allowed fields here)</h4>

<div class='alert alert-info centered'>
    User login: <?php echo $user->login; ?>

</div>
<?php echo $this->renderPartial('_form', array('model' => $user)); ?>
