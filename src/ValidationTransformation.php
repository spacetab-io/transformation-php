<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

final class ValidationTransformation implements TransformationInterface
{
    public const VALIDATION_CODE = 'ValidationError';
    public const VALIDATION_MESSAGE = 'Error occurred in input data. Please, correct them and send request again.';

    /**
     * @var \Spacetab\Transformation\ValidationError
     */
    private ValidationError $error;

    /**
     * @var string
     */
    private string $message;

    /**
     * ValidationTransformation constructor.
     *
     * @param ValidationError $error
     * @param string $message
     */
    public function __construct(ValidationError $error, string $message = self::VALIDATION_MESSAGE)
    {
        $this->error   = $error;
        $this->message = $message;
    }

    public function doTransform(): array
    {
        return [
            'error' => [
                'message'    => $this->message,
                'code'       => self::VALIDATION_CODE,
                'validation' => $this->error->getErrors()
            ]
        ];
    }
}
