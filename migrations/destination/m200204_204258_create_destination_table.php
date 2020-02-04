<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_details}}`.
 */
class m200204_204258_create_destination_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->db = 'destination_db';
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_details}}', [
            'id' => $this->primaryKey(),
            'fullname' => $this->char(255)->notNull(),
            'e_mail' => $this->char(255)->notNull(),
            'balance' => $this->decimal(10,2)->notNull(),
            'totalpurchase' => $this->decimal(10,2)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_details}}');
    }

    /**
     * Use different DB connection than default.
     * 
     * @return yii\db\Connection
     */
    protected function getDb()
    {
        return \Yii::$app->destination_db;
    }

}
