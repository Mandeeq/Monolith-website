<?php

namespace qaffee\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use qaffee\models\Blogs;

/**
 * BlogsSearch represents the model behind the search form of `qaffee\models\Blogs`.
 */
class BlogsSearch extends Blogs
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'content', 'image', 'published_at', 'status'], 'safe'],
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
        $query = Blogs::find();

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
            'author_id' => $this->globalSearch,
            'published_at' => $this->globalSearch,
            'created_at' => $this->globalSearch,
            'updated_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['ilike', 'title', $this->globalSearch])
            // ->orFilterWhere(['ilike', 'slug', $this->globalSearch])
            ->orFilterWhere(['ilike', 'content', $this->globalSearch])
            ->orFilterWhere(['ilike', 'image', $this->globalSearch])
            ->orFilterWhere(['ilike', 'status', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            // ->andFilterWhere(['ilike', 'slug', $this->slug])
            ->andFilterWhere(['ilike', 'content', $this->content])
            ->andFilterWhere(['ilike', 'image', $this->image])
            ->andFilterWhere(['ilike', 'status', $this->status]);
        }
        return $dataProvider;
    }
}
