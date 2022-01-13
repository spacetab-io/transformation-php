<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

trait WalkAwareTrait
{
    protected Walker $walker;

    public function setWalker(Walker $walker): void
    {
        $this->walker = $walker;
    }
}
