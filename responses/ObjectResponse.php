<?php

namespace zabachok\pluto\responses;

abstract class ObjectResponse extends SuccessResponse
{
    /**
     * @param object $object
     * @return BuilderResponse
     */
    public function setObject($object): ApiResponse
    {
        return $this->setData(
            $this->transformObjectToArray($object)
        );
    }

    /**
     * @param object $object
     * @return array
     */
    protected abstract function transformObjectToArray($object): array;
}