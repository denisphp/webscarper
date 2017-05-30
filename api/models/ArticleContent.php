<?php

namespace api\models;

use common\models\ArticleContent as ArticleContentCommon;

/**
 * Class ArticleContent
 *
 * @package api\models
 */
class ArticleContent extends ArticleContentCommon
{
    public function rules()
    {
        $rules = parent::rules();

        return $rules;
    }
}
