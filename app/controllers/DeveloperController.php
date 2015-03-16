<?php

use Repositories\Developer\DeveloperRepositoryInterface as DeveloperRepositoryInterface;

class DeveloperController extends \BaseController {

    public function __construct(DeveloperRepositoryInterface $developer) {
        $this->developer = $developer;
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
            'name' => 'required|unique:developers'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($data);
        }
        
        $this->developer->create($data);
        
        return Redirect::back()->with('save_success', 'Desarrolladora creada correctamente.');
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $validator = Validator::make(['id' => $id], ['id' => 'exists:developers']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
        }

        $developer = $this->developer->getById($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de desarrolladoras', URL::route('admin.developer.index'));
        Breadcrumb::addBreadcrumb($developer->name);

        return View::make('admin.pages.edit')
                        ->with('restful', 'developer')
                        ->with('model', $developer)
                        ->with('header_title', "Editar desarrolladora (id: {$developer->id})")
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
            'name' => "required|unique:developers,name,$id"
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($data, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'update')
                            ->withInput($data);
        }

        $this->developer->updateById($id, $data);

        return Redirect::back()->with('save_success', 'Desarrolladora modificada correctamente.');
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $validator = Validator::make(['id' => $id], ['id' => 'exists:developers']);

        //El id no existe
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $this->developer->deleteById($id);

        return Response::json(['success' => true], 200);
    }

    public function index() {

        $developers = $this->developer->paginateForIndexTable('name', 'asc', 20, Input::get('page'));

        if (Request::ajax()) {
            return Response::json(View::make('admin.includes.index_table')
                                    ->with([
                                        'data' => $developers,
                                        'header' => ['ID', 'Desarrolladora'],
                                        'restful' => 'developer'])->render(), 200);
        }

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición');

        return View::make('admin.pages.index')
                        ->with([
                            'data' => $developers,
                            'header' => ['ID', 'Desarrolladora'],
                            'restful' => 'developer'])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
