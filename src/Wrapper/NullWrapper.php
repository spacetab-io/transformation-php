<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Wrapper;

final class NullWrapper implements WrapperInterface
{
    public function item(mixed $value): mixed
    {
        return $value;
    }

    public function collection(array $items): array
    {
        return $items;
    }
}
