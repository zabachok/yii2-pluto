<?php

namespace zabachok\pluto\responses;

use zabachok\pluto\builders\IBuilder;

abstract class BuilderResponse extends SuccessResponse
{
    /**
     * @param IBuilder $builder
     * @return BuilderResponse
     */
    public function setBuilder(IBuilder $builder): ApiResponse
    {
        return $this->setData(
            $this->transformObjectToArray($builder)
        );
    }

    /**
     * @param IBuilder $builder
     * @return array
     */
    protected abstract function transformObjectToArray(IBuilder $builder): array;
}
