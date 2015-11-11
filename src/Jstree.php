<?php

/*
 * @license http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
 */

namespace silecs\jstree;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Sample:
 *
 * <div class="my-ajax-tree">
 * <?php
 * echo \silecs\jstree\Jstree::widget([
 *     'core' => \silecs\jstree\JstreeOptions::build()
 *         ->setData([
 *            'url' => Url::to(['tree/node']),
 *            'data' => new \yii\web\JsExpression("function (node) { return { 'id' : node.id }; }")
 *         ])
 *         ->setWorker(true),
 * ]);
 * ?>
 * </div>
 *
 * @author François Gannaz <francois.gannaz@silecs.info>
 */
class Jstree extends Widget
{
    /**
     * @var JstreeOptions
     */
    public $core;

    /**
     * @var array
     */
    public $types = [];

    /**
     * @var array
     */
    public $plugins = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        JstreeAssets::register($this->getView());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $id = $this->getId();
        echo Html::tag('div', '', ['id' => 'jstree-' . $id]);
        // Loads jQuery and the initialisation JS code
        $this->getView()->registerJs(
            "$('#jstree-{$id}').jstree({"
            . '  "core": ' . $this->core->toJs()
            . ', "types": ' . Json::encode($this->types)
            . ', "plugins": ' . Json::encode($this->plugins)
            . "});"
        );
    }
}
