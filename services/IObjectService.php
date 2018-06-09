<?php

namespace zabachok\pluto\services;

use yii\base\Model;

interface IObjectService
{
    /**
     * @param Model $form
     * @return object
     */
    public function behave(Model $form);
}