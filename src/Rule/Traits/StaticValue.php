<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule\Traits;

trait StaticValue
{
    /**
     * @var bool
     */
    protected $hasStaticValue;

    /**
     * @var mixed
     */
    protected $staticValue;

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function withStaticValue($value)
    {
        $clone = clone $this;
        $clone->hasStaticValue = true;
        $clone->staticValue = $value;
        return $clone;
    }

    /**
     * @return static
     */
    public function withoutStaticValue()
    {
        $clone = clone $this;
        $clone->hasStaticValue = false;
        $clone->staticValue = null;
        return $clone;
    }
}
