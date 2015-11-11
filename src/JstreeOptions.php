<?php

/**
 * @license http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
 */

namespace silecs\jstree;

use yii\base\Object;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * There are two kinds of uses:
 *
 * 1. Init with an array:
 *
 * new JstreeOptions([
 *     'data' => [...],
 *     'animation' => true
 * ]);
 *
 * 2. Init with methods (and IDE completion):
 *
 * JstreeOptions::build()
 *     ->setData([...])
 *     ->setAnimation(true);
 *
 * @author François Gannaz <francois.gannaz@silecs.info>
 */
class JstreeOptions extends Object
{
    /**
     * @var boolean|string|array See http://www.jstree.com/api/#/?f=$.jstree.defaults.core.data
     */
    private $data = false;

    /**
     * @var integer|boolean The open / close animation duration in milliseconds.
     */
    private $animation = false;

    /**
     * @var boolean|\yii\web\JsExpression Allow modifying operations on the tree.
     *                     To enable editing, set it to true or to a JS function.
     */
    private $checkCallback = false;

    /**
     * @var boolean Web workers will be used to parse incoming JSON data,
     *    so that the UI will not be blocked by large requests.
     *    Workers are however about 30% slower.
     */
    private $worker = false;

    /**
     * @var array Add new themes. See https://www.jstree.com/api/#/?f=$.jstree.defaults.core.themes
     */
    private $themes;

    /**
     * @var array Overwrite the default messages.
     */
    private $strings;

    public static function build()
    {
        return new JstreeOptions();
    }

    /**
     * @param string $lang Language as a 2 characters code
     */
    public function translateTo($lang)
    {
        $translations = [
            'fr' => [
                "Loading ..." => "Chargement en cours",
                "New node" => "Nouveau nœud",
            ],
        ];
        if (isset($translations[$lang])) {
            $this->strings = $translations[$lang];
        }
    }

    /**
     * Sets the data using an AJAX URL, with id={codeid} appended.
     * Use this instead of setData() for lazy loading.
     *
     * Warning: if one intends to load the nodes on demand, these fields are needed:
     *     "children": true,
     *     "status": closed
     *
     * @param string $url
     * @return \silecs\jstree\JstreeOptions
     */
    public function setUrl($url)
    {
        $this->data = [
            'url' => $url,
            'data' => new JsExpression("function (node) { return { 'id' : node.id }; }"),
        ];
        return $this;
    }

    /**
     * See http://www.jstree.com/api/#/?f=$.jstree.defaults.core.data.
     * Use setUrl() instead of this when lazy loading with AJAX.
     *
     * @param array $v
     * @return \silecs\jstree\JstreeOptions
     */
    public function setData($v)
    {
        $this->data = $v;
        return $this;
    }

    /**
     * @param integer|boolean $v The open / close animation duration in milliseconds.
     * @return \silecs\jstree\JstreeOptions
     */
    public function setAnimation($v)
    {
        $this->animation = $v;
        return $this;
    }

    /**
     * @param boolean|\yii\web\JsExpression $v Allow modifying operations on the tree.
     *             To enable editing, set it to true or to a JSExpression (a JS function).
     * @return \silecs\jstree\JstreeOptions
     */
    public function setCheckCallBack($v)
    {
        $this->checkCallback = $v;
        return $this;
    }

    /**
     *
     * @param boolean $v Web workers will be used to parse incoming JSON data,
     *    so that the UI will not be blocked by large requests.
     *    Workers are however about 30% slower.
     * @return \silecs\jstree\JstreeOptions
     */
    public function setWorker($v)
    {
        $this->worker = (boolean) $v;
        return $this;
    }

    /**
     * @param array $v Add new themes. See https://www.jstree.com/api/#/?f=$.jstree.defaults.core.themes
     * @return \silecs\jstree\JstreeOptions
     */
    public function setThemes($v)
    {
        $this->themes = $v;
        return $this;
    }

    /**
     * @param array $v Overwrite the default messages.
     * @return \silecs\jstree\JstreeOptions
     */
    public function setString($v)
    {
        $this->strings = $v;
        return $this;
    }

    /**
     * Convert this object into JS code.
     *
     * @return string
     */
    public function toJs()
    {
        $config = array(
            "data" => $this->data,
            "animation" => $this->animation,
            "worker" => $this->worker,
            "check_callback" => $this->checkCallback,
        );
        if ($this->strings) {
            $config["strings"] = $this->strings;
        }
        if ($this->themes) {
            $config["themes"] = $this->themes;
        }
        return Json::encode($config);
    }
}
