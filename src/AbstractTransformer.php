<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

abstract class AbstractTransformer implements TransformInterface, WalkAwareInterface
{
    use WalkAwareTrait;
}
