<?php

namespace zabachok\pluto\actions;

use Yii;
use yii\base\Action as YiiAction;

class Action extends YiiAction
{
    /**
     * @var array
     */
    protected $fields = [];

    public function init(): void
    {
        parent::init();
        foreach ($this->fields as $field) {
            if (is_string($this->$field)) {
                $this->$field = Yii::$container->get($this->$field);
            }
        }
    }
}