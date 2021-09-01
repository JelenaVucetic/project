<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProjectResource;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $this->authorize('project_access');
        $projects = Project::all();

        return $this->sendResponse(ProjectResource::collection($projects), 'Projects retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        $input = $request->all();

        $project = Project::create($input);

        return $this->sendResponse(new ProjectResource($project), 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(Project $project)
    {
        if (is_null($project)) {
            return $this->sendError('Project not found.');
        }

        return $this->sendResponse(new ProjectResource($project), 'Project retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $input = $request->all();

        $project->title = $input['title'];
        $project->description = $input['description'];
        $project->save();

        return $this->sendResponse(new ProjectResource($project), 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return $this->sendResponse([], 'Project deleted successfully.');
    }
}
