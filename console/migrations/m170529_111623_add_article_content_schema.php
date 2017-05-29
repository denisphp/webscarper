<?php

use yii\db\Migration;

class m170529_111623_add_article_content_schema extends Migration
{
    const TABLE = '{{%article_content}}';

    public function up()
    {
        $tableOptions = null;
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'version' => $this->integer()->defaultValue(1),
            'html' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
