<?php

namespace crm\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use crm\models\SupportTickets;

/**
 * SupportTicketSearch represents the model behind the search form of `crm\models\SupportTickets`.
 */
class SupportTicketSearch extends SupportTickets
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'customer_id', 'is_deleted', 'status'], 'integer'],
            [['subject', 'description', 'created_at'], 'safe'],
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
        $query = SupportTickets::find();

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
            'is_deleted' => $this->globalSearch,
            'status' => $this->globalSearch,
            'created_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['ilike', 'subject', $this->globalSearch])
            ->orFilterWhere(['ilike', 'description', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'is_deleted' => $this->is_deleted,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'subject', $this->subject])
            ->andFilterWhere(['ilike', 'description', $this->description]);
        }
        return $dataProvider;
    }
}
