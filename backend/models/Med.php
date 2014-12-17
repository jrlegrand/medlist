<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "med".
 *
 * @property string $id
 * @property string $medlist_id
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
            [['medlist_id', 'rxnorm_id'], 'required'],
            [['id', 'medlist_id', 'rxnorm_id'], 'integer'],
            [['notes', 'sig', 'name'], 'string'],
            [['date_modified', 'date_created', 'created_by'], 'safe'],
            [['indication'], 'string', 'max' => 2083]
        ];
    }

	public function getMedlist()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasOne(Medlist::className(), ['id' => 'medlist_id']);
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'medlist_id' => 'Medlist ID',
            'rxnorm_id' => 'Rxnorm ID',
            'indication' => 'Indication',
            'notes' => 'Notes',
            'date_modified' => 'Date Modified',
            'date_created' => 'Date Created',
        ];
    }
}
