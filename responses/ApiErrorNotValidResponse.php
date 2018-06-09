<?php

namespace zabachok\pluto\responses;

class ApiErrorNotValidResponse extends ApiResponse
{
    const CODE = 2;

    const FIELD_FIELDS = 'fields';

    /**
     * @param string $keyName
     * @param string $value
     * @return ApiResponse
     */
    public function addField(string $keyName, string $value): ApiResponse
    {
        $this->data[self::FIELD_FIELDS][$keyName] = $value;
        return $this;
    }

    /**
     * @param array $fields
     * @return ApiResponse
     */
    public function setFields(array $fields): ApiResponse
    {
        $this->data[self::FIELD_FIELDS] = $fields;
        return $this;
    }
}