<?php

namespace zabachok\pluto\responses;

class ApiErrorResponse extends ApiResponse
{
    const CODE = 0;

    const FIELD_MESSAGE = 'message';

    /**
     * @param string $message
     * @return ApiResponse
     */
    public function setMessage(string $message): ApiResponse
    {
        $this->data[self::FIELD_MESSAGE] = $message;
        return $this;
    }
}
