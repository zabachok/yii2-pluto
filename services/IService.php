<?php

namespace zabachok\pluto\services;

use zabachok\pluto\builders\IBuilder;
use yii\base\Model;

interface IService
{
    /**
     * @param Model $form
     * @return IBuilder
     */
    public function behave(Model $form): IBuilder;
}