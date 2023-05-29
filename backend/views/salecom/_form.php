<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="salecom-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-1">

        </div>
        <div class="col-lg-10">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'emp_qty')->textInput(['type' => 'number']) ?>

            <?= $form->field($model, 'com_extra')->textInput() ?>

            <label for=""><?= $model->getAttributeLabel('status') ?></label>
            <?php echo $form->field($model, 'status')->widget(\toxor88\switchery\Switchery::className(), ['options' => ['label' => '', 'class' => 'form-control']])->label(false) ?>
            <br>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
