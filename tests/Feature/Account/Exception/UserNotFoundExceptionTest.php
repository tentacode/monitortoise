<?php

declare(strict_types=1);

namespace App\Tests\Feature\Account\Exception;

use App\Feature\Account\Exception\UserNotFoundException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UserNotFoundExceptionTest extends TestCase
{
    #[Test]
    public function it_has_proper_defaults(): void
    {
        $exception = new UserNotFoundException();

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertSame('User not found', $exception->getMessage());
    }

    #[Test]
    public function it_can_be_constructed_with_standard_exceptions_arguments(): void
    {
        $exception = new UserNotFoundException(
            'Custom message',
            42,
            new \Exception('Previous')
        );

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertSame('Custom message', $exception->getMessage());
        $this->assertSame(42, $exception->getCode());
        $this->assertEquals(new \Exception('Previous'), $exception->getPrevious());
    }
}
