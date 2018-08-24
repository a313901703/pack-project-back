<?php

namespace app\models\query;

use Yii;
use app\models\Package;
use yii\data\ActiveDataProvider;

class PackageQuery extends \yii\base\Model 
{
    use DataProviderTrait;

    public $id;
    public $project;
    public $start;
    public $end;
    public $pageSize;

    public function rules(){
        return [

            [['id','project','start','end','pageSize'],'safe']
        ];
    }

    public function search($params){
        $query = Package::find()->with('projects');

        $dataProvider = $this->getDataProvider($query);

        $this->load($params,'');
        
        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     $query->where('0=1');
        //     return $dataProvider;
        // }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['project' => $this->project]);
        if ($this->start && $this->end) {
            $query->andFilterWhere(['between', 'created_at', strtotime($this->start),strtotime($this->end)]);
        }
        return $dataProvider;
    }
}