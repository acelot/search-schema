<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

use Acelot\SearchSchema\Criterion;
use Acelot\SearchSchema\ParamGeneratorInterface;
use Acelot\SearchSchema\Rule\Traits\ValueConverter;
use Acelot\SearchSchema\RuleInterface;

final class Raw implements RuleInterface
{
    use ValueConverter;

    /**
     * @var string
     */
    protected $expression;

    /**
     * @var string
     */
    protected $paramPrefix;

    /**
     * @param string $expression
     * @param string $paramPrefix
     *
     * @return static
     */
    public static function create(string $expression, string $paramPrefix = 'raw')
    {
        return new static($expression, $paramPrefix);
    }

    /**
     * @param string $expression
     * @param string $paramPrefix
     */
    public function __construct(string $expression, string $paramPrefix = 'raw')
    {
        $this->expression = $expression;
        $this->paramPrefix = $paramPrefix;
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
        if (strpos($this->expression, ':value') !== false) {
            return $this->makeScalarCriterion($value, $paramGenerator);
        } elseif (is_iterable($value)) {
            return $this->makeIterableCriterion($value, $paramGenerator);
        }

        return new Criterion($this->expression, []);
    }

    /**
     * @param iterable $values
     * @param ParamGeneratorInterface $paramGenerator
     * @return Criterion|null
     */
    private function makeIterableCriterion(iterable $values, ParamGeneratorInterface $paramGenerator): ?Criterion
    {
        if (count($values) === 0) {
            return null;
        }
        $paramKey = $paramGenerator->generate($this->paramPrefix);
        $values = $this->convert($values);

        $params = [];
        $expression = $this->expression;
        foreach ($values as $key => $value) {
            $bindKey = $paramKey . '_' . $key;
            $params[$bindKey] = $value;
            $expression = str_replace(":{$key}", $bindKey, $expression);
        }

        return new Criterion($expression, $params);
    }

    /**
     * @param mixed $value
     * @param ParamGeneratorInterface $paramGenerator
     * @return Criterion
     */
    private function makeScalarCriterion($value, ParamGeneratorInterface $paramGenerator): Criterion
    {
        $paramKey = $paramGenerator->generate($this->paramPrefix);
        $value = $this->convert($value);

        return new Criterion(str_replace(':value', $paramKey, $this->expression), [$paramKey => $value]);
    }
}
