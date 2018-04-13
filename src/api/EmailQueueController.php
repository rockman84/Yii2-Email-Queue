<?php
namespace sky\emailqueue\api;

use sky\emailqueue\models\EmailQueue;

class EmailQueueController extends \yii\rest\ActiveController
{
    public $modelClass = 'sky\emailqueue\models\EmailQueue';
    
    public function actionIndex()
    {
        return EmailQueue::findReadyToSend($serverID)->all();
    }
}