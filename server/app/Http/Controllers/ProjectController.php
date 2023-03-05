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

    public function edit(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => ['required', 'exists:App\Models\Project,id'],
            'title' => ['string', 'unique:App\Models\Project,title', 'required_without:description'],
            'description' => ['string', 'required_without:title']
        ]);

        if ($validate->fails()) {
            return $this->FailedResponse(100, $validate->errors());
        }

        $project = Project::find($request->id);

        if ($request->title)
            $project->title = $request->title;

        if ($request->description)
            $project->description = $request->description;

        $project = $project->save();

        return $this->SuccessResponse([
            'updated' => true,
            'project' => $project,
        ]);
    }

    public function delete(Request $request)
    {
        $deleted = Project::where('id', $request->id)->delete();

        return $this->SuccessResponse([
            'deleted' => (bool)$deleted
        ]);
    }

    public function show($id)
    {
        $project = Project::where('id', $id)->first();

        return $this->SuccessResponse([
            'project' => $project,
        ]);
    }
}
