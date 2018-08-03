<?php declare(strict_types=1);

namespace Acelot\SearchSchema;

interface RuleInterface
{
    /**
     * @param mixed                   $value
     * @param ParamGeneratorInterface $paramGenerator
     *
     * @return Criterion|null
     */
    public function makeCriterion($value, ParamGeneratorInterface $paramGenerator): ?Criterion;
}
