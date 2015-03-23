<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Repositories\Publisher\PublisherRepositoryInterface as PublisherRepositoryInterface;
use Services\Validation\Laravel\PublisherValidator as PublisherValidator;

class PublisherController extends \BaseController {

    public function __construct(PublisherRepositoryInterface $publisher) {
        $this->publisher = $publisher;
    }

    /**
     * 
     *
     * @return Response
     */
    public function store() {

        //Campos del formulario
        $data = Input::only(['name']);

        //Validador de la distribuidora
        $publisherValidator = new PublisherValidator(App::make('validator'));

        //Los campos son válidos
        if ($publisherValidator->with($data)->passes()) {

            $this->publisher->create($data);

            return Redirect::back()->with('save_success', 'Distribuidora creada correctamente.');
        }

        return Redirect::back()
                        ->withErrors($publisherValidator->errors(), 'create')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:publishers,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        $publisher = $this->publisher->getById($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de distribuidoras', URL::route('admin.publisher.index'));
        Breadcrumb::addBreadcrumb($publisher->name);

        return View::make('admin.pages.edit')
                        ->with([
                            'restful' => 'publisher',
                            'model' => $publisher,
                            'header_title' => "Editar distribuidora (id: {$publisher->id})"])
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:publishers,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        //Campos del formulario
        $data = Input::only(['name']);

        //Validador de la distribuidora
        $publisherValidator = new PublisherValidator(App::make('validator'), $id);

        //Los campos son válidos
        if ($publisherValidator->with($data)->passes()) {
            
            $this->publisher->updateById($id, $data);

            return Redirect::back()->with('save_success', 'Distribuidora modificada correctamente.');
        }
        
        return Redirect::back()
                        ->withErrors($publisherValidator->errors(), 'update')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:publishers,id']);

        //El id no existe
        if ($idValidator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $idValidator->getMessageBag()->toArray()
                            ], 400);
        }

        $this->publisher->deleteById($id);

        return Response::json(['success' => true], 200);
    }

    public function index() {

        $publishers = $this->publisher->paginateForIndexTable('name', 'asc', 20, Input::get('page'));

        if (Request::ajax()) {
            return Response::json(View::make('admin.includes.index_table')
                                    ->with([
                                        'data' => $publishers,
                                        'header' => ['ID', 'Distribuidora'],
                                        'restful' => 'publisher'])->render(), 200);
        }

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición');

        return View::make('admin.pages.index')
                        ->with([
                            'data' => $publishers,
                            'header' => ['ID', 'Distribuidora'],
                            'restful' => 'publisher'])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
