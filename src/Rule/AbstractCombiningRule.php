<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

use Acelot\SearchSchema\Criterion;
use Acelot\SearchSchema\ParamGeneratorInterface;
use Acelot\SearchSchema\Rule\Traits\ValueConverter;
use Acelot\SearchSchema\RuleInterface;

abstract class AbstractCombiningRule implements RuleInterface
{
    use ValueConverter;

    /**
     * @var RuleInterface[]
     */
    protected $rules;

    /**
     * @param RuleInterface ...$rules
     *
     * @return static
     */
    public static function create(RuleInterface ...$rules)
    {
        return new static(...$rules);
    }

    /**
     * @param RuleInterface ...$rules
     */
    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param mixed                   $value
     * @param ParamGeneratorInterface $paramGenerator
     *
     * @return Criterion|null
     */
    public function makeCriterion($value, ParamGeneratorInterface $paramGenerator): ?Criterion
    {
        $value = $this->convert($value);

        $criteria = array_map(function (RuleInterface $rule) use ($value, $paramGenerator) {
            return $rule->makeCriterion($value, $paramGenerator);
        }, $this->rules);

        $criteria = array_filter($criteria);
        if (empty($criteria)) {
            return null;
        }

        $expr = join(' ' . static::getOperator() . ' ', array_map(function (Criterion $part) {
            return '(' . $part->getExpression() . ')';
        }, $criteria));

        $params = array_merge(...array_map(function (Criterion $part) {
            return $part->getParams();
        }, $criteria));

        return new Criterion($expr, $params);
    }

    /**
     * @return string
     */
    abstract protected function getOperator(): string;
}
