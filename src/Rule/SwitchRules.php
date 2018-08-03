<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

use Acelot\SearchSchema\Criterion;
use Acelot\SearchSchema\ParamGeneratorInterface;
use Acelot\SearchSchema\Rule\SwitchRules\SwitchCase;
use Acelot\SearchSchema\RuleInterface;
use Acelot\SearchSchema\Rule\Traits\ValueConverter;

final class SwitchRules implements RuleInterface
{
    use ValueConverter;

    /**
     * @var SwitchCase[]
     */
    protected $cases;

    /**
     * @param SwitchCase ...$cases
     *
     * @return static
     */
    public static function create(SwitchCase ...$cases)
    {
        return new static(...$cases);
    }

    /**
     * @param SwitchCase ...$cases
     */
    public function __construct(SwitchCase ...$cases)
    {
        $this->cases = $cases;
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

        foreach ($this->cases as $case) {
            if ($case->getValue() === $value) {
                return $case->getRule()->makeCriterion($value, $paramGenerator);
            }
        }

        return null;
    }
}
