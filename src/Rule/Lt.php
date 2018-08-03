<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

final class Lt extends AbstractSimpleRule
{
    protected function getOperator(): string
    {
        return '<';
    }
}
