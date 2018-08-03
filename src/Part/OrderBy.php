<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Part;

final class OrderBy extends AbstractPart
{
    public static function getName(): string
    {
        return 'ORDER BY';
    }
}
