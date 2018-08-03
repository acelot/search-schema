<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

final class Like extends AbstractSimpleRule
{
    /**
     * @var bool
     */
    private $caseSensitive = false;

    /**
     * @return Like
     */
    public function caseInsensitive(): Like
    {
        $clone = clone $this;
        $clone->caseSensitive = false;
        return $clone;
    }

    /**
     * @return Like
     */
    public function caseSensitive(): Like
    {
        $clone = clone $this;
        $clone->caseSensitive = true;
        return $clone;
    }

    protected function getOperator(): string
    {
        return $this->caseSensitive ? 'LIKE' : 'ILIKE';
    }
}
