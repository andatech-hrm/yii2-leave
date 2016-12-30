<?php

namespace andahrm\leave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\leave\models\LeaveType;

/**
 * LeaveTypeSearch represents the model behind the search form about `andahrm\leave\models\LeaveType`.
 */
class LeaveTypeSearch extends LeaveType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'limit', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title', 'detail'], 'safe'],
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
        $query = LeaveType::find();

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
            'limit' => $this->limit,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
