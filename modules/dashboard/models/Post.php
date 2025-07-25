<?php

namespace dashboard\models;

use Yii;
use auth\models\User;
use dashboard\models\Likes;
use dashboard\models\Comments;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $is_published
 * @property string $title
 * @property string|null $tag
 * @property string $description
 * @property string|null $image_path
 * @property int|null $is_deleted
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Comment[] $comments
 * @property Like[] $likes
 * @property User $users
 * @property User[] $users0
 */
class Post extends \helpers\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tag', 'image_path', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['is_published'], 'default', 'value' => 1],
            [['is_deleted'], 'default', 'value' => 0],
            [['user_id', 'is_published', 'is_deleted', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'is_published', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title', 'tag', 'image_path'], 'string', 'max' => 255],
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
            'is_published' => Yii::t('app', 'Is Published'),
            'title' => Yii::t('app', 'Title'),
            'tag' => Yii::t('app', 'Tag'),
            'description' => Yii::t('app', 'Description'),
            'image_path' => Yii::t('app', 'Image Path'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery|CommentQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery|LikeQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['post_id' => 'id']);
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
     * Gets query for [[Users0]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::class, ['user_id' => 'user_id'])->viaTable('{{%likes}}', ['post_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new PostQuery(get_called_class());
    // }

}
