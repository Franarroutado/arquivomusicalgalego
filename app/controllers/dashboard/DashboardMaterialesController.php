<?php

class DashboardMaterialesController extends BaseController {

    protected $material;

    public function __construct(Material $material)
    {
        parent::__construct();
        $this->material = $material;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $materiales = Material::paginate(15);
        return View::make('materiales.index', compact('materiales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('materiales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $langField = Input::get('lang');
        if ($langField === '{}') $langField = '';

        $material = new Material( array(
          'abrev' => Input::get('abrev'),
          'lang'  => $langField,
          'user_id' => Sentry::getUser()->id ));

        if ($material->save()) {
            return Redirect::route('dashboard.materiales.index')
                ->with('success', trans('app.materials.created'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($material->errors)
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
    public function edit($material)
    {
        return View::make('materiales.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($material)
    {
        $langField = Input::get('lang');
        if ($langField === '{}') $langField = '';

        $material->lang = $langField;
        $material->abrev = Input::get('abrev');

        if ($material->save()) {
            return Redirect::route('dashboard.materiales.index')
                ->with('success', trans('app.materials.updated'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($material->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($material)
    {
        if ($material->delete()) return Redirect::route('dashboard.materiales.index')
            ->with('success', trans('app.materials.deleted', array('name' => $material->nombre)));

        return Redirect::back()
            ->withErrors($material->errors)
            ->with('error', trans(AMG::displayRandomErrorValidation()));
    }

     /**
     * [getSearch description]
     * @param  [type] $criteria [description]
     * @return [type]           [description]
     */
    public function getSearch($criteria) 
    {
        //$materiales = Material::whereRaw("lang like '%?%'", [$criteria])
        $materiales = Material::where('lang','like', '%'.$criteria.'%')
            ->paginate(15);
        return View::make('materiales.index', compact('materiales'));
    }

    public function getJasoned()
    {
        $colMateriales = Material::all();
        $respuesta;
        foreach ($colMateriales as $material) {
            $respuesta[$material->abrev] = AMG::getLangJSON($material->lang);
        }   
        return Response::json($respuesta);
    }
}