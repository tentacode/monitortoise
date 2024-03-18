<?php

declare(strict_types=1);

namespace App\Tests\Console\Action;

use App\Console\Action\LoopOnError;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoopOnErrorTest extends TestCase
{
    #[Test]
    public function it_executes_working_callable(): void
    {
        $io = $this->createMock(SymfonyStyle::class);
        $loopOnError = new LoopOnError();

        $counter = 0;
        $loopOnError($io, function () use (&$counter) {
            $counter++;
        });

        $this->assertSame(1, $counter);
    }

    #[Test]
    public function it_fails_after_max_attemps(): void
    {
        // during failure, the error message should be printed each time in the console
        $io = $this->createMock(SymfonyStyle::class);
        $io->expects($this->exactly(4))
            ->method('error')
            ->with('FAIL');

        $loopOnError = new LoopOnError();

        $this->expectExceptionObject(new \RuntimeException('Max tries reached.'));

        $counter = 0;

        try {
            $loopOnError(
                $io,
                function () use (&$counter) {
                    $counter++;
                    throw new \Exception('FAIL');
                },
                4 // this is a number of attempts
            );
        } finally {
            $this->assertSame(4, $counter);
        }
    }
}
