<?php

namespace app\models;

use yii\db\ActiveRecord;

class Destination extends ActiveRecord
{

    /**
     * Return table name.
     *
     * @return string.
     */
    public static function tableName()
    {
        return '{{customer_details}}';
    }

    /**
     * Use different DB connection than default.
     * 
     * @return yii\db\Connection
     */
    public static function getDb()
    {
        return \Yii::$app->destination_db;
    }
}
