<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Rule\SwitchRules;

use Acelot\SearchSchema\RuleInterface;

final class SwitchCase
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * @param               $value
     * @param RuleInterface $rule
     *
     * @return SwitchCase
     */
    public static function create($value, RuleInterface $rule): SwitchCase
    {
        return new SwitchCase($value, $rule);
    }

    /**
     * @param mixed         $value
     * @param RuleInterface $rule
     */
    public function __construct($value, RuleInterface $rule)
    {
        $this->value = $value;
        $this->rule = $rule;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return RuleInterface
     */
    public function getRule(): RuleInterface
    {
        return $this->rule;
    }
}
