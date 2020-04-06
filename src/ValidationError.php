<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

final class ValidationError
{
    /**
     * dot.notation.path => [value1, value2]
     *
     * @var array<string, array>
     */
    private array $messages = [];

    /**
     * @param string $path
     * @param string $message
     */
    public function addError(string $path, string $message): void
    {
        $this->messages[$path][] = $message;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->messages;
    }
}
