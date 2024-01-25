<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OrderItem;

/**
 * OrderItemSearch represents the model behind the search form of `frontend\models\OrderItem`.
 */
class OrderItemSearch extends OrderItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clean_item_id', 'id', 'order_id', 'size', 'count'], 'integer'],
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
        $query = OrderItem::find();

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
            'clean_item_id' => $this->clean_item_id,
            'id' => $this->id,
            'order_id' => $this->order_id,
            'size' => $this->size,
            'count' => $this->count,
        ]);

        return $dataProvider;
    }
}
