<?php

namespace v1\controllers\actions;

use Yii;

class UpdateAction extends \yii\rest\UpdateAction
{
    public function run($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }elseif($model->hasErrors()){
            $error = array_values($model->getFirstErrors())[0];
            throw new ServerErrorHttpException($error);
        }

        return $model;
    }
}