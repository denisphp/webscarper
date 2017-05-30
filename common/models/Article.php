<?php
namespace common\models;

use common\models\gii\ArticleGii;
use common\models\query\ArticleQuery;
use yii\behaviors\TimestampBehavior;

class Article extends ArticleGii
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
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
            [['flow', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'url'], 'string'],
        ];
    }

    public function getArticleContent()
    {
        return $this->hasMany(ArticleContent::className(), ['article_id' => 'id']);
    }

    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}