<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medlist".
 *
 * @property string $id
 * @property string $created
 * @property string $updated
 */
class Medlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'medlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['date_created', 'date_updated', 'id'], 'safe']
        ];
    }

	public function getMeds()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(Med::className(), ['medlist_id' => 'id']);
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
            'date_created' => 'Created',
            'date_updated' => 'Updated',
        ];
    }
}
