<?php

namespace andahrm\leave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\leave\models\LeavePermission;
use andahrm\structure\models\FiscalYear;

/**
 * LeavePermissionSearch represents the model behind the search form about `andahrm\leave\models\LeavePermission`.
 */
class LeavePermissionSearch extends LeavePermission {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'leave_condition_id', 'number_day', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['year', 'fullname'], 'safe'],
        ];
    }

    public $fullname;

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = LeavePermission::find();

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
        $this->year = $this->year ? $this->year : FiscalYear::currentYear();


        if ($this->fullname) {
            $query->joinWith('user');
            $query->andWhere(['OR',
                ['LIKE', 'person.user_id', $this->fullname],
                ['LIKE', 'person.firstname_th', $this->fullname],
                ['LIKE', 'person.lastname_th', $this->fullname]
            ]);
//            $query->orWhere(['LIKE', 'person.firstname_th', $this->fullname]);
//            $query->orWhere(['LIKE', 'person.lastname_th', $this->fullname]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'leave_condition_id' => $this->leave_condition_id,
            'year' => $this->year,
            'number_day' => $this->number_day,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }

}
