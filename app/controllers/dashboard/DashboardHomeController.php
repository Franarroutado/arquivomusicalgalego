<?php

class DashboardHomeController extends BaseController {

  public function getIndex()
  {
    return View::make('dashboard');
  }

  public function getUserOptions()
  {
    //dd(JSON_UNESCAPED_UNICODE);
    $users_groups   = json_encode(DB::table('users_groups')->lists('group_id', 'user_id'), 256);
    $users          = json_encode(DB::table('users')->lists('email', 'id'), 256);
    $groups         = json_encode(DB::table('groups')->lists('name','id'), 256);
    $centros        = Centro::all();

    $user = Sentry::getUser();
    $isSuperUser = $user->isSuperUser();

    $groupsPermission = $user->getGroups();
    $arrGroupName= array();
    foreach ($groupsPermission as $group) {
      $arrGroupName[]=$group->name;
    }

    return View::make('users.configuration', compact('users', 'centros', 'groups', 'users_groups', 'isSuperUser', 'arrGroupName'));
  }

  public function postUserOptions()
  {
    return dd(Input::all());
  }
}