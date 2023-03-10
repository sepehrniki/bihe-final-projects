<?php

namespace App\Http\Controllers;

use App\Http\Traits\Api;
use App\Models\Task;
use App\Models\TaskLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use Api;

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'project_id' => ['required', 'int', 'exists:App\Models\Project,id'],
            'title' => ['required', 'string', 'unique:App\Models\Task,title'],
            'description' => ['required', 'string']
        ]);

        if ($validate->fails()) {
            return $this->FailedResponse(100, $validate->errors());
        }

        $task = Task::create([
            'project_id' => $request->project_id,
            'created_by' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return $this->SuccessResponse([
            'created' => true,
            'task' => $task,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => ['string', 'unique:App\Models\Task,title'],
            'description' => ['string'],
            'status' => ['in:ToDo,Blocked,InProgress,InQA,Done,Deployed'],
        ]);

        if ($validate->fails()) {
            return $this->FailedResponse(100, $validate->errors());
        }

        $task = Task::find($id);

        if (!$task) {
            return $this->FailedResponse(103);
        }

        if ($request->title)
            $task->title = $request->title;

        if ($request->description)
            $task->description = $request->description;

        if ($request->status) {
            $old_status = $task->status;
            $new_status = $request->status;

            if ($this->checkStatusAllowed($task->status, $request->status)) {
                $task->status = $request->status;
            }
            else {
                return $this->FailedResponse(502, $validate->errors());
            }

            $log = [
                'task_id' => $task->id,
                'changed_by' => auth()->user()->id,
                'old_status' => $old_status,
                'new_status' => $new_status,
            ];
        }

        $update_task = $task->save();

        if ($update_task && isset($log)) {
            TaskLog::create($log);
        }

        return $this->SuccessResponse([
            'updated' => (bool)$update_task
        ]);
    }

    private function checkStatusAllowed($old, $new): bool
    {
        $statuses = [
            'ToDo' => ['InProgress'],
            'InProgress' => ['Blocked', 'InQA'],
            'Blocked' => ['ToDo'],
            'InQA' => ['ToDo', 'Done'],
            'Done' => ['ToDo', 'Deployed'],
        ];

        return array_key_exists($old, $statuses) && in_array($new, $statuses[$old]);
    }

    public function delete(Request $request)
    {
        if ($request->user()->tokenCan('type-admin')) {
            $deleted = Task::where('id', $request->id)->delete();

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
        $task = Task::where('id', $id)->first();

        if ($task) {
            return $this->SuccessResponse([
                'task' => $task,
            ]);
        }
        else {
            return $this->FailedResponse(103);
        }
    }

    public function list($project_id)
    {
        $count = Task::where('project_id', $project_id)->count();

        if ($count == 0) {
            return $this->FailedResponse(103);
        }

        $task = Task::where('project_id', $project_id)->simplePaginate(20);

        return $this->SuccessResponse([
            'count' => Task::where('project_id', $project_id)->count(),
            'projects' => $task,
        ]);
    }

    public function logs($id)
    {
        $task = Task::where('id', $id)->first();
        $task_logs = TaskLog::where('task_id', $id)->get();

        if ($task && $task_logs) {
            return $this->SuccessResponse([
                'task' => $task,
                'logs' => $task_logs,
            ]);
        }
        else {
            return $this->FailedResponse(103);
        }
    }
}
