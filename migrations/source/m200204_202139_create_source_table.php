<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_details}}`.
 */
class m200204_202139_create_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->db = 'source_db';
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_details}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull(),
            'surname' => $this->string(150)->notNull(),
            'email' => $this->string(255)->notNull(),
            'data' => $this->float()->notNull(),
            'data2' => $this->decimal(10,2)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_details}}');
    }

    /**
     * Use different DB connection than default.
     * 
     * @return yii\db\Connection
     */
    protected function getDb()
    {
        return \Yii::$app->source_db;
    }

}
