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
        if (strpos($this->expression, ':value') === false) {
            return new Criterion($this->expression, []);
        }

        $paramKey = $paramGenerator->generate('raw');

        if (is_iterable($value)) {
            if (count($value) === 0) {
                return null;
            }

            $params = [];
            foreach ($value as $i => $item) {
                $params[$paramKey . '_' . $i] = $item;
            }

            return new Criterion(str_replace(':value', join(',', array_keys($params)), $this->expression), $params);
        }

        return new Criterion(str_replace(':value', $paramKey, $this->expression), [$paramKey => $value]);
    }
}
