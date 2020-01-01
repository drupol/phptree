<?php

declare(strict_types=1);

namespace loophp\phptree\Exporter;

use InvalidArgumentException;
use loophp\phptree\Node\NodeInterface;
use loophp\phptree\Node\ValueNodeInterface;

/**
 * Class SimpleArray.
 */
class SimpleArray extends AbstractExporter
{
    /**
     * {@inheritdoc}
     */
    public function export(NodeInterface $node)
    {
        if (!($node instanceof ValueNodeInterface)) {
            throw new InvalidArgumentException('Must implements ValueNodeInterface');
        }

        $children = [];
        /** @var ValueNodeInterface $child */
        foreach ($node->children() as $child) {
            $children[] = $this->export($child);
        }

        return [] === $children ?
            ['value' => $this->getNodeRepresentation($node)] :
            ['value' => $this->getNodeRepresentation($node), 'children' => $children];
    }
}
