<?php

namespace api\models;

use common\models\Article as ArticleCommon;
use yii\helpers\ArrayHelper;

/**
 * Class Article
 *
 * @package api\models
 */
class Article extends ArticleCommon
{
    public function rules()
    {
        $rules = parent::rules();

        return $rules;
    }
}
