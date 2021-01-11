<?php

namespace app\controllers;

use app\models\TodoItems;
use app\models\TodoList;
use app\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class ListController extends ActiveController
{
    public $modelClass =  'app\models\TodoList';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter' ] = [
            'class' => \yii\filters\Cors::class,
        ];
        // here’s where I add behavior (read below)
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;
        $behaviors['authenticator']['except'] = ['options'];


        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page', 'X-Pagination-Page-Count', 'X-Hidden-Count'],
                'Access-Control-Request-Headers' => ['Content-Type', 'Access-Control-Allow-Headers', 'Authorization', 'X-Requested-With']
            ]
        ];
        return $behaviors;
    }


    public function actions()
    {
        $actions = parent::actions();

        // disable actions
        unset($actions['create'], $actions['update'], $actions['index'], $actions['delete'], $actions['view']);

        return $actions;
    }

    public function actionCreate()
    {
        $return = ['status' => 'ok'];

        $params = Yii::$app->request->getBodyParams();

        $todoList = new TodoList();
        $todoList->name = $params['title'];
        $todoList->user_id = Yii::$app->user->id;
        $todoList->created_at = time();
        $todoList->save();

        foreach ($params['lists'] as $list)
        {
            $todoItems = new TodoItems();
            $todoItems->list_id = $todoList->id;
            $todoItems->item_name = $list;
            $todoItems->created_at = time();
            $todoItems->save();
        }

        // return $return;
    }

    public function actionIndex()
    {
        $todoItems = TodoItems::find()
            ->leftJoin('todo_list', 'todo_list.id = todo_items.list_id')
            ->where('todo_list.user_id = ' . Yii::$app->user->id)
            ->orderBy('todo_items.id', 'id', 'DESC')
            ->all();

        $listArray = [];

        foreach ($todoItems as $todoItem)
        {
            if (!isset($listArray[$todoItem->list_id])) {
                $listArray[$todoItem->list_id] = [
                    'name' => $todoItem->list->name,
                    'items' => []
                ];
            }
            $listArray[$todoItem->list_id]['items'][] = $todoItem;
        }

        return array_values($listArray);

    }

    public function actionRegister()
    {
        $return = ['status' => 'ok'];

        $params = Yii::$app->request->getBodyParams();

        $user = User::find()->where('email = "' . $params['email'] . '"')->one();

        if ($user == null)
        {
            $hash = Yii::$app->getSecurity()->generatePasswordHash($params['password']);

            $user = new User();
            $user->first_name = $params['first_name'];
            $user->email = $params['email'];
            $user->password = $hash;
            $user->created_at = time();
            if (!$user->save()) {
                return $user->getErrors();
            }
        } else {
            $return = ['error' => 'email already exist.'];
        }

        return $return;
    }
}
