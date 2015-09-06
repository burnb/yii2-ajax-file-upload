<?php
namespace app\components;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\helpers\FileHelper;
use yii\helpers\HtmlPurifier;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * This is for saving model file.
 * It takes uploaded file from $fileField
 * moves it to custom path and updates owner $fileNameField which is just alias
 * for real file name.
 * Real file name and path is constant for owner like /storage/documents/{owner_id}
 * You can define your own method for file path but it must be constant too
 * because we don't store it in database.
 * You can also get file with this->showFile() or this->sendFile() method.
 *
 * Usage:
 * Define this behavior in your ActiveRecord instance class.
 * public function behaviors() {
 *     return [
 *          ...,
'fileBehavior' => [
'class' => FileBehavior::className(),
'fileField' => 'file',
'fileNameField' => 'filename',
]
 *     ]
 * }
 *
 * @property ActiveRecord $owner
 */
class FileBehavior extends Behavior
{
    /**
     * @var string base path for all files.
     */
    public $storage = '@storage';

    /**
     * @var string owner uploaded file field name (you don't need to make db field, only model attribute).
     */
    public $fileField;

    /**
     * @var string owner file name db field.
     */
    public $fileNameField;

    /**
     * @var string owner filePath naming method. By default we use inner $this->getFilePath() method.
     */
    public $pathMethod;

    /**
     * @var string
     */
    public $subFolder = 'customer_id';

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_AFTER_INSERT    => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE    => 'afterDelete'
        ];
    }

    /**
     * Attaches uploaded file to owner.
     */
    public function beforeValidate()
    {
        if (!$file = UploadedFile::getInstance($this->owner, $this->fileField)) {
            return true;
        }
        $this->owner->{$this->fileField} = $file;
    }

    /**
     * Moves attached file and sets db filename field.
     */
    public function afterSave()
    {
        if (!$this->file = $this->owner->{$this->fileField}) {
            return true;
        }
        if (!$this->fileNameField) {
            $this->fileNameField = $this->fileField;
        }
        $path = $this->getFilePath();
        $this->createFilePath($path);
        $this->file->saveAs($path);
        $this->owner->updateAttributes([$this->fileNameField => self::purify($this->file->name)]);
    }

    /**
     * Removes attached owner file.
     * @return bool
     */
    public function afterDelete()
    {
        $path = $this->getFilePath();
        return !file_exists($path) || !is_file($path) || unlink($path);
    }

    /**
     * Gets file full path.
     * @return bool|mixed|string
     */
    public function getFilePath()
    {
        if ($this->pathMethod) {
            return call_user_func([$this->owner, $this->pathMethod]);
        }
        $userId = !$this->owner->getAttribute($this->subFolder) ? '' : $this->owner->getAttribute($this->subFolder). "/";
        return \Yii::getAlias($this->storage . '/' . $this->owner->formName() . '/' . $userId . $this->owner->primaryKey);
    }

    /**
     * Shows file to the browser.
     * @throws NotFoundHttpException
     */
    public function showFile()
    {
        $file = $this->getFilePath();
        if (!file_exists($file)) {
            throw new NotFoundHttpException;
        }
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: '. FileHelper::getMimeType($file), true);
        header('Content-Length: ' . filesize($file));

        readfile($file);
    }

    /**
     * Sends file to user download.
     * @throws NotFoundHttpException
     */
    public function sendFile()
    {
        $file = $this->getFilePath();
        if (!file_exists($file)) {
            throw new NotFoundHttpException;
        }
        \Yii::$app->response->sendFile($file, $this->owner->{$this->fileNameField});
    }

    /**
     * Generates path recursively.
     * @param string $path path to create.
     * @return bool
     */
    private function createFilePath($path)
    {
        $dir = dirname($path);
        return file_exists($dir) || FileHelper::createDirectory($dir, 0775, true);
    }

    /**
     * Filters string or array, removing dangerous data (tags, scripts).
     * @param $value
     * @return string
     */
    public static function purify($value)
    {
        switch (gettype($value)) {
            case 'string' : $value = HtmlPurifier::process($value);
                break;
            case 'array' :
                foreach ($value as $k => $v) {
                    $value[$k] = self::purify($v);
                }
                break;
        }
        return $value;
    }
} 