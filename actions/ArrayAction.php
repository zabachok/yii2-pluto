<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\responses\ApiResponse;
use zabachok\pluto\services\IArrayService;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class ArrayAction extends Action
{
    /**
     * @var Model
     */
    public $form;

    /**
     * @var ApiResponse
     */
    public $response;

    /**
     * @var IArrayService
     */
    public $service;

    /**
     * @var array
     */
    protected $fields = ['form', 'response', 'service'];

    /**
     * @return ApiResponse
     * @throws BadRequestHttpException
     */
    public function run(int $id = 0): ApiResponse
    {
        $this->form->setAttributes(Yii::$app->request->get());

        if ($id) {
            $this->form->id = $id;
        }

        if (!$this->form->validate()) {
            $keys = array_keys($this->form->getFirstErrors());
            throw new BadRequestHttpException('Not valid: ' . implode(', ', $keys));
        }

        return $this->response->setData($this->service->behave($this->form));
    }
}