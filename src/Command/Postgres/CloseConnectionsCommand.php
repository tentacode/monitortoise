<?php

declare(strict_types=1);

namespace App\Command\Postgres;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(name: 'postgres:close-connections', description: 'Force closing all connections to the database.')]
class CloseConnectionsCommand extends Command
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // checking if the database exists
        try {
            $this->em->getConnection()
                ->getDatabase();
        } catch (\Throwable $e) {
            if (str_contains($e->getMessage(), 'does not exist')) {
                $io->comment('No need to close connection, database does not exist.');

                return Command::SUCCESS;
            }

            throw $e;
        }

        $sql = <<<SQL
            SELECT pg_terminate_backend(pid) 
            FROM pg_stat_activity WHERE datname = current_database();
            SQL;

        try {
            $connection = $this->em->getConnection();
            $pdo = $connection->getNativeConnection();
            Assert::isInstanceOf($pdo, \PDO::class);

            $statement = $pdo->prepare($sql);
            $statement->execute();
        } catch (\Throwable $e) {
            // Closing connections throws an exception, this is to be expected.
            if (
                str_contains($e->getMessage(), 'connection has been closed unexpectedly')
                || str_contains($e->getMessage(), 'server closed the connection unexpectedly')
            ) {
                $io->success('All connections have been closed.');

                return Command::SUCCESS;
            }

            throw $e;
        }

        throw new \LogicException('An exception was expected.');
    }
}
