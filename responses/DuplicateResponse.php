<?php

namespace zabachok\pluto\responses;

class DuplicateResponse extends ApiResponse
{
    const CODE = 3;

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
