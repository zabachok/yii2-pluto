<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\responses\ObjectResponse;
use zabachok\pluto\responses\SuccessResponse;
use zabachok\pluto\services\IObjectService;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class ObjectAction extends Action
{
    /**
     * @var Model
     */
    public $form;

    /**
     * @var ObjectResponse
     */
    public $response;

    /**
     * @var IObjectService
     */
    public $service;

    /**
     * @var array
     */
    protected $fields = ['form', 'response', 'service'];

    /**
     * @param int $id
     * @return SuccessResponse
     * @throws BadRequestHttpException
     */
    public function run(int $id = 0): SuccessResponse
    {
        if (Yii::$app->request->isPost) {
            $this->form->setAttributes(Yii::$app->request->post());
        } else {
            $this->form->setAttributes(Yii::$app->request->get());
        }

        if ($id) {
            $this->form->id = $id;
        }

        if (!$this->form->validate()) {
            $keys = array_keys($this->form->getFirstErrors());
            throw new BadRequestHttpException('Not valid: ' . implode(', ', $keys));
        }

        $dtoBuilder = $this->service->behave($this->form);

        return $this->response->setObject($dtoBuilder);
    }
}