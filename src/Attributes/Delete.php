<?php

namespace PHPMaker2024\taskinator_project_file\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Delete extends Map
{
    /**
     * Constructor
     *
     * @param mixed $args
     */
    public function __construct(...$args)
    {
        parent::__construct("DELETE", ...$args);
    }
}
