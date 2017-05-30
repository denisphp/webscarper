<?php

use yii\db\Migration;

class m170530_201736_add_is_changed_to_article extends Migration
{
    const TABLE = '{{%article}}';

    public function up()
    {
        $this->addColumn(self::TABLE, 'is_changed', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE, 'is_changed');
    }
}
