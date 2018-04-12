<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use sky\emailqueue\models\EmailQueue;
use sky\emailqueue\Module;

/* @var $this yii\web\View */
/* @var $model sky\emailqueue\models\EmailQueue */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Email Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-queue-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'time_send:dateTime',
            'send_at:dateTime',
            'subject',
            'to',
            //'data',
            'type',
            [
                'attribute' => 'server_id',
                'value' => isset(Module::$app->serverAvaliable[$model->server_id]) ? Module::$app->serverAvaliable[$model->server_id] : null,
            ],
            [
                'attribute' => 'status',
                'value' => EmailQueue::getStatus($model->status),
            ],
            'created_at:dateTime',
        ],
    ]) ?>

</div>
