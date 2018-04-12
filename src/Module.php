<?php
namespace sky\emailqueue;

use Yii;

/*
 * ```
 * 'emailqueue' => [
 *      'serverID' => 1,
 *      'serverAvaliable' => [
 *          1 => 'My Email Server 1',
 *          2 => 'My Email Server 2',
 *          3 => 'My Email Server 3',
 *      ],
 *      'deleteAfterSend' => false,
 *      'emailSendPerSession' => 60,
 * ]
 */

/**
 * @property \yii\mail\BaseMailer $mailer
 */
class Module extends \yii\base\Module
{
    public $serverID = 1;
    
    public $serverAvaliable = [
        1 => 'Local Server'
    ];
    
    public $deleteAfterSend = false;
    
    public $emailSendPerSession = 100;
    
    /**
     *
     * @var \sky\emailqueue\Module
     */
    public static $app;
    
    protected $_mailer = null;

    public function init() {
        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'sky\emailqueue\commands';
        }
        parent::init();
        static::$app = $this;
    }
    
    public function getMailer()
    {
        if ($this->_mailer == null) {
            $this->_mailer = Yii::$app->mailer;
        }
        return $this->_mailer;
    }
    
    
    public function setMailer($class)
    {
        $this->_mailer = Yii::createObject($class);
    }
}
