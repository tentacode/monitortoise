<?php

declare(strict_types=1);

namespace App\Command\Security;

use App\Console\Action\LoopOnError;
use App\Feature\Account\Action\CreateNewUser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(name: 'security:create-user', description: 'Create a new user')]
class CreateUserCommand extends Command
{
    public function __construct(
        private CreateNewUser $createNewUser,
        private LoopOnError $loopOnError,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        global $email, $username;

        ($this->loopOnError)($io, function () use ($io) {
            $email = $io->ask('Email?');
            Assert::email($email);
        });

        ($this->loopOnError)($io, function () use ($io) {
            $username = $io->ask('Username?');
            Assert::string($username);
            Assert::lengthBetween($username, 3, 30);
        });

        $user = ($this->createNewUser)($email, $username);

        $io->success(sprintf(
            'User with id "%s" and uuid "%s" was created.',
            $user->getId(),
            $user->getUuid(),
        ));

        return Command::SUCCESS;
    }
}
