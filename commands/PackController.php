<?php
namespace app\commands;

use yii\console\Controller;
use yii\console\widgets\Table;
use yii\helpers\Console;
use app\Models\Projects;
use yii\helpers\{ArrayHelper,FileHelper};

class PackController extends Controller
{
    public $project;

    public $tags;

    public $commands = [];

    public function actionIndex(){
        $projects = Projects::find()->asArray()->indexBy('name')->all();
        $name = $this->select('请输入项目名称:',ArrayHelper::getColumn($projects,'name'));
        $project = $projects[$name];
        $this->project = $project;
        
        $branchs = explode(',',$project['branch']);
        $branchs = \array_combine($branchs,$branchs);
        $branch = $this->select('请输入分支:',$branchs);
        $this->tags = $this->prompt('请输入版本号:');
        echo Table::widget([
            'headers' => ['项目名称', '项目类型','分支', '版本号'],
            'rows' => [
                [$name,$project['type'], $branch, $this->tags ],
            ],
        ]);
        if ($this->confirm('是否确认创建打包')) {
            $this->goPath();
            $this->gitPull($branch);
            $this->runBuild();
            $this->stdout("Down \n", Console::BOLD);
        }else{
            $this->stdout("取消 \n", Console::BOLD);
        }
    }

    public function goPath(){
        $path = $this->project['path'];
        $this->commands[]= 'cd '.$path.' ';
        //exec('cd '.$path);
    }

    public function gitPull($branch){
        $this->commands[]= 'git checkout '.$branch.' ';
        $this->commands[]= 'git pull ';
    }

    public function runBuild(){
        $project = $this->project;
        switch($project['type']){
            case 'vue':
            case 'react':
                $this->commands[]= 'npm run build ';
                //exec('npm run build');
                $this->project['path'] = $this->project['path'].'dist';
                //$this->commands[]= 'cd dist ';
                $this->tarGz($this->tags);
                break;
            default:
                $this->commands[]= 'cd .. ';
                $this->tarGz($this->tags);
                break;
        }
    }

    public function tarGz($tag){
        $path = $this->project['path'];
        $path = \explode('/',$path);
        $path = './'.array_pop($path);

        $name = $this->project['name'];
        $name = $name.'_'.$tag;

        $target = $this->project['target'];
        if (!\file_exists($target)) {
            FileHelper::createDirectory($target);
        } 
        $target .= '/'.$name.'.tar.gz';
        $command = "tar -zcvf %s %s";
        $command = sprintf($command,$target,$path);
        
        $this->commands[]= $command;
        $command = implode('&&',$this->commands);
        echo $command;exit;
        if (\file_exists($target)) {
            if ($this->confirm($target."已存在,是否覆盖？\n")) {
                exec($command);
            }
        }else{
            exec($command);
        }
    }
}