<?php

namespace app\models;

use Yii;

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
class EventRules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_rules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['street', 'grid_center', 'status', 'created_at', 'updated_at'], 'integer'],
            [['filter'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['id_filter'], 'string', 'max' => 1000],
            [['event_type'], 'string', 'max' => 100],
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
            'street' => 'Street',
            'grid_center' => 'Grid Center',
            'filter' => 'Filter',
            'id_filter' => 'Id Filter',
            'event_type' => 'Event Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
