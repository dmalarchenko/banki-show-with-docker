<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UploadForm;
use app\models\Image;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;

class ImageController extends Controller
{
    /**
     * Загрузка изображений
     * 
     * @return string|yii\web\Response
     */
    public function actionUpload()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $countUploadedFiles = $model->upload();
            if ($countUploadedFiles) {	
                Yii::$app->session->setFlash('success', "Загружено " . $countUploadedFiles . ' фото!');
            } else {
                Yii::$app->session->setFlash('error', "В процессе загрузки произошли ошибки!");
            }
            return $this->redirect(Yii::$app->request->url);
        } else {
            return $this->render('upload', ['model' => $model]);
        }
    }
    /**
     * Просмотр изображений
     * 
     * @return string
     */
    public function actionIndex()
    {
        $images = Image::find()->asArray()->all();
        return $this->render('index', ['images' => $images]);
    }
    /**
     * Ajax-запрос на сортировку изображений. Сортирует по нескольким полям.
     * 
     * @return string|null
     */
    public function actionSort()
    {
        $request = Yii::$app->request;
        // Если запрос POST
        if ($request->isPost) {
            // Разбиваем по & т.к данные приходят в формате, напр.
            // name=asc&uploaded_at=desc
            $fields = explode('&', ($request->post())['sort']);
            $orderByClause = [];
            foreach($fields as $field) {
                $field = explode('=', $field); // [0] - название поля, [1] - направление сортировки
                // Если направление сортиовки соответствует одному из вариантов. 
                if (in_array($field[1], ['ASC', 'DESC'])) {
                    // формируем поля для сортировки
                    $orderByClause[$field[0]] = ($field[1] == 'ASC') ? SORT_ASC : SORT_DESC; 
                }
            }
            // Если есть что сортировать
            if ($orderByClause) {
                // сортируем и получаем изображения
                $images = Image::find()->orderBy($orderByClause)->asArray()->all();
            } else {
                // иначе, сортировку не используем
                $images = Image::find()->asArray()->all();
            }
            return $this->renderPartial('sort', ['images' => $images]);
        }
        return null;
    }
}