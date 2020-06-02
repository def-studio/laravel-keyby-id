<?php
    /**
     * Copyright (c) 2020. Def Studio (assistenza@defstudio.it)
     */

    namespace DefStudio\KeyBy\Traits;


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
    }
