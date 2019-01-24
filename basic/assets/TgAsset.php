<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TgAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        '/css/vendor/font-awesome/font-awesome.min.css',
        '/css/attreditor.css',
        '/css/templates.css',
        '/css/setupwizard.css',
        '/css/document.css',
        '/css/plugins.css',
        '/css/doclist.css',
        '/css/vendor/froala/froala_editor.pkgd.min.css',
        '/css/vendor/froala/froala_editor.css',
        '/css/vendor/froala/froala_style.min.css',
        '/css/vendor/treegrid/jquery.treegrid.css',
        '/css/vendor/smartwizard/smart_wizard.min.css',
        '/css/vendor/smartwizard/smart_wizard_theme_dots.min.css',
        '/css/vendor/smartwizard/smart_wizard_theme_arrows.min.css',
        '/css/vendor/smartwizard/smart_wizard_theme_circles.min.css',
    ];

    public $js = [
        '/js/attreditor.js',
        '/js/doclist.js',
        '/js/vendor/froala/froala_editor.min.js',
        '/js/vendor/froala/froala_editor.pkgd.min.js',
        '/js/vendor/froala/languages/ru.js',
        '/js/vendor/treegrid/jquery.treegrid.js',
        '/js/vendor/smartwizard/jquery.smartWizard.min.js',
        '/js/templates.js',
        '/js/setupwizard.js',
        '/js/document.js',
        '/js/plugin_egrul.js',
        '/js/plugin_client_egrul.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
