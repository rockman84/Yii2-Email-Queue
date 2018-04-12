<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model sky\emailqueue\models\EmailQueue */

$this->title = 'Create Email Queue';
$this->params['breadcrumbs'][] = ['label' => 'Email Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
