<?php

namespace app\assets;

use yii\web\AssetBundle;


class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/components-font-awesome';
    public $css = [
        'css/font-awesome.css',
    ];
}
