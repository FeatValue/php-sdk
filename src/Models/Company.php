<?php

namespace FeatValue\Models;

use DateTime;

class Company {

    private string $name;
    private int $owner_company_id;
    private string $token;
    private ?array $projects = null;

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
     * @return int
     */
    public function getOwnerCompanyId(): int {
        return $this->owner_company_id;
    }

    /**
     * @return string
     */
    public function getToken(): string {
        return $this->token;
    }

    /**
     * @return array
     */
    public function getProjects(): array {
        return $this->projects ?: array();
    }

}