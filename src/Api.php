<?php

namespace FeatValue;

use DateTime;
use Exception;
use FeatValue\Models\Company;
use FeatValue\Models\Project;
use FeatValue\Models\Task;
use FeatValue\Models\TimeEntry;

class Api {

    private string $publicKey;
    private string $token;
    private string $host;

    /**
     * API constructor
     *
     * @param string $publicKey
     * @param string $token
     * @param string $host
     */
    public function __construct(string $publicKey, string $token, string $host = "https://app.featvalue.io/api") {
        $this->publicKey = $publicKey;
        $this->token = $token;
        $this->setHost($host);
    }

    /**
     * Creates a GET request to path
     *
     * @param string $path
     * @param array|null $data
     * @return string|array
     */
    public function get(string $path, array $data = null) {
        if (empty($data))
            return $this->sendRequest("/data" . $path);
        return $this->sendRequest("/data" . $path, "GET", $data);
    }

    /**
     * Creates a POST request to path
     *
     * @param string $path
     * @param array $data
     * @return string|array
     */
    public function post(string $path, array $data) {
        return $this->sendRequest($path, 'POST', $data);
    }

    /**
     * Creates a PATCH request to path
     *
     * @param string $path
     * @param array $data
     * @return string|array
     */
    public function patch(string $path, array $data) {
        return $this->sendRequest($path, 'PATCH', $data);
    }

    /**
     * Creates a DELETE request to path
     *
     * @param string $path
     * @return string|array
     */
    public function delete(string $path) {
        return $this->sendRequest($path, 'DELETE');
    }

    /**
     * Returns the company object
     *
     * @return string|array
     */
    public function me() {
        return $this->get('/me');
    }

    /**
     * HTTP request helper
     *
     * @param $path
     * @param string|null $method HTTP method, e.g. 'POST'
     * @param array|null $data data for request body
     * @return string|array
     */
    private function sendRequest($path, string $method = null, array $data = null) {
        $url = $this->getHost() . $path . "?app_key=" . urlencode($this->publicKey) . "&token=" . urlencode($this->token);

        if (!empty($data) && $method === "GET") {
            foreach ($data as $key => $value) {
                $url .= "&" . $key . "=" . $value;
            }
        }
        $handler = curl_init($url);

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);

        if (!empty($method))
            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, $method);

        if (!empty($data) && $method !== "GET")
            curl_setopt($handler, CURLOPT_POSTFIELDS, http_build_query($data));

        $result = curl_exec($handler);
        $result = json_decode($result, true);

        curl_close($handler);
        return $result;
    }

    /**
     * Returns all tasks
     *
     * @param array|null $data
     * @return array
     */
    public function tasks(array $data = null): array {
        $tasks = $this->get('/tasks', $data);
        $result = [];

        if (!empty($tasks)) {
            foreach ($tasks['tasks'] as $task) {
                try {
                    $task['publishedAt'] = new DateTime($task['published_at']);
                    $task['estimatedReadyAt'] = new DateTime($task['estimated_ready_at']);
                    $task['deletedAt'] = new DateTime($task['deleted_at']);
                } catch (Exception $e) {
                }
                $result[] = new Task($task);
            }
        }

        return $result;
    }

    /**
     * Returns all time entries
     *
     * @return array
     */
    public function timeEntries(): array {
        $timeEntries = $this->get('/time-entries');
        $result = [];

        if (!empty($timeEntries)) {
            foreach ($timeEntries['data'] as $timeEntry) {
                try {
                    $timeEntry['timeFrom'] = new DateTime($timeEntry['time_from']);
                    $timeEntry['timeTo'] = new DateTime($timeEntry['time_to']);
                    $timeEntry['projectId'] = $timeEntry['project']['id'];
                    $timeEntry['taskId'] = $timeEntry['task']['id'];
                } catch (Exception $e) {
                }
                $result[] = new TimeEntry($timeEntry);
            }
        }

        return $result;
    }

    /**
     * Returns all projects
     *
     * @return array
     */
    public function projects(): array {
        $projects = $this->get('/projects');
        $result = [];

        if(!empty($projects)) {
            foreach ($projects['projects'] as $project) {
                $result[] = new Project($project);
            }
        }

        return $result;
    }

    /**
     * Returns all clients
     *
     * @return array
     */
    public function clients(): array {
        $clients = $this->get('/clients');
        $result = [];

        if (!empty($clients)) {
            foreach ($clients['data'] as $client) {
                $result[] = new Company($client);
            }
        }

        return $result;
    }

    /**
     * Returns the host for API requests (default is https://app.featvalue.io/api)
     *
     * @return string
     */
    public function getHost(): string {
        return $this->host;
    }

    /**
     * Define the host for API requests
     *
     * @param string $host
     */
    public function setHost(string $host): void {
        $this->host = $host;
    }

}
