<?php
    /**
     * Copyright (c) 2020. Def Studio (assistenza@defstudio.it)
     */

    namespace DefStudio\KeyBy\Database\Eloquent\Relations;


    class BelongsToMany extends \Illuminate\Database\Eloquent\Relations\BelongsToMany{
        public function getResults(){
            return parent::getResults()->keyBy('id');
        }
        //
        // protected function getRelationValue(array $dictionary, $key, $type){
        //     return parent::getRelationValue($dictionary, $key, $type)->keyBy('id');
        // }
    }
