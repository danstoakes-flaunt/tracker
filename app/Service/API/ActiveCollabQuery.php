<?php

namespace App\Service\API;

class ActiveCollabQuery
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = new ActiveCollabGateway();
    }

    public function getProjects()
    {
        return $this->gateway->fetchProjects();
    }

    public function getProjectTasks($projectId)
    {
        return $this->gateway->fetchProjectTasks($projectId);
    }

    public function getProjectCompletedTasks($projectId)
    {
        return $this->gateway->fetchProjectCompletedTasks($projectId);
    }

    public function getAllTimeRecords($projectId)
    {
        return $this->gateway->fetchAllTimeRecords($projectId);
    }

    public function getAllUsers()
    {
        return $this->gateway->fetchAllUsers();
    }

    public function getAllCompanies()
    {
        return $this->gateway->fetchAllCompanies();
    }
}