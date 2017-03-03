<h2>Login</h2>

<div class='form form-horizontal well-small'>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'login'),
        'id' => 'login-form',
            ))
    ?>

    <div class="control-group">
        <?php echo $form->label($model, 'login', array('class' => 'control-label')) ?>
        <div class='controls'>
            <?php echo $form->textField($model, 'login', array('autocomplete' => 'off')) ?>
            <?php echo $form->error($model, 'login') ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->label($model, 'password', array('class' => 'control-label')) ?>
        <div class='controls'>
            <?php echo $form->passwordField($model, 'password') ?>
            <?php echo $form->error($model, 'password') ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->label($model, 'rememberMe', array('class' => 'control-label')) ?>
        <div class='controls'>
            <?php echo $form->checkBox($model, 'rememberMe') ?>
        </div>
    </div>
    <div class="control-group controls">
        <?php echo CHtml::link(Yii::t('ui', 'Register a new user'), array('/UserAdmin/auth/registration')); ?> 
    </div>
    <?php
    echo CHtml::htmlButton(
            '<i class="icon-ok icon-white"></i> ' . Yii::t("ui", "Login"), array(
        'class' => 'btn btn-info controls',
        'type' => 'submit',
            )
    );
    ?>

    <?php $this->endWidget() ?>

</div>
