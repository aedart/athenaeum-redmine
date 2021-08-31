<?php

namespace Aedart\Redmine\Partials;

/**
 * List Of Possible Values
 *
 * @see PossibleValue
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfPossibleValues extends NestedList
{
    /**
     * @inheritDoc
     */
    public function itemType(): string
    {
        return PossibleValue::class;
    }
}
