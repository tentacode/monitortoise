<?php

declare(strict_types=1);

namespace App\Feature\Account\Exception;

final class UserNotFoundException extends \RuntimeException
{
    public function __construct(
        string $message = 'User not found',
        int $code = 0,
        \Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
