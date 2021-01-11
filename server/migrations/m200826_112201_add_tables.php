<?php

use yii\db\Migration;

/**
 * Class m200826_112201_add_tables
 */
class m200826_112201_add_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('todo_list', [
            'id' =>  $this->primaryKey(),
            'name' =>  $this->string(),
            'created_at' =>  $this->integer(),
        ]);

        $this->createTable('todo_items', [
            'id' =>  $this->primaryKey(),
            'list_id' =>  $this->integer(),
            'item_name' =>  $this->string(),
            'created_at' =>  $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-todo_items-list_id',
            'todo_items',
            'list_id',
            'todo_list',
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
        $this->dropForeignKey('fk-todo_list-todo_items_id','todo_items');
        $this->dropTable('todo_list');
        $this->dropTable('todo_items');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200826_112201_add_tables cannot be reverted.\n";

        return false;
    }
    */
}
