<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Production;

/**
 * ProductionSearch represents the model behind the search form of `backend\models\Production`.
 */
class ProductionSearch extends Production
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'plan_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'company_id', 'branch_id', 'delivery_route_id'], 'integer'],
            [['prod_no', 'prod_date'], 'safe'],
            [['globalSearch'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Production::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'prod_date' => $this->prod_date,
            'plan_id' => $this->plan_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'company_id' => $this->company_id,
            'branch_id' => $this->branch_id,
            'delivery_route_id' => $this->delivery_route_id,
        ]);

        if ($this->globalSearch != '') {
            $query->orFilterWhere(['like', 'prod_no', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
