<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

interface TransformInterface
{
    public function transform(mixed $value = null): mixed;
}
