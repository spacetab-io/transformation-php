<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

use Spacetab\Transformation\Wrapper\WrapperInterface;

final class Walker
{
    public function __construct(
        private WrapperInterface $wrapper,
        private bool $pushDeeper = false
    ) {}

    public function item(TransformInterface $transform, mixed $value): mixed
    {
        if ($this->pushDeeper && $transform instanceof WalkAwareInterface) {
            $transform->setWalker($this);
        }

        return $this->wrapper->item(
            $transform->transform($value)
        );
    }

    public function collection(TransformInterface $transform, iterable $items): array
    {
        if ($this->pushDeeper && $transform instanceof WalkAwareInterface) {
            $transform->setWalker($this);
        }

        $array = [];
        foreach ($items as $item) {
            $array[] = $transform->transform($item);
        }

        return $this->wrapper->collection($array);
    }
}
