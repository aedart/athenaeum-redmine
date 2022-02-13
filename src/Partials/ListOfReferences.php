<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of References
 *
 * @see \Aedart\Redmine\Partials\Reference
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfReferences extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return Reference::class;
    }
}
