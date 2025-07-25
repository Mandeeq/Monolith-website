<?php

namespace dashboard\models;

use Yii;
use auth\models\User;

/**
 * This is the model class for table "{{%likes}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $post_id
 * @property string $type
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Post $posts
 * @property User $users
 */
class Likes extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%likes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['post_id'], 'default', 'value' => 1],
            [['is_deleted'], 'default', 'value' => 0],
            [['user_id', 'post_id', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'post_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'required'],
            [['type'], 'string', 'max' => 10],
            [['post_id', 'user_id'], 'unique', 'targetAttribute' => ['post_id', 'user_id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'type' => Yii::t('app', 'Type'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return LikesQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new LikesQuery(get_called_class());
    // }

}
