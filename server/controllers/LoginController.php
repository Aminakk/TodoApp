<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\Response;

class LoginController extends ActiveController
{
    public $modelClass =  'app\models\User';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        // disable actions
        unset($actions['create'], $actions['update'], $actions['index'], $actions['delete'], $actions['view']);

        return $actions;
    }

    /**
     * Login action.
     *
     * @return Response|array
     */
    public function actionCreate()
    {
        $params = Yii::$app->request->getBodyParams();

        $user = User::find()->where('email = "' . $params['email'] . '"')->one();

        if (Yii::$app->getSecurity()->validatePassword($params['password'], $user->password)) {
            $user->generateAuthKey();
            $user->save();
            $return = ['status' => 'ok', 'user' => $user];
        } else {
            $return = ['error' => 'login error'];
        }

        return $return;
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
