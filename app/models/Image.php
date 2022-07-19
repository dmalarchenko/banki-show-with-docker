<?php

namespace app\models;

use yii\db\ActiveRecord;
/**
 * Модель Image - используется для работы с таблицей images
 */
class Image extends ActiveRecord
{
    /**
     * Возвращает название связанной таблицы
     * @return string
     */
    public static function tableName()
    {
        return 'images';
    }
}