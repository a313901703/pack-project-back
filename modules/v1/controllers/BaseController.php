<?php

namespace v1\controllers;

use yii\web\Controller;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;

class BaseController extends ActiveController
{
    public $serializer = [
        'class' => 'v1\controllers\Serializer',
        'collectionEnvelope' => 'list',
    ];

    public function actions()
    {
        $actions = parent::actions();
        $actions['create']=[
            'class' => 'v1\controllers\actions\CreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $actions['update']=[
            'class' => 'v1\controllers\actions\UpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $actions['delete']=[
            'class' => 'v1\controllers\actions\DeleteAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        //禁用 "delete"动作
        //unset($actions['delete'],$actions['create'],$actions['update']);
        if ($this->checkFuncExist('prepareDataProvider')) {
            $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        }
        return $actions;
    }

    public function checkFuncExist($funcName){
        $methods = get_class_methods($this);
        return in_array($funcName, $methods);
    }

    public function behaviors()
    {   
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['contentNegotiator'] =[
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];

        return $behaviors;
    }
}
