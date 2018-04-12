<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use sky\emailqueue\models\EmailQueue;
use sky\emailqueue\Module;
/* @var $this yii\web\View */
/* @var $searchModel sky\emailqueue\models\EmailQueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Queues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-queue-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <p>
        <?= Html::a('Create Email Queue', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'time_send:relativeTime',
            'send_at:dateTime',
            'type',
            [
                'attribute' => 'server_id',
                'filter' => Module::$app->serverAvaliable,
                'value' => function ($model) {
                    return isset(Module::$app->serverAvaliable[$model->server_id]) ? Module::$app->serverAvaliable[$model->server_id] : null;
                }
            ],
            [
                'attribute' => 'priority',
                'filter' => EmailQueue::getPriority(),
                'value' => function ($model) {
                    return EmailQueue::getPriority($model->priority);
                }
            ],  
            [
                'attribute' => 'status',
                'filter' => EmailQueue::getStatus(),
                'value' => function ($model) {
                    return EmailQueue::getStatus($model->status);
                }
            ],
            'created_at:dateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
