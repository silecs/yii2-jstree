silecs/yii2-jstree
==================

Yet another JavaScript tree widget for Yii2.

Wraps [jsTree](https://www.jstree.com/) into a Yii2 widget.

Differences from yii-dream-team/yii2-jstree:

* IDE completion for the main settings, instead of recursive arrays,
* Easy lazy-loading.

Installation
------------

Either use the command line:
```
composer require "silecs/yii2-jstree"
```

Or edit the file `composer.json`, and add under `require` a line:
```
	"silecs/yii2-jstree": "*"
```
Beware of the trailing commas!

Usage
-----

In a Yii2 view, insert:
```
<div class="my-ajax-tree">
 <?php
 echo \silecs\jstree\Jstree::widget([
     'core' => \silecs\jstree\JstreeOptions::build()
         ->setUrl(Url::to(['tree/children'])),
 ]);
 ?>
 </div>
```

In this example, the action 'tree/children' will receive GET requests qith a parameter id,
and must return JSON texts like:
```
[
	{
		"id":"node-00",
		"text":"a node",
		"state":"closed",
		"children":true
	}
]
```
