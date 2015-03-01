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
    public function create() {
        return View::make('admin.pages.create.publisher')
                        ->with(['restful' => 'publisher']);
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
        $validationRules = [
            'name' => 'required|unique:publishers'
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
        if ($this->publisher->create($fields)) {

            return Redirect::back()->with(['save_success' => 'Distribuidora creada correctamente.']);
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
        $validator = Validator::make(['id' => $id], ['id' => 'exists:publishers']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
        }
        
        //Éxito al eliminar
        if($this->publisher->erase($id)){
            return Redirect::back();
            
        //Error de SQL
        } else {
            return Redirect::back()
                            ->withErrors(['error' => 'Error al intentar borrar la distribuidora.'], 'create');          
        }
    }

    public function edition() {
        $publishers = $this->publisher->paginateForEditionTable('name', 'asc', 20);

        return View::make('admin.pages.edition')
                        ->with(['data' => $publishers,
                            'header' => ['ID', 'Distribuidora'],
                            'restful' => 'publisher']);
    }

}
