<?php
namespace app\models\traits;

use yii\helpers\{ArrayHelper,FileHelper};

trait CommandTrait 
{
    public $commands;

    public $project;

    public $tag;

    public $branch;

    public $target;

    public function goPath(){
        $path = $this->project['path'];
        $this->commands[]= 'cd '.$path.' ';
    }

    public function gitPull(){
        $this->commands[]= 'git checkout '.$this->branch.' ';
        $this->commands[]= 'git pull ';
    }

    public function runBuild(){
        $project = $this->project;
        switch($project['type']){
            case 'vue':
            case 'react':
                $this->commands[]= 'npm run build ';
                $this->project['path'] = $this->project['path'].'/dist';
                break;
            default:
                $this->commands[]= 'cd .. ';
                break;
        }
    }

    public function tarGz(){
        $path = $this->project['path'];
        $path = \explode('/',$path);
        $path = './'.array_pop($path);

        $name = $this->project['name'];
        $name = $name.'_'.$this->tag;

        $target = $this->target;
        if (!\file_exists($target)) {
            FileHelper::createDirectory($target);
        } 
        $target .= '/'.$name.'.tar.gz';
        $command = "tar -zcvf %s %s";
        $command = sprintf($command,$target,$path);
        $this->commands[]= $command;
    }
}