<?php

namespace andahrm\leave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\person\models\Person;

/**
 * PersonSearch represents the model behind the search form about `andahrm\person\models\Person`.
 */
class PersonSearch extends \andahrm\person\models\Person
{
    public $fullname;
    public $person_type_id;
    public $year;
    public $number_day;
    public $position_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_type_id','year'], 'required'],
            [['user_id', 'person_type_id','year','position_id'], 'integer'],
            [['citizen_id'], 'safe'],
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
        $query = Person::find();

        $query->joinWith('positionSalary.position', false, 'INNER JOIN');      
        //$query->joinWith('leavePermission');
      
        //$query->select(['person.*','leave_permission.year as year']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
             
      
//         $dataProvider->sort->attributes['number_day'] = [
//         // The tables are the ones our relation are configured to
//         // in my case they are prefixed with "tbl_"
//             'asc' => ['tbl_city.name' => SORT_ASC],
//             'desc' => ['tbl_city.name' => SORT_DESC],
//         ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,           
            //'leave_permission.year' => $this->year,
            'position.person_type_id' => $this->person_type_id,
            'position.id' => $this->position_id,
        ]); 
       
      
//       if($this->year){
//         $query->andFilterWhere([
//             '>=' , 'position_salary.adjust_date' ,$this->year.'-8-1'
//         ]);       
//       }

        return $dataProvider;
    }
}
