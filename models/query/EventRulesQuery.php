<?php

namespace app\models\query;

use Yii;
use app\models\EventRules;

/**
 * This is the model class for table "event_rules".
 *
 * @property int $id
 * @property string $name
 * @property int $street
 * @property int $grid_center
 * @property string $filter
 * @property string $id_filter
 * @property string $event_type
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class EventRulesQuery extends yii\base\Model 
{
    public function rules(){
        return [];
    }
}