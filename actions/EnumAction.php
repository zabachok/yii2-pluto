<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\responses\EnumResponse;
use yii2mod\enum\helpers\BaseEnum;

class EnumAction extends Action
{
    /**
     * @var BaseEnum
     */
    public $enumClass;

    /**
     * @var EnumResponse
     */
    public $response = EnumResponse::class;

    /**
     * @var array
     */
    protected $fields = ['response'];

    /**
     * @return EnumResponse
     */
    public function run(): EnumResponse
    {
        return $this->response->setEnumClass($this->enumClass);
    }
}