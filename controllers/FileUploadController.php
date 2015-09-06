<?php

namespace app\controllers;

use app\components\FileBehavior;
use app\models\FileUpload;
use app\models\search\FileUploadSearch;
use Yii;
use yii\web\Controller;

class FileUploadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Lists all FileUpload models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileUploadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * File upload form
     * @return string
     */
    public function actionCreate()
    {
        $model = new FileUpload();

        return $this->render('create', compact('model'));
    }

    /**
     * Upload file, save to storage and db
     * @return bool
     */
    public function actionUpload()
    {
        $model = new FileUpload();
        $model->setAttributes(Yii::$app->request->post());
        if ($model->save()) {

            return true;
        }

        return json_encode(['error' => 'Model save errors: ' . json_encode($model->getErrors())]);
    }

    /**
     * Show uploaded file by id in db
     * @param $id
     * @return \yii\web\Response
     */
    public function actionView($id)
    {
        /** @var FileUpload|FileBehavior $file */
        $file = FileUpload::findOne($id);
        if (!empty($file)) {
            $file->showFile();
            exit;
        }
        Yii::$app->session->setFlash('error', "File not found");

        return $this->redirect(['index']);
    }
}
