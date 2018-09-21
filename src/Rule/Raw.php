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
        if (strpos($this->expression, ':value') === false) {
            return new Criterion($this->expression, []);
        }

        $paramKey = $paramGenerator->generate($this->paramPrefix);

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
