<?php

namespace PHPMaker2024\taskinator_project_file\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Options extends Map
{
    /**
     * Constructor
     *
     * @param mixed $args
     */
    public function __construct(...$args)
    {
        parent::__construct("OPTIONS", ...$args);
    }
}
