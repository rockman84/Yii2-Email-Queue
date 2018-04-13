<?php
namespace sky\emailqueue\commands;

use sky\emailqueue\models\EmailQueue;
use sky\emailqueue\Module;
use Yii;

class EmailQueueController extends \yii\console\Controller
{
    public function actionChecking()
    {
        $success = [];
        $fail = [];
        foreach (EmailQueue::findReadyToSend(Module::$app->serverID)->all() as $queue) {
            if ($queue->status == EmailQueue::STATUS_WAITING_QUEUE && $queue->compose()->send()) {
                $queue->status = EmailQueue::STATUS_DONE;
                $queue->save();
                $success[] = $queue->id;
            } else {
                $fail[] = $queue->id;
            }
        }
        if ($fail) {
            Yii::error("fail send email", 'email queue');
        }
    }
}
