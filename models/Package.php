<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property int $id
 * @property int $project
 * @property string $branch
 * @property string $target
 * @property string $tags
 * @property int $created_at
 * @property int $status
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project', 'branch', 'target', 'tags'], 'required'],
            [['project'], 'integer'],
            [['branch', 'target', 'tags'], 'string', 'max' => 255],
        ];
    }

    public function fields(){
        return [
            'id',
            'projects'=>function($model){
                return $model['projects']['name'];
            },
            'branch',
            'target',
            'tags',
            'created_at'=>function($model){
                return date('Y-m-d H:i:s',$model['created_at']);
            }
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project' => 'Project',
            'branch' => 'Branch',
            'target' => 'Target',
            'tags' => 'Tags',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    public function getProjects(){
        return $this->hasOne(Projects::className(),['id'=>'project']);
    }
}
