<?php

namespace crm\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\models\Order;

/**
 * OrderrSearch represents the model behind the search form of `crm\models\Order`.
 */
class OrderrSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'customer_id', 'is_deleted', 'status'], 'integer'],
            [['product_name', 'order_date'], 'safe'],
            [['amount'], 'number'],
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
        $query = Order::find();

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
            'amount' => $this->globalSearch,
            'order_date' => $this->globalSearch,
            'is_deleted' => $this->globalSearch,
            'status' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['ilike', 'product_name', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'amount' => $this->amount,
            'order_date' => $this->order_date,
            'is_deleted' => $this->is_deleted,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'product_name', $this->product_name]);
        }
        return $dataProvider;
    }
}
