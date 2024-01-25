<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `frontend\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employer_id'], 'integer'],
            [['name', 'phone_1', 'phone_2', 'address', 'source', 'level', 'comment'], 'safe'],
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
        $query = Customer::find();

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
            'employer_id' => $this->employer_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone_1', $this->phone_1])
            ->andFilterWhere(['like', 'phone_2', $this->phone_2])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
