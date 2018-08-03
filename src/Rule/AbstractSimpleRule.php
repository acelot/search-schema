<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

use Acelot\SearchSchema\Criterion;
use Acelot\SearchSchema\ParamGeneratorInterface;
use Acelot\SearchSchema\Rule\Traits\StaticValue;
use Acelot\SearchSchema\Rule\Traits\ValueConverter;
use Acelot\SearchSchema\RuleInterface;

abstract class AbstractSimpleRule implements RuleInterface
{
    use StaticValue;
    use ValueConverter;

    /**
     * @var string
     */
    protected $field;

    /**
     * @param string $field
     *
     * @return static
     */
    public static function create(string $field)
    {
        return new static($field);
    }

    /**
     * @param string $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @param mixed                   $value
     * @param ParamGeneratorInterface $paramGenerator
     *
     * @return Criterion|null
     * @throws \Exception
     */
    public function makeCriterion($value, ParamGeneratorInterface $paramGenerator): ?Criterion
    {
        $value = $this->hasStaticValue ? $this->staticValue : $value;
        $value = $this->convert($value);
        $param = $paramGenerator->generate($this->field);

        return new Criterion(sprintf('%s %s %s', $this->field, $this->getOperator(), $param), [$param => $value]);
    }

    /**
     * @return string
     */
    protected abstract function getOperator(): string;
}
