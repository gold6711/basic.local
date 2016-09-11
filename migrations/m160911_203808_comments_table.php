<?php

use yii\db\Migration;

class m160911_203808_comments_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('comments',[
           'id' => $this->primaryKey(), // можно 'id' => 'pk' см. http://www.yiiframework.com/doc-2.0/yii-db-querybuilder.html#getColumnType()-detail
           'user_id' => $this->integer(11)->notNull(),
           'name' => $this->string()->notNull()->unique(), // можно 'string NOT NULL'
           'text' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('FK_user_id', 'comments', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
