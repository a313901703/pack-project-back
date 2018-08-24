<?php

namespace v1\controllers;

use Yii;
use app\models\query\PackageQuery;
use app\models\{Package,Projects};
use app\models\traits\CommandTrait;
use yii\web\BadRequestHttpException;

class PackageController extends BaseController
{
    use CommandTrait;
    
    public $modelClass = 'app\models\Package';

    public function prepareDataProvider(){
        $request = Yii::$app->request;
        $model = new PackageQuery();
        return $model->search($request->queryParams);
    }

    /** 
     * 打包
     */
    public function actionPack(){
        echo 111;exit;
        $package = new Package();
        $package->load(Yii::$app->request->post(),'');
        if (!$package->validate()) {
            throw new \Exception(array_values($package->getFirstErrors())[0]);
        }
        $package->created_at = time();

        $project = Projects::findOne($package->project);
        $this->project = $project;
        $this->tag    = $package->tags;
        $this->branch = $package->branch;
        $this->target = $package->target;

        list($command,$out,$status) = $this->execPackage();
        if ($status === 0) {
            $package->save();
            return ['status'=>0];
        }
        return [
            'status'=>$status,
            'msg' => json_encode($out),
        ];
    }

    public function execPackage(){
        $this->goPath();
        $this->gitPull();
        $this->runBuild();
        $this->tarGz();
        $command = implode('&&',$this->commands);
        $out = [];
        exec($command.' 2>&1',$out,$status);
        return [$command,$out,$status];
    }
}
