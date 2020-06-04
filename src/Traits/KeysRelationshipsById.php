<?php
    /**
     * Copyright (c) 2020. Def Studio (assistenza@defstudio.it)
     */

    namespace DefStudio\KeyBy\Traits;


    use DefStudio\KeyBy\Database\Eloquent\Relations\BelongsToMany;
    use DefStudio\KeyBy\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    trait KeysRelationshipsById{

        /**
         * Define a one-to-many relationship.
         *
         * @param string $related
         * @param string|null $foreignKey
         * @param string|null $localKey
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function hasMany($related, $foreignKey = null, $localKey = null){
            $instance = $this->newRelatedInstance($related);

            $foreignKey = $foreignKey ?: $this->getForeignKey();

            $localKey = $localKey ?: $this->getKeyName();

            return $this->newHasMany($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey);
        }

        /**
         * Instantiate a new HasMany relationship.
         *
         * @param Builder $query
         * @param Model $parent
         * @param string $foreignKey
         * @param string $localKey
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        protected function newHasMany(Builder $query, Model $parent, $foreignKey, $localKey){
            return new HasMany($query, $parent, $foreignKey, $localKey);
        }

        /**
         * Define a many-to-many relationship.
         *
         * @param string $related
         * @param string|null $table
         * @param string|null $foreignPivotKey
         * @param string|null $relatedPivotKey
         * @param string|null $parentKey
         * @param string|null $relatedKey
         * @param string|null $relation
         * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
         */
        public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $relation = null){
            // If no relationship name was passed, we will pull backtraces to get the
            // name of the calling function. We will use that function name as the
            // title of this relation since that is a great convention to apply.
            if(is_null($relation)){
                $relation = $this->guessBelongsToManyRelation();
            }

            // First, we'll need to determine the foreign key and "other key" for the
            // relationship. Once we have determined the keys we'll make the query
            // instances as well as the relationship instances we need for this.
            $instance = $this->newRelatedInstance($related);

            $foreignPivotKey = $foreignPivotKey ?: $this->getForeignKey();

            $relatedPivotKey = $relatedPivotKey ?: $instance->getForeignKey();

            // If no table name was provided, we can guess it by concatenating the two
            // models using underscores in alphabetical order. The two model names
            // are transformed to snake case from their default CamelCase also.
            if(is_null($table)){
                $table = $this->joiningTable($related, $instance);
            }

            return $this->newBelongsToMany($instance->newQuery(), $this, $table, $foreignPivotKey, $relatedPivotKey, $parentKey ?: $this->getKeyName(), $relatedKey ?: $instance->getKeyName(), $relation);
        }

        /**
         * Instantiate a new BelongsToMany relationship.
         *
         * @param Builder $query
         * @param Model $parent
         * @param string $table
         * @param string $foreignPivotKey
         * @param string $relatedPivotKey
         * @param string $parentKey
         * @param string $relatedKey
         * @param string|null $relationName
         * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
         */
        protected function newBelongsToMany(Builder $query, Model $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName = null){
            return new BelongsToMany($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
        }
    }
