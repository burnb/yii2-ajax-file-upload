<?php

namespace app\models;

use app\components\FileBehavior;
use app\components\TimestampBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file_upload".
 *
 * @property integer $id
 * @property string $filename
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 */
class FileUpload extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_upload';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp'    => [
                'class' => TimestampBehavior::className(),
            ],
            'fileBehavior' => [
                'class'         => FileBehavior::className(),
                'fileField'     => 'file',
                'fileNameField' => 'filename',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['filename', 'text'], 'string', 'max' => 255],
            [
                'file',
                'file',
                'mimeTypes' => [
                    'image/jpeg',
                    'image/gif',
                    'image/png',
                    'application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                    'application/vnd.ms-excel' ,
                    'application/vnd.ms-powerpoint',
                ],
                'enableClientValidation' => false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'filename'   => 'Filename',
            'text'       => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
