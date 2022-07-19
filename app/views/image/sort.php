<?php
use yii\helpers\Html;
?>
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
