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
        $data = Input::only(['name', 'icon_path', 'description']);

        //Reglas de validación
        $rules = [
            'name' => 'required|unique:platforms',
            'icon_path' => 'mimes:svg',
            'description' => 'string',
        ];



        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($data);
        }

        //Icono
        $icon = Input::file('icon_path');

        if ($icon !== null) {
            $iconDirectory = Config::get('constants.PLATFORM_ICON_DIR') . '/';
            $iconFileName = "{$data['name']}.{$icon->getClientOriginalExtension()}";
            $data['icon_path'] = $iconDirectory . $iconFileName;
        }

        $icon === null ? : $icon->move($iconDirectory, $iconFileName);

        $this->platform->create($data);

        return Redirect::back()->with('save_success', 'Plataforma creada correctamente.');
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

        $platform = $this->platform->getById($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de plataformas', URL::route('admin.platform.index'));
        Breadcrumb::addBreadcrumb($platform->name);

        return View::make('admin.pages.edit')
                        ->with([
                           'restful' => 'platform',
                           'model' => $platform,
                           'header_title' => "Editar plataforma (id: {$platform->id})"])
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
        $platform = $this->platform->getById($id);

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
        $data = Input::only(['name', 'icon_path', 'description']);

        //Reglas de validación
        $rules = [
            'name' => "required|unique:platforms,name,$id",
            'icon_path' => 'mimes:svg',
            'description' => 'string',
        ];


        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {

            return Redirect::back()
                            ->withErrors($validator, 'update')
                            ->withInput($data);
        }

        //Icono
        $icon = Input::file('icon_path');

        if ($icon !== null) {
            $iconDirectory = Config::get('constants.PLATFORM_ICON_DIR') . '/';
            $iconFileName = "{$data['name']}.{$icon->getClientOriginalExtension()}";
            $data['icon_path'] = $iconDirectory . $iconFileName;
        } else {
            $data['icon_path'] = $this->platform->getById($id)->icon_path;
        }

        $icon === null ? : $icon->move($iconDirectory, $iconFileName);

        $this->platform->updateById($id, $data);

        return Redirect::back()->with('save_success', 'Plataforma modificada correctamente.');
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
            return Response::json([
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ], 400); 
        }

        //Ruta de la imagen para borrarla
        $icon_path = $this->platform->getById($id)->icon_path;

        $this->platform->deleteById($id);

        //Se borra el icono de la plataforma
        File::delete($icon_path);

        return Response::json(['success' => true], 200);
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
