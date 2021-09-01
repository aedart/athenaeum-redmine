<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Listable;

/**
 * Issue Status Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_IssueStatuses
 *
 * @property int $id
 * @property string $name
 * @property bool $is_closed
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class IssueStatus extends RedmineResource implements
    Listable
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'is_closed' => 'bool'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'issue_statuses';
    }
}
