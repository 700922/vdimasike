<?php

use yii\db\Migration;

/**
 * Class m181029_173844_rooms_messages
 */
class m181029_173844_rooms_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `messages` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `room_id` int(11) NOT NULL,
          `user_id` int(11) NOT NULL,
          `message` text COLLATE utf8_bin,
          `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
          `show_time` int(32) DEFAULT '0',
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`),
          KEY `room_id` (`room_id`),
          CONSTRAINT `FK_messages_rooms` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
          CONSTRAINT `FK_messages_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");

        $this->execute("CREATE TABLE `rooms` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `show_time` int(32) DEFAULT '0',
          `name` varchar(248) COLLATE utf8_bin DEFAULT NULL,
          PRIMARY KEY (`id`,`user_id`),
          KEY `user_id` (`user_id`),
          CONSTRAINT `FK_rooms_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181029_173844_rooms_messages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181029_173844_rooms_messages cannot be reverted.\n";

        return false;
    }
    */
}
