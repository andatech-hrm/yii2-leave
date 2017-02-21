<?php

namespace andahrm\leave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\leave\models\LeaveCancel;

/**
 * LeaveCancelSearch represents the model behind the search form of `andahrm\leave\models\LeaveCancel`.
 */
class LeaveDirectorCancelSearch extends LeaveCancelSearch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'leave_id', 'start_part', 'end_part', 'status', 'commander_status', 'commander_by', 'commander_at', 'director_status', 'director_by', 'director_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['to', 'reason', 'date_start', 'date_end', 'commander_comment', 'director_comment'], 'safe'],
            [['number_day'], 'number'],
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
        $query = LeaveCancel::find();

        // add conditions that should always apply here
         $query->where([
          'director_by'=>Yii::$app->user->id,
          'director_at'=>null,
          'status' => [LeaveCancel::STATUS_CONSIDER],
          'commander_status'=>!null
        ]);

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
            'leave_id' => $this->leave_id,
            'date_start' => $this->date_start,
            'start_part' => $this->start_part,
            'date_end' => $this->date_end,
            'end_part' => $this->end_part,
            'number_day' => $this->number_day,
            'status' => $this->status,
            'commander_status' => $this->commander_status,
            'commander_by' => $this->commander_by,
            'commander_at' => $this->commander_at,
            'director_status' => $this->director_status,
            'director_by' => $this->director_by,
            'director_at' => $this->director_at,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'to', $this->to])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'commander_comment', $this->commander_comment])
            ->andFilterWhere(['like', 'director_comment', $this->director_comment]);

        return $dataProvider;
    }
}
