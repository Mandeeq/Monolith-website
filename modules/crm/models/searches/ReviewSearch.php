<?php

namespace crm\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\models\Reviews;

/**
 * ReviewSearch represents the model behind the search form of `crm\models\Reviews`.
 */
class ReviewSearch extends Reviews
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'customer_id', 'order_id', 'rating', 'status', 'created_at', 'updated_at'], 'integer'],
            [['product_name', 'review_text'], 'safe'],
            ['globalSearch', 'safe']
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
        $query = Reviews::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'defaultPageSize' => \Yii::$app->params['defaultPageSize'], 'pageSizeLimit' => [1, \Yii::$app->params['pageSizeLimit']]],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        if(isset($this->globalSearch)){
                $query->orFilterWhere([
            'id' => $this->globalSearch,
            'customer_id' => $this->globalSearch,
            'order_id' => $this->globalSearch,
            'rating' => $this->globalSearch,
            'status' => $this->globalSearch,
            'created_at' => $this->globalSearch,
            'updated_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['ilike', 'product_name', $this->globalSearch])
            ->orFilterWhere(['ilike', 'review_text', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'order_id' => $this->order_id,
            'rating' => $this->rating,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'product_name', $this->product_name])
            ->andFilterWhere(['ilike', 'review_text', $this->review_text]);
        }
        return $dataProvider;
    }
}
