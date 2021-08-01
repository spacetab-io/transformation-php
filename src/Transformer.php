<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

use Spacetab\Transformation\Wrapper\NullWrapper;
use Spacetab\Transformation\Wrapper\WrapperInterface;

final class Transformer
{
    private Walker $rootWalker;
    private Walker $nestedWalker;

    public function __construct(?WrapperInterface $rootWrapper = null, ?WrapperInterface $nestedWrapper = null)
    {
        $this->setRootWrapper($rootWrapper ?: new NullWrapper);
        $this->setNestedWrapper($nestedWrapper ?: new NullWrapper);
    }

    public function setRootWrapper(WrapperInterface $wrapper): void
    {
        $this->rootWalker = new Walker($wrapper);
    }

    public function setNestedWrapper(WrapperInterface $wrapper): void
    {
        $this->nestedWalker = new Walker($wrapper);
    }

    public function disableWrapper(bool $root = true, bool $nested = true): self
    {
        $that = clone $this;

        if ($root) {
            $that->setRootWrapper(new NullWrapper);
        }

        if ($nested) {
            $that->setNestedWrapper(new NullWrapper);
        }

        return $that;
    }

    public function asItem(TransformInterface $transform, mixed $data = null): mixed
    {
        if ($transform instanceof WalkAwareInterface) {
            $transform->setWalker($this->nestedWalker);
        }

        return $this->rootWalker->item($transform, $data);
    }

    public function asCollection(TransformInterface $transform, array $items = []): array
    {
        if ($transform instanceof WalkAwareInterface) {
            $transform->setWalker($this->nestedWalker);
        }

        return $this->rootWalker->collection($transform, $items);
    }
}
