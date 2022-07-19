<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
/**
 * Класс UploadForm - модель формы для загрузки изображений
 */
class UploadForm extends Model
{
    /** $imageFiles хранит изображения */
    public $imageFiles;
    /** MAX_FILENAME_LENGTH максимальная длина названия исходного файла(без учета расширения) */
    public const MAX_FILENAME_LENGTH = 50;
    /**
     * Возвращает правила валидации
     * 
     * @return array
     */
    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 5],
        ];
    }
    /**
     * Сохраняет файлы. В случае успеха возвращает кол-во сохраненных файлов, иначе 0.
     * 
     * @return int
     */
    public function upload()
    {
        // Кол-во загруженных файлов изображений
        $countUploadedImages = 0;
        // Если валидация пройдена
        if ($this->validate()) { 
            $rows = [];
            foreach ($this->imageFiles as $file) {
                $fileName = substr(Inflector::slug($file->baseName), 0, self::MAX_FILENAME_LENGTH) . '.' . $file->extension;
                // Если файл существует
                if (file_exists('uploads/' . $fileName)) {
                    // Формируем новое название
                    $fileName = substr(Inflector::slug($file->baseName), 0, self::MAX_FILENAME_LENGTH) . '_' . (microtime(true) * rand(1, 1000)) . '.' . $file->extension;
                }
                // сохраняем
                $file->saveAs('uploads/' . $fileName);
                $rows[] = [
                    'name' => $fileName
                ];
                $countUploadedImages++;
            }
            // Сохраняем названия файлов в таблицу images (сохраняем пачкой)
            Yii::$app->db->createCommand()->batchInsert(Image::tableName(), ['name'], $rows)->execute();
        } 
        return $countUploadedImages;
    }

}