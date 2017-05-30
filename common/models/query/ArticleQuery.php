<?php

namespace  common\models\query;

use common\models\Article;
use yii\db\ActiveQuery;

class ArticleQuery extends ActiveQuery
{
    public function live()
    {
        $this->andWhere(['article.status' => Article::STATUS_ACTIVE]);

        return $this;
    }
}
