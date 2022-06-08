<?php

namespace FeatValue\Models;

class Project {

    private string $name;
    private string $token;

    public function __construct(array $properties) {
        foreach($properties as $key => $value){
            if(property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getToken(): string {
        return $this->token;
    }


}