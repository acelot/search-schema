<?php declare(strict_types=1);

namespace Acelot\SearchSchema;

use Acelot\SearchSchema\ParamGenerator\DefaultGenerator;

class SearchSchema
{
    /**
     * @var PartInterface[]
     */
    protected $parts;

    /**
     * @param PartInterface ...$parts
     */
    public function __construct(PartInterface ...$parts)
    {
        foreach ($parts as $part) {
            $this->parts[$part->getFilterKey()] = $part;
        }
    }

    /**
     * @param PartInterface ...$parts
     *
     * @return SearchSchema
     */
    public function with(PartInterface ...$parts): SearchSchema
    {
        $clone = clone $this;
        foreach ($parts as $part) {
            $clone->parts[$part->getFilterKey()] = $part;
        }

        return $clone;
    }

    /**
     * @param string $key
     *
     * @return SearchSchema
     */
    public function without(string $key): SearchSchema
    {
        $clone = clone $this;
        unset($clone->parts[$key]);
        return $clone;
    }

    /**
     * @param array                        $terms
     * @param ParamGeneratorInterface|null $paramGenerator
     *
     * @return Criteria
     */
    public function build(array $terms, ParamGeneratorInterface $paramGenerator = null): Criteria
    {
        if (!$paramGenerator) {
            $paramGenerator = new DefaultGenerator();
        }

        $parts = [];
        $params = [];

        foreach ($this->parts as $part) {
            if (!array_key_exists($part->getFilterKey(), $terms)) {
                continue;
            }

            $value = $terms[$part->getFilterKey()];
            $criterion = $part->getRule()->makeCriterion($value, $paramGenerator);
            if (!$criterion) {
                continue;
            }

            $parts[$part::getName()][] = $criterion->getExpression();
            $params = array_merge($params, $criterion->getParams());
        }

        foreach (array_keys($parts) as $name) {
            $parts[$name] = join(' AND ', $parts[$name]);
        }

        return new Criteria($parts, $params);
    }
}
