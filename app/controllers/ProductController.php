<?php

use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;

class ProductController extends \BaseController {

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

        //Cuando el checkbox del producto destacado está desmarcado su valor es null y se necesita un false
        Input::get('highlighted') !== null ? : Input::merge(['highlighted' => false]);

        //Campos del formulario
        $fields = Input::only([
                    'game_id', 'platform_id', 'publisher_id', 'price', 'discount',
                    'stock', 'launch_date', 'highlighted', 'singleplayer', 'multiplayer',
                    'cooperative',
        ]);

        //Reglas de validación
        $rules = [
            'game_id' => 'exists:games,id|unique_with:products,platform_id',
            'platform_id' => 'exists:platforms,id',
            'publisher_id' => 'exists:publishers,id',
            'price' => 'numeric|min:1',
            'discount' => 'numeric|min:0|max:100',
            'stock' => 'integer|min:0|max:100',
            'launch_date' => 'date',
            'highlighted' => 'boolean',
            'singleplayer' => 'boolean',
            'multiplayer' => 'boolean',
            'cooperative' => 'boolean',
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($fields, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($fields);
        }

        //Éxito al guardar
        if ($this->product->create($fields)) {
            return Redirect::back()->with('save_success', 'Producto creado correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar crear el producto.'], 'create')
                        ->withInput(Input::all());
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $validator = Validator::make(['id' => $id], ['id' => 'exists:products']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
        }

        $product = $this->product->find($id);

        //Para el formato de la fecha
        $product->launch_date = date_format(new dateTime($product->launch_date), 'd-m-Y');

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de productos', URL::route('admin.product.index'));
        Breadcrumb::addBreadcrumb("ID: $product->id");

        return View::make('admin.pages.edit')
                        ->with('restful', 'product')
                        ->with('model', $product)
                        ->with('header_title', "Editar producto (id: {$product->id})")
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * 
     *
     * @param  int  $platformId
     * @return Response
     */
    public function show($platformId, $categoryId, $productId) {

        //Producto no existente para ese id, plataforma y categoría
        if (!$this->product->exists($productId, $platformId, $categoryId)) {
            return Redirect::route('index');
        }

        //Se añaden los ids de la plataforma, la categoría y el producto  al input
        Input::replace(array_merge(['platform_id' => $platformId, 'category_id' => $categoryId, 'product_id' => $productId], Input::all()));

        //Producto
        $product = $this->product->find($productId);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb($product->platform->name, URL::route('platform.show', ['platform_id' => $platformId]));
        Breadcrumb::addBreadcrumb($product->game->category->name, URL::route('platform.category.show', ['platform_id' => $platformId, 'category_id' => $categoryId]));
        Breadcrumb::addBreadcrumb($product->game->name);


        return View::make('client.pages.product')
                        ->with('product', $product)
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        //Cuando el checkbox del producto destacado está desmarcado su valor es null y se necesita un false
        Input::get('highlighted') !== null ? : Input::merge(['highlighted' => false]);

        //Campos del formulario
        $fields = Input::only([
                    'game_id', 'platform_id', 'publisher_id', 'price', 'discount',
                    'stock', 'launch_date', 'highlighted', 'singleplayer', 'multiplayer',
                    'cooperative',
        ]);

        //Reglas de validación
        $rules = [
            'game_id' => "exists:games,id|unique_with:products,platform_id,$id",
            'platform_id' => 'exists:platforms,id',
            'publisher_id' => 'exists:publishers,id',
            'price' => 'numeric|min:1',
            'discount' => 'numeric|min:0|max:100',
            'stock' => 'integer|min:0',
            'launch_date' => 'date',
            'highlighted' => 'boolean',
            'singleplayer' => 'boolean',
            'multiplayer' => 'boolean',
            'cooperative' => 'boolean',
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($fields, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'update')
                            ->withInput($fields);
        }

        //Éxito al guardar
        if ($this->product->update($id, $fields)) {
            return Redirect::back()->with('save_success', 'Producto modificado correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar modificar el producto.'], 'update')
                        ->withInput(Input::all());
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        $validator = Validator::make(['id' => $id], ['id' => 'exists:products']);

        //El id no existe
        if ($validator->fails()) {
            return Response::json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ), 400); // 400 being the HTTP code for an invalid request.
        }

        //Éxito al eliminar
        if ($this->product->erase($id)) {
            return Response::json(array('success' => true), 200);
        }

        //Error de SQL
        return Response::json(array(
                    'success' => false,
                    'errors' => ['error' => 'Error al intentar borrar el producto.']
                        ), 400);

//        //El id no existe
//        if ($validator->fails()) {
//            return Redirect::back();
//        }
//
//        //Éxito al eliminar
//        if ($this->product->erase($id)) {
//            return Redirect::back();
//        }
//        
//        //Error de SQL
//        return Redirect::back()
//                        ->withErrors(['error' => 'Error al intentar borrar el producto.'], 'erase');
    }

    public function index() {
        
        $products = $this->product->paginateForIndexTable('games.name', 'asc', 20, Input::get('page'));
        
        if (Request::ajax()) {
            return Response::json(View::make('admin.includes.index_table')
                                    ->with([
                                        'data' => $products,
                                        'header' => ['ID', 'Juego', 'Plataforma', 'Categoría', 'Distribuidora'],
                                        'restful' => 'product'])->render(), 200);
        }
        
        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición');

        return View::make('admin.pages.index')
                        ->with([
                            'data' => $products,
                            'header' => ['ID', 'Juego', 'Plataforma', 'Categoría', 'Distribuidora'],
                            'restful' => 'product'])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
