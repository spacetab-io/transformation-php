<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

use Spacetab\Transformation\Wrapper\WrapperInterface;

final class Walker
{
    public function __construct(
        private WrapperInterface $wrapper
    ) {}

    public function item(TransformInterface $transform, mixed $value): mixed
    {
        return $this->wrapper->item(
            $transform->transform($value)
        );
    }

    public function collection(TransformInterface $transform, array $items): array
    {
        $array = [];
        foreach ($items as $item) {
            $array[] = $transform->transform($item);
        }

        return $this->wrapper->collection($array);
    }
}
