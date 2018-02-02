<?php
namespace yii2\kendo\assets;

use Yii;
use yii\web\AssetBundle;

class KendoMobileAsset extends AssetBundle
{
    public $cdnPath = "";

    public $sourcePath = null;

    public $js = [
    ];

    public $css = [
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        $this->js = [
            $this->cdnPath.'/js/kendo.mobile.js',
            $this->cdnPath.'/js/jszip.min.js',
            $this->cdnPath.'/js/kendo.timezones.js',
            $this->cdnPath.'/plugins/kendo-ui/js/cultures/kendo.culture.' . Yii::$app->language . '.js',
            $this->cdnPath.'/js/messages/kendo.messages.'.Yii::$app->language.'.min.js'
        ];

        $this->css = [
            CDN_URL.'/plugins/kendo-ui/css/kendo.mobile.all2.min.css',
            //'css/kendo.common-material.min.css',
            //'css/kendo.materialblack.min.css',
            //'css/kendo.materialblack.mobile.min.css',
        ];
    }
}
