<?php

use yii\db\Migration;

/**
 * Class m240301_035812_create_ordeLocation
 */
class m240301_035812_create_ordeLocation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_location', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
            'address' => $this->string(),
        ]);

        $this->addForeignKey('fk_order_location_order', 'order_location', 'order_id', 'order', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240301_035812_create_ordeLocation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240301_035812_create_ordeLocation cannot be reverted.\n";

        return false;
    }
    */
}
