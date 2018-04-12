<?php

namespace sky\emailqueue\models;

use Yii;
use yii\helpers\ArrayHelper;
use sky\emailqueue\Module;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "email_queue".
 *
 * @property int $id
 * @property int $time_send
 * @property array $data
 * @property int $type
 * @property int $server_id
 * @property int $status
 * @property int $created_at
 * 
 * @property string $subject
 * @property string $htmlBody
 * @property string $textBody
 */
class EmailQueue extends \sky\yii\db\ActiveRecord
{
    const STATUS_WAITING_QUEUE = 0;
    const STATUS_DONE = 1;
    const STATUS_CANCEL = 2;
    const STATUS_PUSHED = 3;
    
    const PRIORITY_HIGH = 1;
    const PRIORITY_NORMAL = 2;
    const PRIORITY_LOW = 3;


    static $serverTask;

    protected $_dataMap = [
        'subject' => null,
        'htmlBody' => null,
        'textBody' => null,
        'from' => null,
        'replayTo' => null,
        'to' => null,
        'cc' => null,
        'bcc' => null,
        'attach' => null,
        'attachContent' => null,
        'embed' => null,
        'embedContent' => null
    ];
    
    public function init() {
        parent::init();
        $this->data = $this->_dataMap;
    }
    
    public function __get($name) {

        if (array_key_exists($name, $this->_dataMap)) {
            return $this->_dataMap[$name];
        }
        return parent::__get($name);
    }
    
    public function __set($name, $value) {
        if (array_key_exists($name, $this->_dataMap)) {
            return $this->_dataMap[$name] = $value;
        }
        return parent::__set($name, $value);
    }
    
    public function behaviors() {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ]
        ]);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server_id'], 'default', 'value' => Module::$app->serverID],
            [['time_send', 'type', 'server_id', 'status', 'created_at', 'send_at', 'priority', 'send_at'], 'integer'],
            [['server_id'], 'in', 'range' => array_keys(Module::$app->serverAvaliable)],
            [['status'], 'in', 'range' => array_keys(static::getStatus())],
            [['data'], 'safe'],
            [['time_send'], 'default', 'value' => time()],
            [['htmlBody', 'textBody', 'cc', 'bcc', 'from'], 'string'],
            [['data', 'server_id', 'htmlBody', 'subject', 'to', 'from'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_send' => 'Time Send',
            'subject' => 'Subject',
            'data' => 'Data',
            'type' => 'Type',
            'server_id' => 'Server ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
    
    public function setHtmlView($view, $params = [])
    {
        $this->htmlBody = Yii::$app->mailer->render($view, $params, Yii::$app->mailer->htmlLayout);
    }
    
    public function setTextView($view, $params = [])
    {
        $this->textBody = Yii::$app->mailer->render($view, $params, Yii::$app->mailer->textLayout);
    }

    public function afterFind() {
        foreach ($this->data as $attribute => $value) {
            if (array_key_exists($attribute, $this->_dataMap)) {
                $this->{$attribute} = $value;
            }
        }
        return parent::afterFind();
    }
    
    public function beforeSave($insert) {
        $this->data = $this->_dataMap;
        
        if ($this->getOldAttribute('status') != $this->status && $this->status == static::STATUS_DONE) {
            $this->send_at = time();
        }
        return parent::beforeSave($insert);
    }
    
    public static function findReadyToSend($serverID, $limit = 100)
    {
        return static::find()->where([
                'status' => static::STATUS_WAITING_QUEUE,
                'server_id' => $serverID,
            ])
            ->andWhere(['<=', 'time_send', time()])
            ->orderBy(['priority' => SORT_ASC, 'time_send' => SORT_ASC])
            ->limit($limit)
            ->all();
    }
    
    public function compose()
    {
        $message = Module::$app->mailer->createMessage();
        $message->setSubject($this->subject);
        $message->setHtmlBody($this->htmlBody);
    }
    
    public static function createQueue($params)
    {
        if (!static::$serverTask) {
            static::find();
        }
        return new static($params);
    }
    
    public static function getStatus($key = null)
    {
        $status = [
            static::STATUS_WAITING_QUEUE => 'Waiting',
            static::STATUS_DONE => 'Done',
            static::STATUS_CANCEL => 'Cancel',
            static::STATUS_PUSHED => 'Pushed',
        ];
        if ($key !== null) {
            return ArrayHelper::getValue($status, $key);
        }
        return $status;
    }
    
    public static function getPriority($key = null)
    {
        $priority = [
            static::PRIORITY_HIGH => 'High',
            static::PRIORITY_NORMAL => 'Normal',
            static::PRIORITY_LOW => 'Low'
        ];
        if ($key !== null) {
            return ArrayHelper::getValue($priority, $key);
        }
        return $priority;
    }
}
