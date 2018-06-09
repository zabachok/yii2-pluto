<?php

namespace zabachok\pluto\builders;

class IdsBuilder implements IBuilder
{
    /**
     * @var int[]
     */
    private $ids = [];

    /**
     * @return mixed
     */
    public function build()
    {
        return $this->ids;
    }

    /**
     * @param int[] $ids
     * @return IdsBuilder
     */
    public function setIds(array $ids): IdsBuilder
    {
        foreach ($ids as $id) {
            $this->addId($id);
        }

        return $this;
    }

    /**
     * @param int $id
     * @return IdsBuilder
     */
    public function addId(int $id): IdsBuilder
    {
        $this->ids[] = $id;

        return $this;
    }
}