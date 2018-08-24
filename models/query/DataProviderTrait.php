<?php 
namespace app\models\query;

use Yii;
use yii\data\{Pagination,ActiveDataProvider};
use yii\helpers\ArrayHelper;

trait DataProviderTrait{

    public $sort;

    public $pageSize;

    public function getDataProvider($query){
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>$this->getPagination(),
            'sort'=>$this->getProviderSort(),
        ]);
        return $dataProvider;
    }

    public function getProviderSort(){
        if ($this->sort === null) {
            return ['defaultOrder'=>['id'=>SORT_DESC]];
        }
        return $this->sort;
    }

    public function getPagination(){
        if ($this->pageSize === null) {
            $this->pageSize = Yii::$app->request->get('pageSize',20);
        }
        return ['pageSize'=>$this->pageSize];
    }
}