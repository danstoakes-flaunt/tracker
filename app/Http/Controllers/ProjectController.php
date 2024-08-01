<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Service\API\ActiveCollabQuery;
use App\Traits\SlugGenerationTrait;
use DateTime;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $activeCollabQuery;

    public function __construct()
    {
        $this->activeCollabQuery = new ActiveCollabQuery;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allProjects = Project::all();
        $usedRetainerTimeByProject = [];

        $currentDate = new DateTime();
        $currentYear = $currentDate->format("Y");
        $currentMonth = $currentDate->format("m");

        foreach ($allProjects as $project) {
            $activeCollabId = $project->active_collab_id;
            $timeRecords = $this->activeCollabQuery->getAllTimeRecords($activeCollabId);
            $monthlyTimeRecords = array_filter($timeRecords["time_records"], function($timeRecord) use ($currentYear, $currentMonth) {
                $date = new DateTime();
                $date->setTimestamp($timeRecord["record_date"]);
                $year = $date->format("Y");
                $month = $date->format("m");

                $taskThisMonth = $year == $currentYear && $month == $currentMonth;

                return !$timeRecord["is_trashed"] && $timeRecord["billable_status"] == 1 && $taskThisMonth;
            });

            $projectTimeTotal = 0;
            foreach ($monthlyTimeRecords as $timeRecord) {
                $projectTimeTotal += $timeRecord["value"];
            }

            $usedRetainerTimeByProject[$project->id] = $projectTimeTotal;
        }

        return view("project.index")->with([
            "projects" => $allProjects,
            "time" => $usedRetainerTimeByProject
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activeCollabProjects = $this->activeCollabQuery->getProjects();
        
        $filteredProjects = [];
        foreach($activeCollabProjects as $project) {
            array_push($filteredProjects, [
                "id" => $project["id"],
                "name" => $project["name"]
            ]);
        }

        return view("project.create")->with([
            "projects" => $filteredProjects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project;
        $project->name = $request->name;
        $project->active_collab_id = $request->project;
        $project->monthly_hours = $request->hours;
        $project->slug = SlugGenerationTrait::slugify($project, "name");
        $project->save();
    
        return redirect()->route("projects.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  String  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $project = Project::where("slug", $slug)->first();

        return view("project.show")->with([
            "project" => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  String  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $project = Project::where("slug", $slug)->first();

        return view("project.edit")->with([
            "project" => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        return back();
    }
}
