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
        $fields = Input::only(['name']);

        //Reglas de validación
        $rules = [
            'name' => 'required|unique:publishers'
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
        if ($this->publisher->create($fields)) {

            return Redirect::back()->with('save_success', 'Distribuidora creada correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar crear la distribuidora.'], 'create')
                        ->withInput(Input::all());
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

        $publisher = $this->publisher->find($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de distribuidoras', URL::route('admin.publisher.index'));
        Breadcrumb::addBreadcrumb($publisher->name);

        return View::make('admin.pages.edit')
                        ->with('restful', 'publisher')
                        ->with('model', $publisher)
                        ->with('header_title', "Editar distribuidora (id: {$publisher->id})")
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
        $fields = Input::only(['name']);

        //Reglas de validación
        $rules = [
            'name' => "required|unique:publishers,name,$id"
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
        if ($this->publisher->update($id, $fields)) {

            return Redirect::back()->with('save_success', 'Distribuidora modificada correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar modificar la distribuidora.'], 'update')
                        ->withInput(Input::all());
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
                            ], 400); // 400 being the HTTP code for an invalid request.
        }

        //Éxito al eliminar
        if ($this->publisher->erase($id)) {
            return Response::json(['success' => true], 200);
        }

        //Error de SQL
        return Response::json([
                    'success' => false,
                    'errors' => ['error' => 'Error al intentar borrar la distribuidora.']
                        ], 400);

//        //El id no existe
//        if ($validator->fails()) {
//            return Redirect::back();
//        }
//
//        //Éxito al eliminar
//        if ($this->publisher->erase($id)) {
//            return Redirect::back();
//        }
//
//        //Error de SQL
//        return Redirect::back()
//                        ->withErrors(['error' => 'Error al intentar borrar la distribuidora.'], 'erase');
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
