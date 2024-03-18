<?php

declare(strict_types=1);

namespace App\Tests\Console\Action;

use App\Form\MagicLinkRequestFormModel;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MagicLinkRequestFormModelTest extends KernelTestCase
{
    #[Test]
    public function it_has_a_valid_email_property(): void
    {
        $validator = static::getContainer()->get('validator');

        // proper email
        $magicLinkRequestFormModel = new MagicLinkRequestFormModel();
        $magicLinkRequestFormModel->email = 'foo@example.test';

        $violations = $validator->validate($magicLinkRequestFormModel);
        $this->assertEmpty($violations);

        // empty email
        $magicLinkRequestFormModel = new MagicLinkRequestFormModel();
        $magicLinkRequestFormModel->email = '';

        $violations = $validator->validate($magicLinkRequestFormModel);

        $this->assertCount(1, $violations);
        $this->assertSame('This value should not be blank.', $violations[0]->getMessage());

        // invalid email
        $magicLinkRequestFormModel = new MagicLinkRequestFormModel();
        $magicLinkRequestFormModel->email = 'foo';

        $violations = $validator->validate($magicLinkRequestFormModel);

        $this->assertSame('This value is not a valid email address.', $violations[0]->getMessage());
    }
}
