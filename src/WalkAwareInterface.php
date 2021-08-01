<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

interface WalkAwareInterface
{
    public function setWalker(Walker $walker): void;
}
