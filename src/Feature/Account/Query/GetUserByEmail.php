<?php

declare(strict_types=1);

namespace App\Feature\Account\Query;

use App\Entity\User;
use App\Feature\Account\Exception\UserNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Webmozart\Assert\Assert;

final class GetUserByEmail
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(string $email): User
    {
        Assert::email($email);

        $qb = $this->em->createQueryBuilder();

        $qb->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        try {
            $user = $qb->getQuery()->getSingleResult();
            Assert::isInstanceOf($user, User::class);
        } catch (NoResultException $e) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
