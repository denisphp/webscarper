<?php

use yii\db\Migration;

class m170530_071002_add_article_status extends Migration
{
    const TABLE = '{{%article}}';

    public function up()
    {
        $this->addColumn(self::TABLE, 'status', $this->smallInteger()->defaultValue(\common\models\Article::STATUS_ACTIVE));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE, 'status');
    }
}
