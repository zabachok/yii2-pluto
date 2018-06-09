<?php

namespace zabachok\pluto\actions;

use zabachok\pluto\components\UploadedFile;
use zabachok\pluto\responses\ApiErrorNotValidResponse;
use zabachok\pluto\responses\ApiResponse;
use zabachok\pluto\responses\BuilderResponse;
use zabachok\pluto\services\IService;
use Yii;
use yii\base\Model;

class UploadFilesAction extends Action
{
    /**
     * @var array
     */
    protected $fields = ['form', 'service', 'response', 'notValidResponse'];

    /**
     * @var IService
     */
    public $service;

    /**
     * @var Model
     */
    public $form;

    /**
     * @var BuilderResponse
     */
    public $response = BuilderResponse::class;

    /**
     * @var ApiErrorNotValidResponse
     */
    public $notValidResponse = ApiErrorNotValidResponse::class;

    /**
     * @var string
     */
    public $fileField;

    /**
     * @var UploadedFile
     */
    public $uploader = UploadedFile::class;

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
        $this->form->{$this->fileField} = $this->uploader::getInstancesByName($this->fileField);
        if (!$this->form->validate()) {
            return $this->notValidResponse->setFields($this->form->getFirstErrors());
        }

        return $this->response->setBuilder(
            $this->service->behave($this->form)
        );
    }
}