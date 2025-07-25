<?php

namespace dashboard\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use dashboard\models\Post;

/**
 * PostSearch represents the model behind the search form of `dashboard\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'user_id', 'is_published', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['title', 'tag', 'description', 'image_path'], 'safe'],
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
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => \Yii::$app->params['defaultPageSize'], 'pageSizeLimit' => [1, \Yii::$app->params['pageSizeLimit']]],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        if (isset($this->globalSearch)) {
            $query->orFilterWhere([
                'id' => $this->globalSearch,
                'user_id' => $this->globalSearch,
                'is_published' => $this->globalSearch,
                'is_deleted' => $this->globalSearch,
                'created_at' => $this->globalSearch,
                'updated_at' => $this->globalSearch,
            ]);

            $query->orFilterWhere(['ilike', 'title', $this->globalSearch])
                ->orFilterWhere(['ilike', 'tag', $this->globalSearch])
                ->orFilterWhere(['ilike', 'description', $this->globalSearch])
                ->orFilterWhere(['ilike', 'image_path', $this->globalSearch]);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'user_id' => $this->user_id,
                'is_published' => $this->is_published,
                'is_deleted' => $this->is_deleted,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]);

            $query->andFilterWhere(['ilike', 'title', $this->title])
                ->andFilterWhere(['ilike', 'tag', $this->tag])
                ->andFilterWhere(['ilike', 'description', $this->description])
                ->andFilterWhere(['ilike', 'image_path', $this->image_path]);
        }
        return $dataProvider;
    }
}
