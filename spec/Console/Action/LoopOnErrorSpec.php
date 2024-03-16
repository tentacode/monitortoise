<?php

declare(strict_types=1);

namespace spec\App\Console\Action;

use App\Console\Action\LoopOnError;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoopOnErrorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(LoopOnError::class);
    }

    public function it_does_not_loop_on_success(SymfonyStyle $io)
    {
        $this->__invoke($io, fn () => 1 + 1)->shouldNotThrow(\Throwable::class);
    }

    public function it_loops_on_error(SymfonyStyle $io)
    {
        $this->shouldThrow(new \RuntimeException('Max tries reached.'))
            ->during('__invoke', [
                $io,
                fn () => throw new \Exception('FAIL'),
            ]);
    }
}
