<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Step;
use Illuminate\Http\Request;

/**
 * Description of TasksController
 *
 * @author vladimir
 */
class TasksController extends Controller {

    /**
     *
     */

    public function getTaskByStep(int $stepId) {
        return json_encode(['data' => $this->getTasks($stepId)]);
    }

    public function store(Request $request) {
        $task = Task::create($request->all());
        return json_encode(['data' => $this->getTasks($task->step_id)]);
    }

    public function update(Request $request) {

        if ($request->has('id')) {
            $task = Task::find($request->input('id'));
            $task->update($request->all());
            return json_encode(['data' => $this->getTasks($task->step_id)]);
        }
    }

    public function destroy(Request $request) {
        if ($request->has('id')) {
            $task = Task::find($request->input('id'));
            $step_id = $task->step_id;
            $task->delete();
            return json_encode(['data' => $this->getTasks($step_id)]);
        }
    }

    protected function getTasks($stepId) {

        return Task::with('assigned')->where(['step_id' => $stepId])->orderBy('date_end')->get();
    }

}
