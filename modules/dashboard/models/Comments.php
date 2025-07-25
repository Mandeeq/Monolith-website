<?php

namespace dashboard\models;

use Yii;
use auth\models\User;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $comment
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Comments $comments
 * @property Comments[] $comments0
 * @property Post $posts
 * @property User $users
 */
class Comments extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['post_id', 'user_id', 'comment'], 'required'],
            [['post_id', 'user_id', 'parent_id', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['post_id', 'user_id', 'parent_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'post_id' => Yii::t('app', 'Post ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'comment' => Yii::t('app', 'Comment'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery|CommentsQuery
     */
    public function getComments()
    {
        return $this->hasOne(Comments::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Comments0]].
     *
     * @return \yii\db\ActiveQuery|CommentsQuery
     */
    public function getComments0()
    {
        return $this->hasMany(Comments::class, ['parent_id' => 'id']);
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
     * @return CommentsQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new CommentsQuery(get_called_class());
    // }

}
