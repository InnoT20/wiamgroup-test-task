<?php

use yii\db\Migration;

/**
 * Class m231125_112016_add_image_table
 */
class m231125_112016_add_image_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'imageId' => $this->integer()->notNull(),
            'status' => $this->string()->notNull()
        ]);
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%image}}');
    }
}
