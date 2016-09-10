<?php

use yii\db\Migration;

/**
 * Handles the creation of table `calendar_access`.
 */
class m160903_195202_create_calendar_access_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('calendar_access', [
            'id' => $this->primaryKey(),
            'user_owner'=>$this->integer(5)->notNull(),
            'user_guest'=>$this->integer(5)->notNull(),
            'date'=>$this->date()->notNull(),

        ]);
        $this->addForeignKey('FK_user_owner', 'calendar_access', 'user_owner', 'users', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('FK_user_guest', 'calendar_access', 'user_guest', 'users', 'id', 'NO ACTION', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('calendar_access');
    }
}
