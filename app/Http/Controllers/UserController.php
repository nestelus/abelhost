<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\User;

/**
 * Description of UserController
 *
 * @author vladimir
 */
class UserController extends Controller {

    public function getUsers() {
        $users = User::query()->select(['id', 'name'])->orderBy('name')->get();
        return json_encode(['users' => $users]);
    }

}
