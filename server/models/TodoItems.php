<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todo_items".
 *
 * @property int $id
 * @property int|null $list_id
 * @property string|null $item_name
 * @property int|null $created_at
 *
 * @property TodoList $list
 */
class TodoItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todo_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['list_id', 'created_at'], 'integer'],
            [['item_name'], 'string', 'max' => 255],
            [['list_id'], 'exist', 'skipOnError' => true, 'targetClass' => TodoList::className(), 'targetAttribute' => ['list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_id' => 'List ID',
            'item_name' => 'Item Name',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[List]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(TodoList::class, ['id' => 'list_id']);
    }
}
