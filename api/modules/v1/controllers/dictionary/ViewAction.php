<?php

namespace api\modules\v1\controllers\dictionary;

use api\components\BaseApiAction;
use common\helpers\Flow;
use common\models\Article;
use yii\helpers\ArrayHelper;

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
        $flows = [];
        foreach (Flow::getList() as $flow){
            $flows[$flow['name']] = $flow['type'];
        }
        return [
            'article' => [
                'flow' => $flows,
                'status' => array_flip(Article::$statuses),
            ]
        ];
    }
}
