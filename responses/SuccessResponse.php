<?php

namespace zabachok\pluto\responses;

class SuccessResponse extends ApiResponse
{
    const CODE = 1;

    const FIELD_DATA = 'data';

    /**
     * @param array $data
     * @return ApiResponse
     */
    public function setData(array $data): ApiResponse
    {
        $this->data[self::FIELD_DATA] = $data;

        return $this;
    }
}
