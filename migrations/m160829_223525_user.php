<?php

use yii\db\Migration;

class m160829_223525_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(45)->notNull(),
            'surname' => $this->string(45)->notNull(),
            'password' => $this->string(255)->notNull(),
            'access_token' => $this->string(255)->defaultExpression('NULL')->unique(),
            'create_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
