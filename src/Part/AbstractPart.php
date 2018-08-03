<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Part;

use Acelot\SearchSchema\PartInterface;
use Acelot\SearchSchema\RuleInterface;

abstract class AbstractPart implements PartInterface
{
    /**
     * @var string
     */
    protected $filterKey;

    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * @param string        $filterKey
     * @param RuleInterface $rule
     *
     * @return static
     */
    public static function create(string $filterKey, RuleInterface $rule)
    {
        return new static($filterKey, $rule);
    }

    /**
     * @param string        $key
     * @param RuleInterface $rule
     */
    public function __construct(string $key, RuleInterface $rule)
    {
        $this->filterKey = $key;
        $this->rule = $rule;
    }

    /**
     * @return string
     */
    public function getFilterKey(): string
    {
        return $this->filterKey;
    }

    /**
     * @return RuleInterface
     */
    public function getRule(): RuleInterface
    {
        return $this->rule;
    }

    /**
     * @return string
     */
    abstract public static function getName(): string;
}
