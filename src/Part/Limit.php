<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Part;

final class Limit extends AbstractPart
{
    public static function getName(): string
    {
        return 'LIMIT';
    }
}
