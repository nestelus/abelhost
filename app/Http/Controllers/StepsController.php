<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\Step;
use App\Models\Project;
use Illuminate\Http\Request;

/**
 * Description of StepsController
 *
 * @author vladimir
 */
class StepsController extends Controller {

    /**
     *
     */
    public function index(Project $project) {

        return json_encode(['data' => $this->getSteps($project->id)]);
    }

    public function getStepByProject($projectId) {

        return json_encode(['data' => $this->getSteps($projectId)]);
    }

    public function store(Request $request) {
        $step = Step::create($request->all());
        return json_encode(['data' => $this->getSteps($step->project_id)]);
    }

    public function update(Request $request) {

        if ($request->has('id')) {
            $step = Step::find($request->input('id'));
            $step->update($request->all());
            return json_encode(['data' => $this->getSteps($step->project_id)]);
        }
    }

    public function destroy(Request $request) {
        if ($request->has('id')) {
            $step = Step::find($request->input('id'));
            $project_id = $step->project_id;
            $step->delete();
            return json_encode(['data' => $this->getSteps($project_id)]);
        }
        
    }

    protected function getSteps($projectId) {

        return Step::with('assigned')->where(['project_id' => $projectId])->orderBy('date_end')->get();
    }

}
