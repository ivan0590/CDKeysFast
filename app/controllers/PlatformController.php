<?php

use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;

class PlatformController extends \BaseController {

    public function __construct(PlatformRepositoryInterface $platform, CategoryRepositoryInterface $category, ProductRepositoryInterface $product) {
        $this->platform = $platform;
        $this->category = $category;
        $this->product = $product;
    }

    /**
     * 
     *
     * @return Response
     */
    public function store() {
        //Campos del formulario
        $fields = Input::only(['name', 'icon_path', 'description']);

        //Reglas de validación
        $rules = [
            'name' => 'required|unique:platforms',
            'icon_path' => 'mimes:jpeg,jpg,png,bmp,gif,svg',
            'description' => 'string',
        ];



        //Validación de los campos del formulario
        $validator = Validator::make($fields, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($fields);
        }

        //Icono
        $icon = Input::file('icon_path');

        if ($icon !== null) {
            $iconDirectory = Config::get('constants.PLATFORM_ICON_DIR') . '/';
            $iconFileName = "{$fields['name']}.{$icon->getClientOriginalExtension()}";
            $fields['icon_path'] = $iconDirectory . $iconFileName;
        }

        $icon === null ? : $icon->move($iconDirectory, $iconFileName);

        //Éxito al guardar
        if ($this->platform->create($fields)) {

            return Redirect::back()->with('save_success', 'Plataforma creada correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar crear la plataforma.'], 'create')
                        ->withInput(Input::only(['name', 'description']));
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:platforms']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
        }

        $platform = $this->platform->find($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de plataformas', URL::route('admin.platform.index'));
        Breadcrumb::addBreadcrumb($platform->name);

        return View::make('admin.pages.edit')
                        ->with('restful', 'platform')
                        ->with('model', $platform)
                        ->with('header_title', "Editar plataforma (id: {$platform->id})")
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        //Plataforma no existente para ese id
        if (!$this->platform->exists($id)) {
            return Redirect::route('index');
        }

        //Se añade el id de la plataforma al input
        Input::replace(array_merge(['platform_id' => $id], Input::all()));

        //Plataforma
        $platform = $this->platform->find($id);

        //Categorías
        $categories = $this->category->getByPlatformWhereHasProducts($platform->id);

        //Productos destacados de la plataforma
        $products = $this->product->paginateHighlighted($platform->id, Auth::check(), Input::get('sort', 'name'), Input::get('sort_dir', 'asc'));

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb($platform->name);

        return View::make('client.pages.platform')
                        ->with('platform', $platform)
                        ->with('categories', $categories)
                        ->with('products', $products)
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        //Campos del formulario
        $fields = Input::only(['name', 'icon_path', 'description']);

        //Reglas de validación
        $rules = [
            'name' => "required|unique:platforms,name,$id",
            'icon_path' => 'mimes:jpeg,jpg,png,bmp,gif,svg',
            'description' => 'string',
        ];


        //Validación de los campos del formulario
        $validator = Validator::make($fields, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {

            return Redirect::back()
                            ->withErrors($validator, 'update')
                            ->withInput($fields);
        }

        //Icono
        $icon = Input::file('icon_path');

        if ($icon !== null) {
            $iconDirectory = Config::get('constants.PLATFORM_ICON_DIR') . '/';
            $iconFileName = "{$fields['name']}.{$icon->getClientOriginalExtension()}";
            $fields['icon_path'] = $iconDirectory . $iconFileName;
        } else {
            $fields['icon_path'] = $this->platform->find($id)->icon_path;
        }

        $icon === null ? : $icon->move($iconDirectory, $iconFileName);

        //Éxito al guardar
        if ($this->platform->update($id, $fields)) {

            return Redirect::back()->with('save_success', 'Plataforma modificada correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar modificar la plataforma.'], 'update')
                        ->withInput(Input::only(['name', 'description']));
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        $validator = Validator::make(['id' => $id], ['id' => 'exists:platforms']);

        //El id no existe
        if ($validator->fails()) {
            return Response::json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ), 400); // 400 being the HTTP code for an invalid request.
        }

        //Ruta de la imagen para borrarla
        $icon_path = $this->platform->find($id)->icon_path;

        //Éxito al eliminar
        if ($this->platform->erase($id)) {
            File::delete($icon_path);

            return Response::json(array('success' => true), 200);
        }

        //Error de SQL
        return Response::json(array(
                    'success' => false,
                    'errors' => ['error' => 'Error al intentar borrar la plataforma.']
                        ), 400);

//        //El id no existe
//        if ($validator->fails()) {
//            return Redirect::back();
//        }
//
//        //Ruta de la imagen para borrarla
//        $icon_path = $this->platform->find($id)->icon_path;
//        
//        //Éxito al eliminar
//        if ($this->platform->erase($id)) {
//            
//            File::delete($icon_path);
//            
//            return Redirect::back();
//        }
//
//        //Error de SQL
//        return Redirect::back()
//                        ->withErrors(['error' => 'Error al intentar borrar la plataforma.'], 'erase');
    }

    public function index() {

        $platforms = $this->platform->paginateForIndexTable('name', 'asc', 20, Input::get('page'));

        if (Request::ajax()) {
            return Response::json(View::make('admin.includes.index_table')
                                    ->with([
                                        'data' => $platforms,
                                        'header' => ['ID', 'Plataforma'],
                                        'restful' => 'platform'])->render(), 200);
        }

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición');

        return View::make('admin.pages.index')
                        ->with([
                            'data' => $platforms,
                            'header' => ['ID', 'Plataforma'],
                            'restful' => 'platform'])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
