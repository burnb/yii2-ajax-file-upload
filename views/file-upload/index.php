<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FileUploadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Uploads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-upload-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create File Upload', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => null,
        'columns'      => [
            [
                'attribute' => 'id',
                'value'     => function ($model) {
                    return Html::a($model->id, ['view', 'id' => $model->id], ['target' => '_blank']);
                },
                'format'    => 'raw'
            ],
            'filename',
            'text',
            'created_at',
            'updated_at'
        ],
    ]); ?>

</div>
