<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

use Acelot\SearchSchema\Criterion;
use Acelot\SearchSchema\ParamGeneratorInterface;
use Acelot\SearchSchema\Rule\Traits\ValueConverter;
use Acelot\SearchSchema\RuleInterface;

final class Not implements RuleInterface
{
    use ValueConverter;

    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * @param RuleInterface $rule
     *
     * @return static
     */
    public static function create(RuleInterface $rule)
    {
        return new static($rule);
    }

    /**
     * @param RuleInterface $rule
     */
    public function __construct(RuleInterface $rule)
    {
        $this->rule = $rule;
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
        $criterion = $this->rule->makeCriterion($value, $paramGenerator);

        return  $criterion instanceof Criterion ?
            new Criterion(sprintf('NOT (%s)', $criterion->getExpression()), $criterion->getParams()) : null;
    }
}
