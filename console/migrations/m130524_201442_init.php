<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    const TABLE = '{{%user}}';

    public function up()
    {
        $tableOptions = null;
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
