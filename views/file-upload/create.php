<?php

/* @var $this yii\web\View */

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;

$this->title = 'File Upload';
$this->params['breadcrumbs'][] = ['label' => 'File Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id'                     => 'file-upload',
    'enableClientValidation' => true,
    'fieldConfig'            => [
        'template'     => '{label}<div class="error-prompted" data-placement="top"><div class="error">{error}</div></div>{input}',
        'inputOptions' => ['class' => 'form-control'],
    ],
    'options'                => [
        'class'   => 'form',
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<?= $form->field($model, 'text')->textarea(); ?>
<?= $form->field($model, 'file')->widget(FileInput::classname(), [
    'options' => [
        'multiple' => false
    ]
]); ?>
<?php ActiveForm::end(); ?>
