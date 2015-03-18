<?php

use Repositories\Publisher\PublisherRepositoryInterface as PublisherRepositoryInterface;

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

        //Reglas de validación
        $rules = [
            'name' => 'required|unique:publishers'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($data);
        }

        $this->publisher->create($data);

        return Redirect::back()->with('save_success', 'Distribuidora creada correctamente.');
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:publishers']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
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
        //Campos del formulario
        $data = Input::only(['name']);

        //Reglas de validación
        $rules = [
            'name' => "required|unique:publishers,name,$id"
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'update')
                            ->withInput($data);
        }

        $this->publisher->updateById($id, $data);

        return Redirect::back()->with('save_success', 'Distribuidora modificada correctamente.');
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:publishers']);

        //El id no existe
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
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
