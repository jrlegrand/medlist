<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medchart".
 *
 * @property string $id
 * @property string $date_created
 * @property string $date_updated
 */
class Medchart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medchart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_created', 'date_updated'], 'safe']
        ];
    }

	public function getMeds()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(Med::className(), ['medchart_id' => 'id']);
    }
	
    public function extraFields()
    {
        return [
            'meds',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }
}
