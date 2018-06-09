<?php

namespace zabachok\pluto\responses;

use zabachok\pluto\builders\IBuilder;
use zabachok\pluto\builders\IdBuilder;

class IdResponse extends BuilderResponse
{
    /**
     * @param IBuilder|IdBuilder $builder
     * @return array
     */
    protected function transformObjectToArray(IBuilder $builder): array
    {
        return ['id' => $builder->build()];
    }
}