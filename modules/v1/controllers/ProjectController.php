<?php

namespace v1\controllers;

use Yii;
use app\models\query\ProjectQuery;
use app\models\{Package,Projects};
use app\models\traits\CommandTrait;
use yii\web\BadRequestHttpException;

class ProjectController extends BaseController
{
    use CommandTrait;
    
    public $modelClass = 'app\models\Projects';

    public function prepareDataProvider(){
        $request = Yii::$app->request;
        $model = new ProjectQuery();
        return $model->search($request->queryParams);
    }
}
