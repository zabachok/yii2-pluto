<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\responses\ApiErrorNotValidResponse;
use zabachok\pluto\responses\ApiResponse;
use zabachok\pluto\services\INoBuilderService;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class NoBuilderGetAction extends Action
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
     * @throws BadRequestHttpException
     */
    public function run(int $id = 0): ApiResponse
    {
        if ($id) {
            $this->form->id = $id;
        }

        $this->form->setAttributes(Yii::$app->request->get());

        if (!$this->form->validate()) {
            $keys = array_keys($this->form->getFirstErrors());
            throw new BadRequestHttpException('Not valid: ' . implode(', ', $keys));
        }

        $this->service->behave($this->form);

        return $this->response;
    }
}