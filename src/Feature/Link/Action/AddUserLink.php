<?php

declare(strict_types=1);

namespace App\Feature\Link\Action;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

final class AddUserLink
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(): void
    {
        $this->em->getConnection()->transactional(function (Connection $connection) {
            $this->em->flush();
        });
    }
}
