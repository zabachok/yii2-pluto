<?php

namespace zabachok\pluto\services;

use yii\base\Model;

interface IArrayService
{
    /**
     * @param Model $form
     * @return array
     */
    public function behave(Model $form): array;
}