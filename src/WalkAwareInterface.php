<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

interface WalkAwareInterface
{
    public const WALKER_DEFAULTS = [];

    public function setWalker(Walker $walker): void;
}
