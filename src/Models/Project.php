<?php

namespace FeatValue\Models;

use FeatValue\Api;

class Project {

    private int $id;
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

    /**
     * @param Api $api
     * @param array $data
     * @return array|string
     */
    public function addAppFields(Api $api, array $data): array|string {
        return $api->patch('/data/projects/' . $this->id . '/fields', ['fields' => $data]);
    }


}