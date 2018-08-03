<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

use Acelot\SearchSchema\Criterion;
use Acelot\SearchSchema\ParamGeneratorInterface;
use Acelot\SearchSchema\RuleInterface;

final class Raw implements RuleInterface
{
    /**
     * @var string
     */
    protected $expression;

    /**
     * @param string $expression
     *
     * @return static
     */
    public static function create(string $expression)
    {
        return new static($expression);
    }

    /**
     * @param string $expression
     */
    public function __construct(string $expression)
    {
        $this->expression = $expression;
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
        $params = [];

        if (strpos($this->expression, ':value') !== false) {
            $params[$paramGenerator->generate('raw')] = $value;
            $this->expression = str_replace(':value', key($params), $this->expression);
        }

        return new Criterion($this->expression, $params);
    }
}
