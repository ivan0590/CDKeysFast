<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Repositories\Developer\DeveloperRepositoryInterface as DeveloperRepositoryInterface;
use Services\Validation\Laravel\DeveloperValidator as DeveloperValidator;

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

        //Validador de la desarrolladora
        $developerValidator = new DeveloperValidator(App::make('validator'));

        //Los campos son válidos
        if ($developerValidator->with($data)->passes()) {

            $this->developer->create($data);

            return Redirect::back()->with('save_success', 'Desarrolladora creada correctamente.');
        }

        return Redirect::back()
                        ->withErrors($developerValidator->errors(), 'create')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:developers,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        $developer = $this->developer->getById($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de desarrolladoras', URL::route('admin.developer.index'));
        Breadcrumb::addBreadcrumb($developer->name);

        return View::make('admin.pages.edit')
                        ->with([
                            'restful' => 'developer',
                            'model' => $developer,
                            'header_title' => "Editar desarrolladora (id: {$developer->id})"])
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:developers,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        //Campos del formulario
        $data = Input::only(['name']);

        //Validador de la desarrolladora
        $developerValidator = new DeveloperValidator(App::make('validator'), $id);

        //Los campos son válidos
        if ($developerValidator->with($data)->passes()) {
            
            $this->developer->updateById($id, $data);

            return Redirect::back()->with('save_success', 'Desarrolladora modificada correctamente.');
        }

        return Redirect::back()
                        ->withErrors($developerValidator->errors(), 'update')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:developers,id']);

        //El id no existe
        if ($idValidator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $idValidator->getMessageBag()->toArray()
                            ], 400);
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
