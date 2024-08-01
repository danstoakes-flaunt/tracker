<?php

namespace App\Service\API;

class ActiveCollabGateway
{
    private $api;

    public function __construct()
    {
        $this->api = new ActiveCollab();
    }

    public function fetchProjects()
    {
        return $this->api->fetch("projects");
    }

    public function fetchProjectTasks($projectId)
    {
        return $this->api->fetch("projects/{$projectId}/tasks");
    }

    public function fetchProjectCompletedTasks($projectId)
    {
        return $this->api->fetch("projects/{$projectId}/tasks/archive");
    }

    public function fetchAllTimeRecords($projectId)
    {
        return $this->api->fetch("projects/{$projectId}/time-records");
    }

    public function fetchAllUsers()
    {
        return $this->api->fetch("users");
    }

    public function fetchAllCompanies()
    {
        return $this->api->fetch("companies");
    }
}