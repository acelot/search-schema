<?php declare(strict_types=1);

namespace Acelot\SearchSchema\Part;

final class Where extends AbstractPart
{
    public static function getName(): string
    {
        return 'WHERE';
    }
}
