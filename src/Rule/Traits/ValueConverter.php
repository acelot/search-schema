<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule\Traits;

trait ValueConverter
{
    /**
     * @var callable
     */
    protected $converter;

    /**
     * @return callable|null
     */
    public function getConverter(): ?callable
    {
        return $this->converter;
    }

    /**
     * @param callable $converter
     *
     * @return static
     */
    public function withConverter(callable $converter)
    {
        $clone = clone $this;
        $clone->converter = $converter;
        return $clone;
    }

    /**
     * @return static
     */
    public function withoutConverter()
    {
        $clone = clone $this;
        $clone->converter = null;
        return $clone;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function convert($value)
    {
        $converter = $this->converter;
        if ($converter) {
            return $converter($value);
        }

        return $value;
    }
}
