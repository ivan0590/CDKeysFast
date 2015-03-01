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
    public function create() {
        return View::make('admin.pages.create.developer')
                        ->with(['restful' => 'developer']);
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
            'name' => 'required|unique:developers'
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
        if ($this->developer->create($fields)) {

            return Redirect::back()->with(['save_success' => 'Desarrolladora creada correctamente.']);
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar crear la desarrolladora.'], 'create')
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
        $validator = Validator::make(['id' => $id], ['id' => 'exists:developers']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
        }
        
        //Éxito al eliminar
        if($this->developer->erase($id)){
            return Redirect::back();
            
        //Error de SQL
        } else {
            return Redirect::back()
                            ->withErrors(['error' => 'Error al intentar borrar la desarrolladora.'], 'create');          
        }
    }

    public function edition() {
        $developers = $this->developer->paginateForEditionTable('name', 'asc', 20);
        
        return View::make('admin.pages.edition')
                ->with(['data' => $developers,
                        'header' => ['ID', 'Desarrolladora'],
                        'restful' => 'developer']); 
    }
}
