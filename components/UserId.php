<?php

namespace zabachok\pluto\components;

use Yii;

/**
 * @property integer user_id
 */
trait UserId
{
    /**
     * @return int
     */
    public function getUser_id(): int
    {
        return Yii::$app->user->id;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(parent::fields(), ['user_id']);
    }
}