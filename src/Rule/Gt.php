<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

final class Gt extends AbstractSimpleRule
{
    protected function getOperator(): string
    {
        return '>';
    }
}
