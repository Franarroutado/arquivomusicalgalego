<?php

class DashboardHomeController extends BaseController {

  public function getIndex()
  {
    return View::make('dashboard');
  }
}