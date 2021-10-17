<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Wrapper;

interface WrapperInterface
{
    public function item(mixed $value): mixed;
    public function collection(iterable $items): iterable;
}
