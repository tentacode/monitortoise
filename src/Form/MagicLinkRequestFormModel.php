<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

class MagicLinkRequestFormModel
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
}
