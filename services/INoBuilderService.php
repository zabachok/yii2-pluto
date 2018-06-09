<?php

namespace zabachok\pluto\services;

use yii\base\Model;

interface INoBuilderService
{
    /**
     * @param Model $form
     * @return bool
     */
    public function behave(Model $form): bool;
}