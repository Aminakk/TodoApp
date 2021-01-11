<?php

use yii\db\Migration;

/**
 * Class m201112_071603_add_field_auth_key
 */
class m201112_071603_add_field_auth_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'auth_key', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'auth_key');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201112_071603_add_field_auth_key cannot be reverted.\n";

        return false;
    }
    */
}
