<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\responses\ApiErrorNotValidResponse;
use zabachok\pluto\responses\ApiResponse;
use zabachok\pluto\responses\BuilderResponse;
use zabachok\pluto\services\IService;
use Yii;
use yii\base\Model;

class PostAction extends Action
{
    /**
     * @var array
     */
    protected $fields = ['form', 'service', 'response', 'notValidResponse'];

    /**
     * @var BuilderResponse
     */
    public $response = BuilderResponse::class;

    /**
     * @var ApiErrorNotValidResponse
     */
    public $notValidResponse = ApiErrorNotValidResponse::class;

    /**
     * @var IService
     */
    public $service;

    /**
     * @var Model
     */
    public $form;

    /**
     * @param int $id
     * @return ApiResponse
     */
    public function run(int $id = 0): ApiResponse
    {
        $this->form->setAttributes(Yii::$app->request->post());

        if ($id) {
            $this->form->id = $id;
        }

        if (!$this->form->validate()) {
            return $this->notValidResponse->setFields($this->form->getFirstErrors());
        }

        $builder = $this->service->behave($this->form);

        return $this->response->setBuilder($builder);
    }
}