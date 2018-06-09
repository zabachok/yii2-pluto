<?php

namespace zabachok\pluto\responses;

class EnumResponse extends SuccessResponse
{
    /**
     * @param string $enum
     * @return EnumResponse
     */
    public function setEnumClass(string $enum): EnumResponse
    {
        $list = [];
        foreach ($enum::listData() as $id => $label) {
            $list[] = [
                'id' => $id,
                'label' => $label,
            ];
        }
        $this->setData($list);

        return $this;
    }
}