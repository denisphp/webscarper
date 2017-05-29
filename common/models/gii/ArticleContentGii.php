<?php

namespace common\models\gii;

use Yii;

/**
 * This is the model class for table "article_content".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $version
 * @property string $html
 * @property integer $created_at
 * @property integer $updated_at
 */
class ArticleContentGii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'version', 'created_at', 'updated_at'], 'integer'],
            [['html'], 'string'],
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
            'article_id' => 'Article ID',
            'version' => 'Version',
            'html' => 'Html',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
