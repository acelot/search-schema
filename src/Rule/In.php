<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule;

use Acelot\SearchSchema\Criterion;
use Acelot\SearchSchema\ParamGeneratorInterface;
use Acelot\SearchSchema\RuleInterface;
use Acelot\SearchSchema\Rule\Traits\StaticValue;
use Acelot\SearchSchema\Rule\Traits\ValueConverter;

final class In implements RuleInterface
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

        if (!is_iterable($value) || count($value) === 0) {
            return null;
        }

        $param = $paramGenerator->generate($this->field);
        $params = [];
        foreach ($value as $i => $item) {
            $params[$param . '_' . $i] = $item;
        }

        return new Criterion(sprintf('%s IN (%s)', $this->field, join(',', array_keys($params))), $params);
    }
}
