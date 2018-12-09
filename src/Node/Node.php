<?php

declare(strict_types = 1);

namespace drupol\phptree\Node;

/**
 * Class Node
 */
class Node implements NodeInterface
{
    /**
     * The storage property.
     *
     * @var array
     */
    protected $storage;

    /**
     * Node constructor.
     *
     * @param \drupol\phptree\Node\NodeInterface|NULL $parent
     */
    public function __construct(NodeInterface $parent = null)
    {
        $this->storage = [
            'parent' => $parent,
            'children' => [],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function add(NodeInterface ...$nodes): NodeInterface
    {
        foreach ($nodes as $node) {
            $this->storage['children'][] = $node->setParent($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(NodeInterface ...$nodes): NodeInterface
    {
        $this->storage['children'] = \array_filter(
            $this->storage['children'],
            function ($child) use ($nodes) {
                return !\in_array($child, $nodes, true);
            }
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(NodeInterface $node): NodeInterface
    {
        $this->storage['parent'] = $node;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?NodeInterface
    {
        return $this->storage['parent'];
    }

    /**
     * {@inheritdoc}
     */
    public function children(): array
    {
        return $this->storage['children'];
    }

    /**
     * {@inheritdoc}
     */
    public function getAncestors(): array
    {
        $parents = [];
        $node = $this;
        while ($parent = $node->getParent()) {
            \array_unshift($parents, $parent);
            $node = $parent;
        }

        return $parents;
    }

    /**
     * {@inheritdoc}
     */
    public function isLeaf(): bool
    {
        return [] === $this->children();
    }

    /**
     * {@inheritdoc}
     */
    public function isRoot(): bool
    {
        return null === $this->getParent();
    }

    /**
     * {@inheritdoc}
     */
    public function getSibblings(): array
    {
        $parent = $this->getParent();

        if (null === $parent) {
            return [];
        }

        $sibblings = $parent->children();

        $node = $this;

        return \array_values(
            \array_filter(
                $sibblings,
                function ($child) use ($node) {
                    return $child !== $node;
                }
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function degree(): int
    {
        return \count($this->storage['children']);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \array_reduce(
            $this->children(),
            function ($carry, $node) {
                return 1 + $carry + $node->count();
            },
            0
        );
    }
}