<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Med;

/**
 * MedSearch represents the model behind the search form about `app\models\Med`.
 */
class MedSearch extends Med
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'medlist_id', 'rxnorm_id'], 'integer'],
            [['indication', 'notes', 'date_modified', 'date_created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Med::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'medlist_id' => $this->medlist_id,
            'rxnorm_id' => $this->rxnorm_id,
            'date_modified' => $this->date_modified,
            'date_created' => $this->date_created,
        ]);

        $query->andFilterWhere(['like', 'indication', $this->indication])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
