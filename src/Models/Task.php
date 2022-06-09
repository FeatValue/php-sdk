<?php

namespace FeatValue\Models;

use DateTime;
use FeatValue\Api;

class Task {

    private int $id;
    private string $name;
    private string $description;
    private int $projectId;
    private string $status;
    private int $creatorCompanyId;
    private DateTime $publishedAt;
    private DateTime $estimatedReadyAt;
    private DateTime $deletedAt;
    private string $priority;
    private string $token;

    public function __construct(array $properties) {
        foreach($properties as $key => $value){
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
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getProjectId(): int {
        return $this->projectId;
    }

    /**
     * @return string
     */
    public function getStatus(): string {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getCreatorCompanyId(): int {
        return $this->creatorCompanyId;
    }

    /**
     * @return DateTime
     */
    public function getPublishedAt(): DateTime {
        return $this->publishedAt;
    }

    /**
     * @return DateTime
     */
    public function getEstimatedReadyAt(): DateTime {
        return $this->estimatedReadyAt;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt(): DateTime {
        return $this->deletedAt;
    }

    /**
     * @return string
     */
    public function getPriority(): string {
        return $this->priority;
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
        return $api->patch('/data/tasks/' . $this->id . '/fields', ['fields' => $data]);
    }


}