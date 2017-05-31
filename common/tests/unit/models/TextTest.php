<?php

namespace common\tests\unit\models;

use Yii;

/**
 * TextTest form test
 */
class TextTest extends \Codeception\Test\Unit
{
    public function testDiff()
    {
        $from = "Тестирование программного кода — кропотливый и сложный процесс.";
        $to = "
            Тестирование программного кода — полезный процесс,
            который позволяет выявить ситуации, в которых поведение программы является неправильным, нежелательным или не соответствующим спецификации
        ";

        $diff = Yii::$app->text->diff($from, $to);
        expect('deleted string', $diff['deleted'])->notEmpty();
        expect('added string', $diff['added'])->notEmpty();

        $diff = Yii::$app->text->diff($from, $from);
        expect('deleted string', $diff)->isEmpty();
    }
}
