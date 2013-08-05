<?php

class DashboardHomeController extends BaseController {

  public function getIndex()
  {
    return View::make('dashboard');
  }

  public function getUserOptions()
  {
    $users_groups   = json_encode(DB::table('users_groups')->lists('group_id', 'user_id'), 256);
    $users          = json_encode(DB::table('users')->lists('email', 'id'), 256);
    $groups         = json_encode(DB::table('groups')->lists('name','id'), 256);
    $centros        = json_encode(DB::table('centros')->lists('abrev','id'), 256);

    $user = Sentry::getUser();
    $isSuperUser = $user->isSuperUser();

    $objUser = User::find($user->id);
    $lang = $objUser->getDefaultLanguage();
    $userId = $objUser->id;

    $groupsPermission = $user->getGroups();
    $arrGroupName= array();
    foreach ($groupsPermission as $group) {
      $arrGroupName[]=$group->name;
    }

    return View::make('users.configuration', compact('users', 'centros', 'groups', 'users_groups', 'isSuperUser', 'arrGroupName', 'lang', 'userId'));
  }

  public function postUserOptions()
  {
    return dd(Input::all());
  }

  public function setJsonedLangByUserId($userid, $lang)
  {
    
    $myUser = User::find($userid);
    $myUser->setDefaultLanguage($lang);
    $myUser->save();
    $respuesta = 'ok';

    return Response::json($respuesta);
  }

  public function getJsonedCentrosById($userid)
  {
    $myUser= User::find($userid);
    $centros= $myUser->getAssignedCentros();
    return Response::json($centros);
  }

  public function setJsonedCentrosById($userid, $idcentros)
  {
    $myUser= User::find($userid);
    $myUser->setAssignedCentros($idcentros);
    $myUser->save();
    return Response::json(true);
  }
}