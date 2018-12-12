<?php

declare(strict_types = 1);

namespace spec\drupol\phptree\Node;

use drupol\phptree\Node\ValueNode;
use PhpSpec\ObjectBehavior;

class ValueNodeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ValueNode::class);

        $this->children()->shouldReturn([]);
    }

    public function it_can_be_set_with_a_value()
    {
        $this
            ->beConstructedWith('root');

        $this
            ->getValue()
            ->shouldReturn('root');
    }
}