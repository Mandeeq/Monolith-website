<?php

namespace crm\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\models\OrderHistory;

/**
 * OrderHistorySearch represents the model behind the search form of `crm\models\OrderHistory`.
 */
class OrderHistorySearch extends OrderHistory
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'customer_id', 'product_id', 'quantity', 'order_status', 'payment_status', 'created_at', 'updated_at'], 'integer'],
            [['order_number', 'product_name', 'ordered_at'], 'safe'],
            [['unit_price', 'total_price'], 'number'],
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
        $query = OrderHistory::find();

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
            'product_id' => $this->globalSearch,
            'quantity' => $this->globalSearch,
            'unit_price' => $this->globalSearch,
            'total_price' => $this->globalSearch,
            'order_status' => $this->globalSearch,
            'payment_status' => $this->globalSearch,
            'ordered_at' => $this->globalSearch,
            'created_at' => $this->globalSearch,
            'updated_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['ilike', 'order_number', $this->globalSearch])
            ->orFilterWhere(['ilike', 'product_name', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_price' => $this->total_price,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'ordered_at' => $this->ordered_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'order_number', $this->order_number])
            ->andFilterWhere(['ilike', 'product_name', $this->product_name]);
        }
        return $dataProvider;
    }
}
