<?php

namespace spec\drupol\phptree\Node;

use drupol\phptree\Node\KeyValueNode;
use PhpSpec\ObjectBehavior;

class KeyValueNodeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(KeyValueNode::class);
    }

    public function it_can_be_set_with_a_key_and_value()
    {
        $this
            ->beConstructedWith('key', 'root');

        $this
            ->getKey()
            ->shouldReturn('key');

        $this
            ->getValue()
            ->shouldReturn('root');
    }
}
