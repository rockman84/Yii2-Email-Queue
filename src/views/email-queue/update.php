<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model sky\emailqueue\models\EmailQueue */

$this->title = 'Update Email Queue: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Email Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-queue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
