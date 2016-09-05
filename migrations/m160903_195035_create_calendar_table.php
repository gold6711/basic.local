<?php

use yii\db\Migration;

/**
 * Handles the creation of table `calendar`.
 */
class m160903_195035_create_calendar_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('calendar', [
            'id' => $this->primaryKey(),
            'text'=> $this->text()->notNull(),
            'creator'=> $this->integer(5)->notNull(),
            'event_start' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'event_end' => $this->dateTime()->defaultExpression('NULL'),
        ]);
        $this->addForeignKey('FK_creator', 'calendar', 'creator', 'users', 'id', 'NO ACTION', 'NO ACTION');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('calendar');
    }
}
