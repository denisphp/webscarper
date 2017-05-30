<?php

namespace common\models\gii;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $flow
 * @property string $title
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property boolean $is_changed
 */
class ArticleGii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flow', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'url'], 'string'],
            [['is_changed'], 'boolean'],
            [['created_at', 'updated_at'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'flow' => 'Flow',
            'title' => 'Title',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'is_changed' => 'Is Changed'
        ];
    }
}
