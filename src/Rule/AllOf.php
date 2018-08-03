<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

final class AllOf extends AbstractCombiningRule
{
    protected function getOperator(): string
    {
        return 'AND';
    }
}
