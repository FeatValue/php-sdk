<?php

namespace FeatValue\Models;

use DateTime;
use FeatValue\Api;

class TimeEntry {

    private int $id;
    private int $projectId;
    private DateTime $timeFrom;
    private DateTime $timeTo;
    private string $description;
    private int $taskId;

    public function __construct(array $properties) {
        foreach($properties as $key => $value){
            if(property_exists($this, $key))
                $this->{$key} = $value;
        }
    }
    /**
     * @return int
     */
    public function getProjectId(): int {
        return $this->projectId;
    }

    /**
     * @return DateTime
     */
    public function getTimeFrom(): DateTime {
        return $this->timeFrom;
    }

    /**
     * @return DateTime
     */
    public function getTimeTo(): DateTime {
        return $this->timeTo;
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
    public function getTaskId(): int {
        return $this->taskId;
    }

    /**
     * @param Api $api
     * @param array $data
     * @return array|string
     */
    public function addAppFields(Api $api, array $data): array|string {
        return $api->patch('/data/time-entries/' . $this->id . '/fields', ['fields' => $data]);
    }

}