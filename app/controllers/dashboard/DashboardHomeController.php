<?php

class DashboardHomeController extends BaseController {

  public function getIndex()
  {
    return View::make('dashboard');
  }

  public function getUserOptions()
  {
    $users_groups   = json_encode(DB::table('users_groups')->lists('group_id', 'user_id'), JSON_UNESCAPED_UNICODE);
    $users          = json_encode(DB::table('users')->lists('email', 'id'), JSON_UNESCAPED_UNICODE);
    $groups         = json_encode(DB::table('groups')->lists('name','id'), JSON_UNESCAPED_UNICODE);
    $centros        = Centro::all();
    return View::make('users.configuration', compact('users', 'centros', 'groups', 'users_groups'));
  }

  public function postUserOptions()
  {
    return dd(Input::all());
  }
}