<?php

class DashboardAutoresController extends BaseController {


    protected $autore;

    public function __construct(Autore $autore)
    {
        // parent::__construct();
        $this->autore = $autore;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $autores = Autore::paginate(15);
        return View::make('autores.index', compact('autores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('autores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $author = new Autore(
        [ 'nombre'  => Input::get('nombre'),
          'user_id' => Sentry::getUser()->id ]);

        if ($author->save()) {
            return Redirect::route('dashboard.autores.index')
                ->with('success', trans('app.authors.created'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($author->errors)
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
        return "Estoy en el show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($autore)
    {
        return View::make('autores.edit', compact('autore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($autore)
    {
        $autore->nombre = Input::get('nombre');

        if ($autore->save()) {
            return Redirect::route('dashboard.autores.index')
                ->with('success', trans('app.authors.updated'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($autore->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($autore)
    {
        if ($autore->delete()) return Redirect::route('dashboard.autores.index')
            ->with('success', trans('app.authors.deleted', ['name' => $autore->nombre]));

        return Redirect::back()
            ->withErrors($autore->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }

    /**
     * [getSearch description]
     * @param  [type] $criteria [description]
     * @return [type]           [description]
     */
    public function getSearch($criteria) 
    {
        $autores = Autore::where('nombre', 'like' , '%'.$criteria.'%')->paginate(15);
        return View::make('autores.index', compact('autores'));
    }

}