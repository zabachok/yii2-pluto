<?php

namespace zabachok\pluto\builders;

class IdBuilder implements IBuilder
{
    /**
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function build(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return IdBuilder
     */
    public function setId(int $id): IdBuilder
    {
        $this->id = $id;

        return $this;
    }
}