<?php

namespace api\modules\v1\controllers\article;

use api\components\BaseApiAction;
use common\helpers\Flow;
use api\models\Article;
use yii\data\ActiveDataProvider;

/**
 * Class DeletedListAction
 *
 * @package api\modules\v1\controllers\article
 */
class ChangedListAction extends BaseApiAction
{
    const DEFAULT_PAGE_SIZE = 12;
    const DEFAULT_PAGE = 0;

    public function rules()
    {
        return [
            [['page', 'limit'], 'integer'],
            ['limit', 'default', 'value' => self::DEFAULT_PAGE_SIZE],
            ['page', 'default', 'value' => self::DEFAULT_PAGE],
        ];
    }

    public function run()
    {
        return null;
    }

    public function description()
    {
        return '
        GET Parameters:
            "page"        integer (default 0) (optional)
            "limit"       integer (default 12) (optional)
        ';
    }
}
