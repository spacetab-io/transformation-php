<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

final class ErrorTransformation implements TransformationInterface
{
    public const DEFAULT_ERROR_CODE = 'AppError';
    public const ERROR_OCCURRED_IN_APP = 'Oops! Error occurred in application.';

    /**
     * @var string|null
     */
    private ?string $message;

    /**
     * ErrorTransformation constructor.
     *
     * @param string $message
     */
    public function __construct(?string $message)
    {
        $this->message = $message;
    }

    public function doTransform(): array
    {
        return [
            'error' => [
                'message' => $this->message ?? self::ERROR_OCCURRED_IN_APP,
                'code'    => self::DEFAULT_ERROR_CODE,
            ]
        ];
    }
}
