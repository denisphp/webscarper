<?php

namespace common\helpers;

class Flow
{
    const DEVELOP = 1;
    const ADMIN = 2;
    const DESIGN = 3;
    const MANAGEMENT = 4;
    const MARKETING = 5;
    const MISC = 6;

    public static function getList()
    {
        return [
            [
                'name' => 'develop',
                'type' => self::DEVELOP
            ],
            [
                'name' => 'admin',
                'type' => self::ADMIN
            ],
            [
                'name' => 'design',
                'type' => self::DESIGN
            ],
            [
                'name' => 'management',
                'type' => self::MANAGEMENT
            ],
            [
                'name' => 'marketing',
                'type' => self::MARKETING
            ],
            [
                'name' => 'misc',
                'type' => self::MISC
            ],
        ];
    }

    public static function getNameById($id)
    {
        $list = self::getList();
        $key = array_search($id, array_column($list, 'type'));
        if ($key !== false) {
            return $list[$key]['name'];
        }
        return null;
    }

    public static function getIdByName($name)
    {
        $list = self::getList();
        $key = array_search($name, array_column($list, 'name'));
        if ($key !== false) {
            return $list[$key]['type'];
        }
        return null;
    }
}
