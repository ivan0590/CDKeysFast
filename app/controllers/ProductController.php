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
    public function create() {
        return View::make('admin.pages.create.product')
                ->with(['restful' => 'product']);
    }
    
    /**
     * 
     *
     * @return Response
     */
    public function store() {
        
        //Cuando el checkbox del producto destacado está desmarcado su valor es null y se necesita un false
        Input::get('highlighted') !== null ?: Input::merge(['highlighted' => false]);
        
        //Campos del formulario
        $fields = Input::only([
            'game_id', 'platform_id', 'publisher_id', 'price', 'discount',
            'stock', 'launch_date', 'highlighted', 'singleplayer', 'multiplayer',
            'cooperative',
        ]);
        
         //Reglas de validación
        $validationRules = [
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
        $validator = Validator::make($fields, $validationRules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($fields);
        }
        
        //Éxito al guardar
        if($this->product->create($fields)){
            return Redirect::back()->with(['save_success' => 'Producto creado correctamente.']);
            
        //Error de SQL
        } else {
            return Redirect::back()
                            ->withErrors(['error' => 'Error al intentar crear el producto.'], 'create')
                            ->withInput(Input::all());          
        }
        
    }
    
    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * 
     *
     * @param  int  $platformId
     * @return Response
     */
    public function show($platformId, $categoryId, $gameId) {

        //Producto no existente para ese id, plataforma y categoría
        if (!$this->product->exists($gameId, $platformId, $categoryId)) {
            return Redirect::route('index');
        }

        //Se añaden los ids de la plataforma, la categoría y el producto  al input
        Input::replace(array_merge(['platform_id' => $platformId, 'category_id' => $categoryId, 'product_id' => $gameId], Input::all()));

        //Producto
        $product = $this->product->find($gameId);

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
        //
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
            return Redirect::back();
        }
        
        //Éxito al eliminar
        if($this->product->erase($id)){
            return Redirect::back();
            
        //Error de SQL
        } else {
            return Redirect::back()
                            ->withErrors(['error' => 'Error al intentar borrar el producto.'], 'create');          
        }
        
    }

    public function edition() {
        
        $products = $this->product->paginateForEditionTable('games.name', 'asc', 20);
        
        return View::make('admin.pages.edition')
                ->with(['data' => $products,
                        'header' => ['ID', 'Juego', 'Plataforma', 'Categoría', 'Distribuidora'],
                        'restful' => 'product']); 
    }

}
