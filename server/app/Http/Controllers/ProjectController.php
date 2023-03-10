<?php

namespace App\Http\Controllers;

use App\Http\Traits\Api;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    use Api;

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => ['required', 'string', 'unique:App\Models\Project,title'],
            'description' => ['required', 'string']
        ]);

        if ($validate->fails()) {
            return $this->FailedResponse(100, $validate->errors());
        }

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
        ]);

        return $this->SuccessResponse([
            'created' => true,
            'project' => $project,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => ['string', 'unique:App\Models\Project,title', 'required_without:description'],
            'description' => ['string', 'required_without:title']
        ]);

        if ($validate->fails()) {
            return $this->FailedResponse(100, $validate->errors());
        }

        $project = Project::find($id);

        if (!$project) {
            return $this->FailedResponse(103);
        }

        if ($request->title)
            $project->title = $request->title;

        if ($request->description)
            $project->description = $request->description;

        $updated = $project->save();

        return $this->SuccessResponse([
            'updated' => $updated,
            'project' => $project,
        ]);
    }

    public function delete(Request $request)
    {
        if ($request->user()->tokenCan('type-admin')) {
            $deleted = Project::where('id', $request->id)->delete();

            return $this->SuccessResponse([
                'deleted' => (bool)$deleted
            ]);
        }
        else {
            return $this->FailedResponse(500);
        }
    }

    public function show($id)
    {
        $project = Project::where('id', $id)->first();

        if ($project) {
            return $this->SuccessResponse([
                'project' => $project,
            ]);
        }
        else {
            return $this->FailedResponse(103);
        }
    }

    public function list()
    {
        $projects = Project::simplePaginate(20);

        return $this->SuccessResponse([
            'count' => Project::count(),
            'projects' => $projects,
        ]);
    }
}
