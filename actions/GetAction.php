<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\responses\ApiResponse;
use zabachok\pluto\responses\BuilderResponse;
use zabachok\pluto\services\IService;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class GetAction extends Action
{
    /**
     * @var Model
     */
    public $form;

    /**
     * @var BuilderResponse
     */
    public $response;

    /**
     * @var IService
     */
    public $service;

    /**
     * @var array
     */
    protected $fields = ['form', 'response', 'service'];

    /**
     * @param int $id
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

        $dtoBuilder = $this->service->behave($this->form);

        return $this->response->setBuilder($dtoBuilder);
    }
}