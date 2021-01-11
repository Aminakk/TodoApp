<?php

use yii\db\Migration;

/**
 * Class m201113_063938_add_user_id_list_table
 */
class m201113_063938_add_user_id_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('todo_list', 'user_id', $this->integer());
        $this->addForeignKey(
            'fk-todo_list-user_id',
            'todo_list',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-todo_list-user_id','todo_list');
        $this->dropColumn('todo_list', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201113_063938_add_user_id_list_table cannot be reverted.\n";

        return false;
    }
    */
}
