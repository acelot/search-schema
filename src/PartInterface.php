<?php declare(strict_types=1);

namespace Acelot\SearchSchema;

interface PartInterface
{
    /**
     * @return string
     */
    public static function getName(): string;

    /**
     * @return string
     */
    public function getFilterKey(): string;

    /**
     * @return RuleInterface
     */
    public function getRule(): RuleInterface;
}
