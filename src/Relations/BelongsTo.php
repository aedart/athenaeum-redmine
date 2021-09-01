<?php

namespace Aedart\Redmine\Relations;

use Aedart\Contracts\Dto;
use Aedart\Contracts\Redmine\Resource;
use Aedart\Redmine\Exceptions\RelationException;

/**
 * Belongs To Resource Relation
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Relations
 */
class BelongsTo extends ResourceRelation
{
    /**
     * Reference Dto in parent resource that holds
     * foreign key to related resource
     *
     * @var Dto|null
     */
    protected ?Dto $reference = null;

    /**
     * Name of key / property in reference that holds
     * the foreign key value
     *
     * @var string
     */
    protected string $key;

    /**
     * Foreign key value
     *
     * @var string|int|null
     */
    protected $foreignKeyValue = null;

    /**
     * @param Resource $parent
     * @param string|Resource $related Class path
     * @param Dto|null $reference [optional] Reference Dto in parent resource that holds foreign key to
     *                                       related resource
     *
     * @param string $key [optional] Name of key / property in reference that holds
     *                               the foreign key value
     */
    public function __construct(Resource $parent, $related, ?Dto $reference = null, string $key = 'id')
    {
        parent::__construct($parent, $related);

        $this
            ->usingReference($reference)
            ->usingKey($key);
    }

    /**
     * @inheritdoc
     */
    public function fetch()
    {
        // Resolve the foreign key value - or fail if no value obtained
        $key = $this->key();
        if (!isset($key)) {
            throw new RelationException('Unable to fetch relation, foreign key could not be resolved or was not specified');
        }

        // Obtain related resource and fetch a single resource
        return $this->related()::fetch(
            $key,
            $this->wrapFilters(),
            $this->getConnection()
        );
    }

    /**
     * Set the foreign key value directly
     *
     * **Note**: _When this value is given, then reference Dto is completely
     * bypassed!_
     *
     * @param string|int $value
     *
     * @return self
     */
    public function foreignKey($value)
    {
        $this->foreignKeyValue = $value;

        return $this;
    }

    /**
     * Set reference Dto in parent resource that holds
     * foreign key to related resource
     *
     * @param Dto|null $reference [optional]
     *
     * @return self
     */
    public function usingReference(?Dto $reference = null)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference Dto in parent resource that holds
     * foreign key to related resource
     *
     * @return Dto|null
     */
    public function getReference(): ?Dto
    {
        return $this->reference;
    }

    /**
     * Set the name of key / property in the reference that holds
     * the foreign key value
     *
     * @param string $key
     *
     * @return self
     */
    public function usingKey(string $key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the name of key / property in the reference that holds
     * the foreign key value
     *
     * @return string
     */
    public function keyName(): string
    {
        return $this->key;
    }

    /**
     * Returns the foreign key value
     *
     * @return int|string|null
     */
    public function key()
    {
        if (!isset($this->foreignKeyValue)) {
            $this->foreignKey(
                $this->resolveForeignKeyFromReference()
            );
        }

        return $this->foreignKeyValue;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves the foreign key value from the reference Dto
     *
     * @return string|int|null
     */
    protected function resolveForeignKeyFromReference()
    {
        $key = $this->keyName();

        return optional($this->getReference())->{$key};
    }
}