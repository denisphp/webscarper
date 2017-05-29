<?php

use yii\db\Migration;

class m170529_105959_add_article_schema extends Migration
{
    const TABLE = '{{%article}}';

    public function up()
    {
        $tableOptions = null;
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'flow' => $this->integer(),
            'title' => $this->text(),
            'url' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }

}
