<?php

namespace api\modules\v1\controllers\dictionary;

use api\components\BaseApiAction;
use common\helpers\Flow;
use common\models\Article;

/**
 * Class ViewAction
 * @package api\modules\v1\controllers\dictionary
 */
class ViewAction extends BaseApiAction
{
    public function rules()
    {
        return [
            ['section', 'string'],
            ['section', 'in', 'range' => ['article']]
        ];
    }

    public function run()
    {
        $section = \Yii::$app->request->get('section');
        $dictionary = $this->getDictionary();

        return $section ? [$section => ArrayHelper::getValue($dictionary, $section)] : $dictionary;
    }

    protected function getDictionary()
    {
        return [
            'article' => [
                'flow' => Flow::getList(),
                'status' => array_flip(Article::$statuses),
            ]
        ];
    }
}
