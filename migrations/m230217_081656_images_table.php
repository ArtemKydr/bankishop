<?php

use yii\db\Migration;

/**
 * Class m230217_081656_images_table
 */
class m230217_081656_images_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('images', [
            'id' => $this->primaryKey(),
            'source' => $this->string(),
            'name' => $this->string(),
            'datetime' => $this->string(),
        ]);
    }


    public function safeDown()
    {
        $this->dropTable('user');
    }
}
