<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "med".
 *
 * @property string $id
 * @property string $medchart_id
 * @property string $rxnorm_id
 * @property string $indication
 * @property string $notes
 * @property string $date_modified
 * @property string $date_created
 */
class Med extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'med';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['medchart_id', 'rxnorm_id'], 'required'],
            [['id', 'medchart_id', 'rxnorm_id'], 'integer'],
            [['notes', 'sig', 'name'], 'string'],
            [['date_modified', 'date_created', 'created_by'], 'safe'],
            [['indication'], 'string', 'max' => 2083]
        ];
    }

	public function getMedchart()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasOne(Medchart::className(), ['id' => 'medchart_id']);
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medchart_id' => 'Medchart ID',
            'rxnorm_id' => 'Rxnorm ID',
            'indication' => 'Indication',
            'notes' => 'Notes',
            'date_modified' => 'Date Modified',
            'date_created' => 'Date Created',
        ];
    }
}
