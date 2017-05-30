<?php

namespace common\components;

use yii\base\Component;

class Text extends Component
{
    public function diff($from, $to)
    {
        $edits = [];
        $diff = xdiff_string_diff($from, $to);
        if ($diff) {
            $diff = explode("\n", $diff);

            foreach ($diff as $line) {
                if (!strlen($line)) {
                    continue;
                }
                switch ($line[0]) {
                    case '+':
                        $edits['added'][] = substr($line, 1);
                        break;
                    case '-':
                        $edits['deleted'][] = substr($line, 1);
                        break;
                }
            }
        }

        return $edits;
    }
}
