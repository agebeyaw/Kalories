<h2>Register New User</h2>

<div class='form form-horizontal well-small'>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
        ),
    ));
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'login', array('class' => 'control-label')); ?>
        <div class='controls'>
            <?php echo $form->textField($model, 'login', array('autocomplete' => 'off')); ?>
            <?php echo $form->error($model, 'login'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>
        <div class='controls'>
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>
    <div class='control-group'>
        <?php echo $form->labelEx($model, 'repeat_password', array('class' => 'control-label')); ?>
        <div class='controls'>
            <?php echo $form->passwordField($model, 'repeat_password'); ?>
            <?php echo $form->error($model, 'repeat_password'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'captcha', array('class' => 'control-label')); ?>
        <div class='controls'>
            <?php
            $this->widget('CCaptcha', array(
                'clickableImage' => true,
                'showRefreshButton' => false,
            ))
            ?>
            <?php echo $form->textField($model, 'captcha') ?>
            <?php echo $form->error($model, 'captcha'); ?>
        </div>
    </div>
    <?php
    echo CHtml::htmlButton(
            '<i class="icon-ok icon-white"></i> ' . Yii::t("UserAdminModule.LoginForm", "Register"), array(
        'class' => 'btn btn-info controls',
        'type' => 'submit',
            )
    );
    ?>

    <?php $this->endWidget(); ?>
</div>
