<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\{StringHelper,FileHelper};

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $desc
 * @property string $path
 * @property int $created_at
 * @property int $updated_at
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (!\file_exists($this->path)) {
                    FileHelper::createDirectory($this->path);
                }
                $command[] = 'cd '.$this->path;
                $command[] = 'git clone '.$this->target;
                $command = implode('&&',$command);
                $out = [];
                exec($command,$out,$status);
                if ($status !== 0) {
                    throw new \Exception($out);
                }
                $target = explode('/',$this->target);
                $target = array_pop($target);
                $target = \explode('.',$target)[0];
                $this->path .= '/'.$target;
            }
            return true;
        } else {
            return false;
        }
    }

    public function fields(){
        return [
            'id',
            'name',
            'desc',
            'path',
            'type',
            'target',
            'branch'=>function($model){
                return $model['branch'] ? explode(',',$model['branch']) : [];
            },
            'created_at'=>function($model){
                return date('Y-m-d H:i:s',$model['created_at']); 
            }
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'desc', 'path','target'], 'required'],
            [['name', 'type', 'desc'], 'string', 'max' => 255],
            [['path','target'], 'string', 'max' => 1000],
            [['path'], 'filter', 'filter' => function ($value) {
                $value = \explode('/',$value);
                $value = \array_filter($value);
                return '/'.implode('/',$value);
            }],
            ['branch','filter','filter'=>function($value){
                $value = (array)$value;
                return $value ? implode(',',$value) : '';
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'desc' => 'Desc',
            'path' => 'Path',
            'branch'=> 'branch',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
