<?php

namespace andahrm\leave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\leave\models\Leave;

/**
 * LeaveSearch represents the model behind the search form about `andahrm\leave\models\Leave`.
 */
class LeaveSearch extends Leave
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'leave_type_id', 'start_part', 'end_part', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['date_start', 'date_end', 'reason'], 'safe'],
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
        $query = Leave::find();

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
            'user_id' => $this->user_id,
            'leave_type_id' => $this->leave_type_id,
            'date_start' => $this->date_start,
            'start_part' => $this->start_part,
            'date_end' => $this->date_end,
            'end_part' => $this->end_part,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
