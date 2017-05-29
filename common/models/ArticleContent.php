<?php
namespace common\models;

use common\models\gii\ArticleContentGii;
use yii\behaviors\TimestampBehavior;

class ArticleContent extends ArticleContentGii
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_content}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['article_id', 'version', 'created_at', 'updated_at'], 'integer'],
            [['html'], 'string'],
        ];
    }
}