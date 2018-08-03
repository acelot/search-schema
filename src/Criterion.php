<?php declare(strict_types=1);

namespace Acelot\SearchSchema;

class Criterion
{
    /**
     * @var string
     */
    private $expression;

    /**
     * @var array
     */
    private $params;

    /**
     * Criteria constructor.
     *
     * @param string $expression
     * @param array  $params
     */
    public function __construct(string $expression, array $params = [])
    {
        $this->expression = $expression;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getExpression(): string
    {
        return $this->expression;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
