<?php

use yii\db\Migration;

/**
 * Class m240124_101110_init_carpet
 */
class m240124_101110_init_carpet extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE `company` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) UNIQUE,
  `image` varchar(255),
  `address` varchar(255),
  `phone` varchar(255),
  `status` boolean,
  `started_at` datetime
);

CREATE TABLE `type_employer` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `attendance` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `come_time` datetime,
  `go_time` datetime,
  `full_time` boolean,
  `daily_salary` int,
  `comment` varchar(255)
);

CREATE TABLE `customer` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `employer_id` int,
  `name` varchar(255),
  `phone_1` varchar(255),
  `phone_2` varchar(255),
  `address` varchar(255),
  `source` varchar(255),
  `level` varchar(255),
  `comment` varchar(255)
);

CREATE TABLE `clean_item` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `size` varchar(255),
  `price` int
);

CREATE TABLE `order_item` (
  `clean_item_id` int,
  `order_id` int,
  `size` int,
  `count` int
);

CREATE TABLE `order` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `customer_id` int,
  `record_id` int,
  `date` datetime,
  `status` varchar(255),
  `comment` varchar(255)
);

ALTER TABLE `order` ADD FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE set null ;

ALTER TABLE `order_item` ADD FOREIGN KEY (`clean_item_id`) REFERENCES `clean_item` (`id`) ON DELETE set null;

ALTER TABLE `order_item` ADD FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE set null;
";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240124_101110_init_carpet cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240124_101110_init_carpet cannot be reverted.\n";

        return false;
    }
    */
}
