<?php

namespace Api\Package\V1\Transforms;

use League\Fractal\TransformerAbstract;
use Package\Entities\Logistics;

class LogisticsTransformer extends TransformerAbstract
{
    public function transform(Logistics $logistics)
    {
        return $logistics->attributesToArray();
    }
}
