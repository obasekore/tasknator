<?php

namespace PHPMaker2024\taskinator_project_file;

use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Page Unloaded Event
 */
class PageUnloadedEvent extends GenericEvent
{
    public const NAME = "page.unloaded";

    public function getPage(): mixed
    {
        return $this->subject;
    }
}
