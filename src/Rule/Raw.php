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
        if (!preg_match('/(\:|\.\.\.)value/', $this->expression, $matches)) {
            return new Criterion($this->expression, []);
        }

        $spread = $matches[1] === '...';
        $paramKey = $paramGenerator->generate($this->paramPrefix);

        $value = $this->convert($value);

        if (is_iterable($value) && $spread) {
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
