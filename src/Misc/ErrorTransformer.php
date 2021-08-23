<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Misc;

use Spacetab\Transformation\TransformInterface;

final class ErrorTransformer implements TransformInterface
{
    public const DEFAULT_ERROR_CODE = 'AppError';
    public const ERROR_OCCURRED_IN_APP = 'Oops! Error occurred.';

    private string $message;
    private int|string $code;
    private array $stacktrace;

    public function __construct(
        string $message = self::ERROR_OCCURRED_IN_APP,
        int|string $code = self::DEFAULT_ERROR_CODE,
        array $stacktrace = [],
    ) {
        $this->message = $message;
        $this->code = $code;
        $this->stacktrace = $stacktrace;
    }

    public function transform(mixed $value = null): array
    {
        return [
            'error' => [
                'message'    => $this->message,
                'code'       => $this->code,
                'stacktrace' => $this->stacktrace,
            ]
        ];
    }
}
