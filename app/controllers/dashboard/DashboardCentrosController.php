<?php

class DashboardCentrosController extends BaseController {

    protected $centro;

    public function __construct(Centro $centro)
    {
        // parent::__construct();
        $this->centro = $centro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $centros = Centro::paginate(15);
        return View::make('centros.index', compact('centros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('centros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $contactField = Input::get('contacto');
        if ($contactField === '{}') $contactField = '';

        $centro = new Centro(
        [ 'nombre'  => Input::get('nombre'),
          'abrev'   => Input::get('abrev'),
          'cuerpo'  => Input::get('cuerpo'),
          'contacto'=> $contactField,
          'user_id' => Sentry::getUser()->id ]);

        if ($centro->save()) {
            return Redirect::route('dashboard.centros.index')
                ->with('success', trans('app.schools.created'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($centro->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($centro)
    {
        return View::make('centros.edit', compact('centro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($centro)
    {
        $contactField = Input::get('contacto');
        if ($contactField === '{}') $contactField = '';

        if ($centro->contacto != $contactField) $centro->contacto = $contactField;
        if ($centro->abrev != Input::get('abrev')) $centro->abrev = Input::get('abrev');
        if ($centro->nombre != Input::get('nombre')) $centro->nombre = Input::get('nombre');
        if ($centro->cuerpo != Input::get('cuerpo')) $centro->cuerpo = Input::get('cuerpo');

        if ($centro->save()) {
            return Redirect::route('dashboard.centros.index')
                ->with('success', trans('app.schools.updated'));
        }
        
        return Redirect::back()
            ->withInput()
            ->withErrors($centro->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * [getSearch description]
     * @param  [type] $criteria [description]
     * @return [type]           [description]
     */
    public function getSearch($criteria) 
    {
        $centros = Centro::where('nombre', 'like' , '%'.$criteria.'%')->paginate(15);
        return View::make('centros.index', compact('centros'));
    }
}