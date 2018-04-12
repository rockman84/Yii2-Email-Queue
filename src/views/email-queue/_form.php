<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sky\emailqueue\Module;
use sky\emailqueue\models\EmailQueue;

/* @var $this yii\web\View */
/* @var $model sky\emailqueue\models\EmailQueue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-queue-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'time_send')->textInput() ?>

            <?= $form->field($model, 'type')->textInput() ?>

            <?= $form->field($model, 'server_id')->dropDownList(Module::$app->serverAvaliable) ?>

            <?= $form->field($model, 'priority')->dropDownList(EmailQueue::getPriority()) ?>
            <?php if (!$model->isNewRecord) : ?>
                <?= $form->field($model, 'status')->textInput() ?>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'from')->textInput() ?>

            <?= $form->field($model, 'to')->textInput() ?>

            <?= $form->field($model, 'cc')->textInput() ?>

            <?= $form->field($model, 'bcc')->textInput() ?>

            <?= $form->field($model, 'subject')->textInput() ?>

            <?= $form->field($model, 'htmlBody')->textarea() ?>

            <?= $form->field($model, 'textBody')->textarea() ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
