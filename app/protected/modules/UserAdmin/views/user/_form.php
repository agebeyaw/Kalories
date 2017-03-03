<div class='form form-horizontal well well-small'>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
        ),
    ));
    ?>

        <?php if ($model->isNewRecord OR ( $model->id != Yii::app()->user->id)): ?>
        <div class='control-group'>
                <?php echo $form->labelEx($model, 'active', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php
                echo $form->dropDownList(
                        $model, 'active', array('1' => 'On', '0' => 'Off'), array('class' => 'input-small')
                );
                ?>
        <?php echo $form->error($model, 'active'); ?>
            </div>
        </div>
    <?php endif ?>

        <?php if (User::isSuperAdmin() AND ( Yii::app()->user->id != $model->id)): ?>
        <div class='control-group'>
                <?php echo $form->labelEx($model, 'is_superadmin', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php
                echo $form->dropDownList(
                        $model, 'is_superadmin', User::getIsSuperAdminList(false), array('empty' => '', 'class' => 'input-small')
                );
                ?>
        <?php echo $form->error($model, 'is_superadmin'); ?>
            </div>
        </div>
        <?php endif ?>

    <div class='control-group'>
            <?php echo $form->labelEx($model, 'login', array('class' => 'control-label')); ?>
        <div class='controls'>
<?php echo $form->textField($model, 'login', array('class' => 'input-xxlarge', 'autocomplete' => 'off')); ?>
<?php echo $form->error($model, 'login'); ?>
        </div>
    </div>

    <div class='control-group'>
            <?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>
        <div class='controls'>
<?php echo $form->passwordField($model, 'password', array('class' => 'input-xxlarge')); ?>
<?php echo $form->error($model, 'password'); ?>
        </div>
    </div>

    <div class='control-group'>
            <?php echo $form->labelEx($model, 'repeat_password', array('class' => 'control-label')); ?>
        <div class='controls'>
<?php echo $form->passwordField($model, 'repeat_password', array('class' => 'input-xxlarge')); ?>
<?php echo $form->error($model, 'repeat_password'); ?>
        </div>
    </div>

    <br>
    <?php
    echo CHtml::htmlButton(
            $model->isNewRecord ?
                    '<i class="icon-plus-sign icon-white"></i> ' . Yii::t("UserAdminModule.admin", "Create") :
                    '<i class="icon-ok icon-white"></i> ' . Yii::t("UserAdminModule.admin", "Save"), array(
        'class' => 'btn btn-info controls',
        'type' => 'submit',
            )
    );
    ?>


<?php $this->endWidget(); ?>

</div>
