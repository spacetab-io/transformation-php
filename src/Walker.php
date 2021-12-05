<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

use ArrayAccess;
use Spacetab\Transformation\Wrapper\WrapperInterface;

final class Walker implements ArrayAccess
{
    private array $options = [];

    public function __construct(
        private WrapperInterface $wrapper,
        private bool $pushDeeper = false
    ) {}

    public function withOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function item(TransformInterface $transform, mixed $value, array $options = []): mixed
    {
        if ($this->pushDeeper && $transform instanceof WalkAwareInterface) {
            $this->options = array_merge($transform::WALKER_DEFAULTS, $this->options, $options);
            $transform->setWalker($this);
        }

        return $this->wrapper->item(
            $transform->transform($value)
        );
    }

    public function collection(TransformInterface $transform, iterable $items, array $options = []): iterable
    {
        if ($this->pushDeeper && $transform instanceof WalkAwareInterface) {
            $this->options = array_merge($transform::WALKER_DEFAULTS, $this->options, $options);
            $transform->setWalker($this);
        }

        $array = [];
        foreach ($items as $item) {
            $array[] = $transform->transform($item);
        }

        return $this->wrapper->collection($array);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->options[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->options[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \InvalidArgumentException();
    }

    public function offsetUnset(mixed $offset): void {}
}
