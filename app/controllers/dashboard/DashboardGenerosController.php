<?php

class DashboardGenerosController extends BaseController {

    protected $genero;

    public function __construct(Genero $genero)
    {
        // parent::__construct();
        $this->genero = $genero;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $generos = Genero::paginate(15);
        return View::make('generos.index', compact('generos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('generos.create');
    }

    /**
     * Store a newly created genre in storage.
     *
     * @return Response
     */
    public function store()
    {
        $langField = Input::get('lang');
        if ($langField === '{}') $langField = '';

        $genre = new Genero( array( 
          'lang'  => $langField,
          'user_id' => Sentry::getUser()->id ));

        if ($genre->save()) {
            return Redirect::route('dashboard.generos.index')
                ->with('success', trans('app.genres.created'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($genre->errors)
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
    public function edit($genero)
    {
        return View::make('generos.edit', compact('genero'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($genero)
    {
        $langField = Input::get('lang');
        if ($langField === '{}') $langField = '';

        $genero->lang = $langField;

        if ($genero->save()) {
            return Redirect::route('dashboard.generos.index')
                ->with('success', trans('app.genres.updated'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($genero->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($genero)
    {
        if ($genero->delete()) return Redirect::route('dashboard.generos.index')
            ->with('success', trans('app.genres.deleted', array('name' => $genero->nombre)));

        return Redirect::back()
            ->withErrors($genero->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }
 
    /**
     * [getSearch description]
     * @param  [type] $criteria [description]
     * @return [type]           [description]
     */
    public function getSearch($criteria) 
    {
        $generos = Genero::where('lang', 'like' , '%'.$criteria.'%')->paginate(15);
        return View::make('generos.index', compact('generos'));
    }

    public function getJasoned()
    {
        $colGeneros = Genero::all();
        $respuesta;
        foreach ($colGeneros as $genero) {
            $respuesta[$genero->id] = AMG::getLangJSON($genero->lang);
        }   
        return Response::json($respuesta);
    }

}