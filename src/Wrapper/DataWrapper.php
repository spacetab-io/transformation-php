<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Wrapper;

final class DataWrapper implements WrapperInterface
{
    private const KEY = 'data';

    public function item(mixed $value): array
    {
        return [
            self::KEY => $value
        ];
    }

    public function collection(array $items): array
    {
        return [
            self::KEY => $items
        ];
    }
}
