<?php

use yii\db\Migration;

/**
 * Class m200828_061354_add_table_user
 */
class m200828_061354_add_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
        'id' =>  $this->primaryKey(),
        'first_name' =>  $this->string(),
        'email' =>  $this->string(),
        'password' =>  $this->string(),
        'created_at' =>  $this->integer(),
    ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200828_061354_add_table_user cannot be reverted.\n";

        return false;
    }
    */
}
