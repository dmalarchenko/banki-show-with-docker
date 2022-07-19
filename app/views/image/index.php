<?php
use yii\helpers\Html;
?>
<div id="process-message"></div>
<? if ($images): ?>
<table class="upload-images">
    <thead>
        <tr>
            <td>Изображение</td>
            <td data-field="name" data-type-sort="" class="sort-available">Название изображения <i class="bi bi-arrow-up sort" title="По возрастанию"></i><i class="bi bi-arrow-down sort" title="По убыванию"></i></td>
            <td data-field="uploaded_at" data-type-sort="" class="sort-available">Дата и время загрузки <i class="bi bi-arrow-up sort" title="По возрастанию"></i><i class="bi bi-arrow-down sort" title="По убыванию"></i></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($images as $image): ?>
            <tr>
                <td>
                    <a href="<?='uploads/' . $image['name']?>">
                        <?=Html::img('uploads/' . $image['name'], ['alt' => $image['name']] ) ?>
                    </a>
                </td>
                <td>
                    <?=$image['name']?>
                </td>
                <td>
                    <?=$image['uploaded_at'];?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<? else: ?>
<p>
    Пожалуйста, загрузите фото <a href="/index.php?r=image/upload">здесь</a>
</p>
<? endif; ?>