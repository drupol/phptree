<?php

declare(strict_types=1);

namespace spec\loophp\phptree\Importer;

use InvalidArgumentException;
use loophp\phptree\Importer\Text;
use loophp\phptree\Node\ValueNode;
use loophp\phptree\Node\ValueNodeInterface;
use PhpSpec\ObjectBehavior;

class TextSpec extends ObjectBehavior
{
    public function it_can_import(): void
    {
        $string = '[root[A[C[G][H]][D[I][J]]][B[E][F]]]';

        $tree = new ValueNode('root', 2);

        $nodes = [];

        foreach (range('A', 'J') as $value) {
            $nodes[$value] = new ValueNode($value);
        }

        $tree->add(...array_values($nodes));

        $this
            ->import($string)
            ->shouldImplement(ValueNodeInterface::class);

        $this
            ->import($string)
            ->count()
            ->shouldReturn(10);

        $this
            ->import($string)
            ->isRoot()
            ->shouldReturn(true);

        $this
            ->import($string)
            ->getValue()
            ->shouldReturn('root');
    }

    public function it_can_throw_an_error_when_cannot_import(): void
    {
        $string = 'invalid string';

        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->during('import', [$string]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Text::class);
    }
}