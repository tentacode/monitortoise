<?php

declare(strict_types=1);

namespace App\Console\Action;

use Symfony\Component\Console\Style\SymfonyStyle;

final class LoopOnError
{
    public function __invoke(SymfonyStyle $io, callable $action, int $maxTry = 3): void
    {
        try {
            $action();
        } catch (\Throwable $e) {
            $io->error($e->getMessage());

            $maxTry--;
            if ($maxTry <= 0) {
                throw new \RuntimeException('Max tries reached.');
            }

            $this->__invoke($io, $action, $maxTry);
        }
    }
}
