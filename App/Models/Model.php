<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function setAttributesFromGraphQL($graphQLArgs, array $fields): self
    {
        foreach ($fields as $field){
            if (
                isset($graphQLArgs[$field]) &&
                (!empty($graphQLArgs[$field]) || is_bool($graphQLArgs[$field]))
            )
                $this[$field] = $graphQLArgs[$field];
        }
        return $this;
    }
}