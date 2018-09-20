<?php declare(strict_types=1);

namespace Acelot\SearchSchema;

class Criteria
{
    /**
     * @var array
     */
    private $parts;

    /**
     * @var array
     */
    private $params;

    /**
     * @param array $parts
     * @param array $params
     */
    public function __construct(array $parts, array $params)
    {
        $this->parts = $parts;
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
