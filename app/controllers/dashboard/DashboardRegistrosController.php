<?php

class DashboardRegistrosController extends BaseController {

    protected $registro;

    public function __construct(Registro $registro)
    {
        parent::__construct();
        $this->registro = $registro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {   
    $registros = Registro::where('centro_id', $this->defaultCentroId )->paginate(15);
    return View::make('registros.index', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('registros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $materialField = Input::get('material');
        if ($materialField === '{}') $materialField = '';

        $registro = new registro( array(
          'nombre' => Input::get('nombre'),
          'autore_id' => Input::get('autore_id'),
          'genero_id' => Input::get('genero_id'),
          'arreglista'=> Input::has('arreglista') ? true : false,
          'tipo'      => Input::get('tipo'),
          'fecha'     => Input::get('fecha'),
          'material'  => $materialField,
          'centro_id' => Input::get('centro_id'),
          'fondo'     => Input::get('fondo'),
          'edicion'   => Input::get('edicion'),
          'comentarios' => Input::get('comentarios'),
          'user_id' => Sentry::getUser()->id ));

        if ($registro->save()) {
            return Redirect::route('dashboard.registros.index')
                ->with('success', trans('app.files.created'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($registro->errors)
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
    public function edit($registro)
    {
        return View::make('registros.edit', compact('registro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($registro)
    {
        $materialField = Input::get('material');
        if ($materialField === '{}') $materialField = '';

        $registro->nombre       = Input::get('nombre');
        $registro->autore_id    = Input::get('autore_id');
        $registro->genero_id    = Input::get('genero_id');
        $registro->arreglista   = Input::has('arreglista') ? true : false;
        $registro->tipo         = Input::get('tipo');
        $registro->fecha        = Input::get('fecha');
        $registro->material     =  $materialField;
        $registro->centro_id    = Input::get('centro_id');
        $registro->fondo        = Input::get('fondo');
        $registro->edicion      = Input::get('edicion');
        $registro->comentarios  = Input::get('comentarios');
        $registro->user_id      = Sentry::getUser()->id;

        if ($registro->save()) {
            return Redirect::route('dashboard.registros.index')
                ->with('success', trans('app.files.updated'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($registro->errors)
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
        $registros = Registro::where('nombre', 'like' , '%'.$criteria.'%')->paginate(15);
        return View::make('registros.index', compact('registros'));
    }
}