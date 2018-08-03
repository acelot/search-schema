<?php declare(strict_types=1);

namespace Acelot\SearchSchema;

interface ParamGeneratorInterface
{
    public function generate(string $field): string;
}
