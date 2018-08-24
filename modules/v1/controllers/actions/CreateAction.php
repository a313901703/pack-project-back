<?php

namespace v1\controllers\actions;

use Yii;

class CreateAction extends \yii\rest\CreateAction
{
    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            //$response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }else{
            $error = array_values($model->getFirstErrors())[0];
            throw new ServerErrorHttpException($error); 
        }
        return $model;
    }
}