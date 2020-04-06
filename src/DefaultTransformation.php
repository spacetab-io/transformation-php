<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

final class DefaultTransformation implements TransformationInterface
{
    /**
     * @var array
     */
    private array $array;

    /**
     * DefaultTransformation constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function doTransform(): array
    {
        return [
            'data' => $this->array
        ];
    }
}
