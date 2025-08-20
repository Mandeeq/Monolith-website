<?php

namespace qaffee\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use qaffee\models\ContactMessages;

/**
 * ContactMessagesSearch represents the model behind the search form of `qaffee\models\ContactMessages`.
 */
class ContactMessagesSearch extends ContactMessages
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'created_at'], 'integer'],
            [['name', 'email', 'subject', 'message'], 'safe'],
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
        $query = ContactMessages::find();

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
            'created_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['ilike', 'name', $this->globalSearch])
            ->orFilterWhere(['ilike', 'email', $this->globalSearch])
            ->orFilterWhere(['ilike', 'subject', $this->globalSearch])
            ->orFilterWhere(['ilike', 'message', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'subject', $this->subject])
            ->andFilterWhere(['ilike', 'message', $this->message]);
        }
        return $dataProvider;
    }
}
