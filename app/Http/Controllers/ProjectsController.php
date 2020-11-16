<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * Description of ProjectsController
 *
 * @author vladimir
 */
class ProjectsController extends Controller {
    /*
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     *
     * @return type
     */
    public function index() {

        return view('projects.projects', [
            'projects' => $this->getMyProjects(),
        ]);
    }

    /**
     *
     * @param Request $request
     * @return type
     */
    public function store(Request $request) {
        $project = $request->all();
        $user_id = Auth::user()->id;
        $project['creator_id'] = $user_id;
        Project::create($project);

        return json_encode(['data' => $this->getMyProjects()]);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function update(Request $request) {
        if ($request->has('id')) {
            Project::find($request->input('id'))->update($request->all());
        }
        return json_encode(['data' => $this->getMyProjects()]);
    }

    /**
     *
     * @param Request $request
     * @return type
     */
    public function destroy(Request $request) {
        if ($request->has('id')) {
            Project::find($request->input('id'))->delete();
        }
        return json_encode(['data' => $this->getMyProjects()]);
    }

    /**
     *
     * @return type
     */
    protected function getMyProjects() {
        $user_id = Auth::user()->id;
        return Project::query()->where('creator_id', '=', $user_id)->orderBy('date_end', 'DESC')->get();
    }

}
