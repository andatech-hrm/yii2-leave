<?php

namespace andahrm\leave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\leave\models\LeaveCondition;

/**
 * LeaveConditionSearch represents the model behind the search form about `andahrm\leave\models\LeaveCondition`.
 */
class LeaveConditionSearch extends LeaveCondition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'leave_type_id', 'gov_service_status', 'per_annual_leave', 'per_annual_leave_limit', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'safe'],
            [['number_year'], 'number'],
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
        $query = LeaveCondition::find();

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
            'leave_type_id' => $this->leave_type_id,
            'gov_service_status' => $this->gov_service_status,
            'number_year' => $this->number_year,
            'per_annual_leave' => $this->per_annual_leave,
            'per_annual_leave_limit' => $this->per_annual_leave_limit,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
