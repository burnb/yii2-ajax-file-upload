<?php

namespace app\models\search;

use app\models\FileUpload;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class FileUploadSearch
 * @package app\models\search
 */
class FileUploadSearch extends FileUpload
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['filename', 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
