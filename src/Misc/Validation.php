<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Misc;

use JetBrains\PhpStorm\Pure;
use Spacetab\Transformation;

final class Validation implements Transformation\TransformInterface
{
    public const VALIDATION_CODE = 'ValidationError';
    public const VALIDATION_MESSAGE = 'ErrorTransformer in the request data. Correct it and submit it again.';

    private ValidationError $error;
    private string $message;
    private string|int $code;

    public function __construct(
        ValidationError $error,
        string $message = self::VALIDATION_MESSAGE,
        int|string $code = self::VALIDATION_CODE,
    )
    {
        $this->error   = $error;
        $this->message = $message;
        $this->code    = $code;
    }

    #[Pure]
    public function transform(mixed $value = null): array
    {
        return [
            'error' => [
                'message'    => $this->message,
                'code'       => $this->code,
                'validation' => $this->error->getErrors()
            ]
        ];
    }
}
