<?php

use yii\db\Migration;

/**
 * Handles the creation of table `email_queue`.
 */
class m180406_114401_create_email_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('email_queue', [
            'id' => $this->bigPrimaryKey(),
            'time_send' => $this->integer()->unsigned()->notNull(),
            'data' => $this->json()->notNull(),
            'type' => $this->integer()->defaultValue(1),
            'server_id' => $this->integer()->notNull(),
            'priority' => $this->smallInteger()->defaultValue(2),
            'status' => $this->smallInteger()->defaultValue(0),
            'send_at' => $this->integer()->unsigned()->defaultValue(NULL),
            'created_at' => $this->integer()->unsigned()->defaultValue(NULL),
        ]);
        
        $this->createIndex('idx-email_queue-status', 'email_queue', 'status');
        $this->createIndex('idx-email_queue-server_id', 'email_queue', 'server_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('email_queue');
    }
}
