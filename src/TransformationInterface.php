<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

interface TransformationInterface
{
    /**
     * @return mixed
     */
    public function doTransform();
}
