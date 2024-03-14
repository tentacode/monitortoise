<?php

declare(strict_types=1);

namespace spec\App;

use App\Kernel;
use PhpSpec\ObjectBehavior;

class KernelSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('dev', true);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Kernel::class);
    }
}
