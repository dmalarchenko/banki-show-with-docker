<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true])?>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>