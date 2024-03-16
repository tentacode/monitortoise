<?php

declare(strict_types=1);

namespace App\Feature\Account\Action;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class CreateNewUser
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(string $email, string $username): User
    {
        $user = new User(email: $email, username: $username);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
