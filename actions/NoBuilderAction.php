<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\services\INoBuilderService;
use zabachok\pluto\responses\ApiErrorNotValidResponse;
use zabachok\pluto\responses\ApiResponse;
use Yii;
use yii\base\Model;

class NoBuilderAction extends Action
{
    /** @var Model */
    public $form;

    /** @var ApiResponse */
    public $response = ApiResponse::class;

    /** @var ApiErrorNotValidResponse */
    public $notValidResponse = ApiErrorNotValidResponse::class;

    /** @var INoBuilderService */
    public $service;

    /**
     * @var array
     */
    protected $fields = ['form', 'response', 'notValidResponse', 'service'];

    /**
     * @param int $id
     * @return ApiResponse
     */
    public function run(int $id = 0): ApiResponse
    {
        if ($id) {
            $this->form->id = $id;
        }

        $this->form->setAttributes(Yii::$app->request->post());

        if (!$this->form->validate()) {
            return $this->notValidResponse->setFields($this->form->getFirstErrors());
        }

        $this->service->behave($this->form);

        return $this->response;
    }
}