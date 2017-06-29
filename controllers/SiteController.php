<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UsersAdress;
use app\models\City;
use app\models\Area;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        $model = new UsersAdress();      
        
        if(Yii::$app->request->post()){
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
               return $this->render('index', [
                'model' => $model,
                'city' => City::find()->all(),
                'area' => Area::find()->all(),
                'adress' => UsersAdress::find()->all(),

            ]);
            }else{
               return $this->render('index', [
                'model' => $model,
                'city' => City::find()->all(),
                'area' => Area::find()->all(),
                'adress' => UsersAdress::find()->all(),
                'error' => true,   

            ]); 
            }        
        }
        return $this->render('index', [
            'model' => $model,
            'city' => City::find()->all(),
            'area' => Area::find()->all(),
            'adress' => UsersAdress::find()->all(),
            
        ]);
    }
}
