<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;
use Repositories\Language\LanguageRepositoryInterface as LanguageRepositoryInterface;
use Repositories\Developer\DeveloperRepositoryInterface as DeveloperRepositoryInterface;
use Services\Validation\Laravel\ProductValidator as ProductValidator;

class ProductController extends \BaseController {

    public function __construct(
    PlatformRepositoryInterface $platform, CategoryRepositoryInterface $category, ProductRepositoryInterface $product, LanguageRepositoryInterface $language, DeveloperRepositoryInterface $developer
    ) {
        $this->platform = $platform;
        $this->category = $category;
        $this->product = $product;
        $this->language = $language;
        $this->developer = $developer;
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
        $data = Input::only([
                    'game_id', 'platform_id', 'publisher_id', 'price', 'discount',
                    'stock', 'launch_date', 'highlighted', 'singleplayer', 'multiplayer',
                    'cooperative', 'text', 'audio', 'developer'
        ]);

        //Validación de los campos del formulario
        $productValidator = new ProductValidator(App::make('validator'));

        //Los campos son válidos
        if ($productValidator->with($data)->passes()) {

            if ($data['launch_date'] > 0) {
                $data['launch_date'] = new DateTime($data['launch_date']);
            }

            $product = $this->product->create($data);

            //Idiomas del texto y del audio
            foreach ((array) $data['text'] as $id) {
                $this->product->addLanguage($product->id, $id, 'text');
            }
            foreach ((array) $data['audio'] as $id) {
                $this->product->addLanguage($product->id, $id, 'audio');
            }

            //Desarrolladoras
            foreach ((array) $data['developer'] as $id) {
                $this->product->addDeveloper($product->id, $id);
            }

            return Redirect::back()->with('save_success', 'Producto creado correctamente.');
        }

        return Redirect::back()
                        ->withErrors($productValidator->errors(), 'create')
                        ->withInput($data);
    }

    /*     * º
     * 
     *
     * @param  int  $id
     * @return Response
     */

    public function edit($id) {

        //Validador del id
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:products,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        $product = $this->product->getById($id);

        //Para el formato de la fecha
        $product->launch_date = $product->launch_date > 0 ? date_format(new dateTime($product->launch_date), 'd-m-Y') : '';

        //Listas duales (audio, texto y desarrolladoras)
        $lists = [
            'text' => [
                'selected' => $product->textLanguages()->get(),
                'available' => $this->language->all()->diff($product->textLanguages()->get())
            ],
            'audio' => [
                'selected' => $product->audioLanguages()->get(),
                'available' => $this->language->all()->diff($product->audioLanguages()->get())
            ],
            'developer' => [
                'selected' => $product->developers()->get(),
                'available' => $this->developer->all()->diff($product->developers()->get())
            ]
        ];

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de productos', URL::route('admin.product.index'));
        Breadcrumb::addBreadcrumb("ID: $product->id");

        return View::make('admin.pages.edit')
                        ->with([
                            'restful' => 'product',
                            'model' => $product,
                            'header_title' => "Editar producto (id: {$product->id})",
                            'lists' => $lists])
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
            throw new NotFoundHttpException;
        }

        //Se añaden los ids de la plataforma, la categoría y el producto  al input
        Input::replace(array_merge(['platform_id' => $platformId, 'category_id' => $categoryId, 'product_id' => $productId], Input::all()));

        //Producto
        $product = $this->product->getById($productId);

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

        //Validador del id
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:products,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        //Cuando el checkbox del producto destacado está desmarcado su valor es null y se necesita un false
        Input::get('highlighted') !== null ? : Input::merge(['highlighted' => false]);

        //Campos del formulario
        $data = Input::only([
                    'game_id', 'platform_id', 'publisher_id', 'price', 'discount',
                    'stock', 'launch_date', 'highlighted', 'singleplayer', 'multiplayer',
                    'cooperative', 'text', 'audio', 'developer'
        ]);

        //Validación de los campos del formulario
        $productValidator = new ProductValidator(App::make('validator'), $id);

        //Los campos son válidos
        if ($productValidator->with($data)->passes()) {

            if ($data['launch_date'] > 0) {
                $data['launch_date'] = new DateTime($data['launch_date']);
            }

            $product = $this->product->updateById($id, $data);

            //Idiomas del texto y del audio
            $this->product->removeLanguages($product->id);
            foreach ((array) $data['text'] as $id) {
                $this->product->addLanguage($product->id, $id, 'text');
            }
            foreach ((array) $data['audio'] as $id) {
                $this->product->addLanguage($product->id, $id, 'audio');
            }

            //Desarrolladoras
            $this->product->removeDevelopers($product->id);
            foreach ((array) $data['developer'] as $id) {
                $this->product->addDeveloper($product->id, $id);
            }

            return Redirect::back()->with('save_success', 'Producto modificado correctamente.');
        }

        return Redirect::back()
                        ->withErrors($productValidator->errors(), 'update')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:products,id']);

        //El id no existe
        if ($idValidator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $idValidator->getMessageBag()->toArray()
                            ], 400);
        }

        $this->product->deleteById($id);

        return Response::json(['success' => true], 200);
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

        //Listas duales (audio, texto y desarrolladoras)
        $lists = [
            'text' => [
                'selected' => [],
                'available' => $this->language->all()
            ],
            'audio' => [
                'selected' => [],
                'available' => $this->language->all()
            ],
            'developer' => [
                'selected' => [],
                'available' => $this->developer->all()
            ]
        ];

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición');

        return View::make('admin.pages.index')
                        ->with([
                            'data' => $products,
                            'header' => ['ID', 'Juego', 'Plataforma', 'Categoría', 'Distribuidora'],
                            'restful' => 'product',
                            'lists' => $lists])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
