<?php

/**
 * @license http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
 */

namespace silecs\jstree;

use yii\web\AssetBundle;

/**
 * @author François Gannaz <francois.gannaz@silecs.info>
 */
class JstreeAssets extends AssetBundle
{
    /**
     * @var string The JSTree theme.
     */
    public $theme = 'default';

    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@bower/jstree/dist';

    /**
     * @var array list of bundle class names that this bundle depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        $this->js[] = (defined('YII_DEBUG') && YII_DEBUG ? 'jstree.js' : 'jstree.min.js');
        if ($this->theme != false) {
            $this->css[] = "themes/{$this->theme}/"
                . (defined('YII_DEBUG') && YII_DEBUG ? 'style.css' : 'style.min.css');
        }
        parent::registerAssetFiles($view);
    }
}
