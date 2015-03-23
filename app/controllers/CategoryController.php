<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;
use Services\Validation\Laravel\CategoryValidator as CategoryValidator;

class CategoryController extends \BaseController {

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
        $data = Input::only(['name', 'description']);

        //Validador de la categoría
        $categoryValidator = new CategoryValidator(App::make('validator'));

        //Los campos son válidos
        if ($categoryValidator->with($data)->passes()) {

            $this->category->create($data);

            return Redirect::back()->with('save_success', 'Categoría creada correctamente.');
        }

        return Redirect::back()
                        ->withErrors($categoryValidator->errors(), 'create')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:categories,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }


        $category = $this->category->getById($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de categorías', URL::route('admin.category.index'));
        Breadcrumb::addBreadcrumb($category->name);

        return View::make('admin.pages.edit')
                        ->with([
                            'restful' => 'category',
                            'model' => $category,
                            'header_title' => "Editar categoría (id: {$category->id})"
                        ])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * 
     *
     * @param  int  $platformId
     * @return Response
     */
    public function show($platformId, $categoryId) {

        //Categoría no existente para ese id y plataforma
        if (!$this->category->exists($categoryId, $platformId)) {
            throw new NotFoundHttpException;
        }

        //Se añade el id de la plataforma y de la categoría al input
        Input::replace(array_merge(['platform_id' => $platformId, 'category_id' => $categoryId], Input::all()));

        //Plataforma
        $platform = $this->platform->getById($platformId);

        //Categoría
        $category = $this->category->getById($categoryId);

        //Productos para esa plataforma y categoría
        $products = $this->product->paginateByPlatformAndCategory($platformId, $categoryId, Input::get('sort', 'name'), Input::get('sort_dir', 'asc'));

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb($platform->name, URL::route('platform.show', ['platform_id' => $platformId]));
        Breadcrumb::addBreadcrumb($category->name);

        return View::make('client.pages.category')
                        ->with('platform', $platform)
                        ->with('category', $category)
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:categories,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        //Campos del formulario
        $data = Input::only(['name', 'description']);

        //Validador de la categoría
        $categoryValidator = new CategoryValidator(App::make('validator'), $id);


        //Los campos son válidos
        if ($categoryValidator->with($data)->passes()) {

            $this->category->updateById($id, $data);

            return Redirect::back()->with('save_success', 'Categoría modificada correctamente.');
        }
        
        return Redirect::back()
                        ->withErrors($categoryValidator->errors(), 'update')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:categories,id']);

        //El id no existe
        if ($idValidator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ], 400);
        }

        $this->category->deleteById($id);

        return Response::json(['success' => true], 200);
    }

    public function index() {

        $categories = $this->category->paginateForIndexTable('name', 'asc', 20, Input::get('page'));

        if (Request::ajax()) {
            return Response::json(View::make('admin.includes.index_table')
                                    ->with([
                                        'data' => $categories,
                                        'header' => ['ID', 'Categoría'],
                                        'restful' => 'category'])->render(), 200);
        }

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición');

        return View::make('admin.pages.index')
                        ->with([
                            'data' => $categories,
                            'header' => ['ID', 'Categoría'],
                            'restful' => 'category'])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
