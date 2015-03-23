<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;
use Services\Validation\Laravel\PlatformValidator as PlatformValidator;

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

        //Validador de la plataforma
        $platformValidator = new PlatformValidator(App::make('validator'));

        //Los campos son válidos
        if ($platformValidator->with($data)->passes()) {

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

        //Errores de validación
        return Redirect::back()
                        ->withErrors($platformValidator->errors(), 'create')
                        ->withInput($data);
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        //Validador del id
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:platforms,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        //Plataforma
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

        //Validador del id
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:platforms,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
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

        //Validador del id
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:platforms,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        //Campos del formulario
        $data = Input::only(['name', 'icon_path', 'description']);

        //Validador de la plataforma
        $platformValidator = new PlatformValidator(App::make('validator'), $id);

        //Los campos no son válidos
        if ($platformValidator->with($data)->passes()) {

            //Icono
            $icon = Input::file('icon_path');

            //Hay un nuevo icono
            if ($icon !== null) {
                $iconDirectory = Config::get('constants.PLATFORM_ICON_DIR') . '/';
                $iconFileName = "{$data['name']}.{$icon->getClientOriginalExtension()}";
                $data['icon_path'] = $iconDirectory . $iconFileName;
            //El icono sigue siendo el mismo
            } else {
                $data['icon_path'] = $this->platform->getById($id)->icon_path;
            }

            //Si hay un nuevo icono se procede a reemplazarlo por el anterior
            $icon === null ? : $icon->move($iconDirectory, $iconFileName);

            $this->platform->updateById($id, $data);

            return Redirect::back()->with('save_success', 'Plataforma modificada correctamente.');
        }

        return Redirect::back()
                        ->withErrors($platformValidator->errors(), 'update')
                        ->withInput($data);
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        //Validador del id
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:platforms']);

        //El id no existe
        if ($idValidator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $idValidator->getMessageBag()->toArray()
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

        //Datos de la tabla de edición
        $platforms = $this->platform->paginateForIndexTable('name', 'asc', 20, Input::get('page'));

        //Actualización de la tabla mediante ajax
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
