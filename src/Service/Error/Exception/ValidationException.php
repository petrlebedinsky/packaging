<?php

declare(strict_types=1);

namespace App\Service\Error\Exception;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    /**
     * @param string[] $validations
     */
    public function __construct(private readonly array $validations, int $code = 422, ?Throwable $previous = null)
    {
        parent::__construct('', $code, $previous);
    }

    /**
     * @return string[]
     */
    public function getValidations(): array
    {
        return $this->validations;
    }

    public function getValidationsAsString(): string
    {
        $validationMessage = '';
        foreach($this->validations as $validation) {
            $validationMessage .= $validation . PHP_EOL;
        }
        return $validationMessage;
    }
}
