<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todo_list".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $user_id
 *
 * @property TodoItems[] $todoItems
 */
class TodoList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todo_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'user_id' => 'User Id',
        ];
    }

    /**
     * Gets query for [[TodoItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTodoItems()
    {
        return $this->hasMany(TodoItems::class, ['list_id' => 'id']);
    }
}
