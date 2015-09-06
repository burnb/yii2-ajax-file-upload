<?php

use yii\db\Schema;
use yii\db\Migration;

class m150906_093709_add_file_upload_table extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `file_upload` (
                `id` INT(10) NOT NULL AUTO_INCREMENT,
                `filename` VARCHAR(255) NOT NULL,
                `text` VARCHAR(255) NULL DEFAULT NULL,
                `created_at` TIMESTAMP NULL DEFAULT NULL,
                `updated_at` TIMESTAMP NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB
        ");
    }

    public function down()
    {
        $this->dropTable('file_upload');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
