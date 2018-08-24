<?php

namespace app\models\query;

use Yii;
use app\models\Projects;
use yii\data\ActiveDataProvider;

class ProjectQuery extends \yii\base\Model
{
    public $id;
    public $name;
    public $type;
    public $desc;
    public $path;

    public function rules(){
        return [

            [['id','name','type','desc','path'],'safe']
        ];
    }

    public function search($params){
        $query = Projects::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,'');
        
        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     $query->where('0=1');
        //     return $dataProvider;
        // }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['type' => $this->type]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'path', $this->path]);
        return $dataProvider;
    }
}