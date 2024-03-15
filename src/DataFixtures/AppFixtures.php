<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function __construct(
        private string $projectDirectory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $objectSet = $loader->loadFile(sprintf('%s/resources/fixtures/users.yml', $this->projectDirectory));
        foreach ($objectSet->getObjects() as $user) {
            $manager->persist($user);
        }

        $manager->flush();
    }
}
