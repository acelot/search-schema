<?php declare(strict_types=1);

namespace Acelot\SearchSchema\ParamGenerator;

use Acelot\SearchSchema\ParamGeneratorInterface;

class DefaultGenerator implements ParamGeneratorInterface
{
    private $fieldsCounter = [];

    public function generate(string $field): string
    {
        if (!isset($this->fieldsCounter[$field])) {
            $this->fieldsCounter[$field] = 0;
        } else {
            $this->fieldsCounter[$field]++;
        }

        return sprintf(
            ':%s_%s',
            preg_replace('/[^\w]/', '_', $field),
            $this->fieldsCounter[$field]
        );
    }
}
