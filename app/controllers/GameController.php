<?php

use Repositories\Game\GameRepositoryInterface as GameRepositoryInterface;

class GameController extends \BaseController {

    public function __construct(GameRepositoryInterface $game) {
        $this->game = $game;
    }

    /**
     * 
     *
     * @return Response
     */
    public function store() {

        //Campos del formulario
        $fields = Input::only([
                    'name', 'category_id', 'agerate_id', 'description', 'thumbnail_image_path',
                    'offer_image_path'
        ]);

        //Reglas de validación
        $rules = [
            'name' => 'required|unique:games',
            'category_id' => 'exists:categories,id',
            'agerate_id' => 'exists:agerates,id',
            'description' => 'string',
            'thumbnail_image_path' => 'mimes:jpeg,jpg,png|image|max:1024|image_size:256,256',
            'offer_image_path' => 'mimes:jpeg,jpg,png|image|max:2048|image_size:1920,1080'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($fields, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($fields);
        }
        
        //Imagenes
        $thumbnail = Input::file('thumbnail_image_path');
        $offer = Input::file('offer_image_path');

        //Para el alamacenamiento de la imagen de miniatura
        if ($thumbnail !== null) {
            $thumbnailDirectory = Config::get('constants.GAME_THUMBNAIL_IMAGE_DIR') . '/';
            $thumbnailFileName = "{$fields['name']}.{$thumbnail->getClientOriginalExtension()}";
            $fields['thumbnail_image_path'] = $thumbnailDirectory . $thumbnailFileName;
        }

        //Para el alamacenamiento de la imagen de oferta
        if ($offer !== null) {
            $offerDirectory = Config::get('constants.GAME_OFFER_IMAGE_DIR') . '/';
            $offerFileName = "{$fields['name']}.{$offer->getClientOriginalExtension()}";
            $fields['offer_image_path'] = $offerDirectory . $offerFileName;
        }

        //Se guardan las imagenes en la aplicación
        $thumbnail === null ? : $thumbnail->move($thumbnailDirectory, $thumbnailFileName);
        $offer === null ? : $offer->move($offerDirectory, $offerFileName);

        //Éxito al guardar
        if ($this->game->create($fields)) {

            return Redirect::back()->with('save_success', 'Juego creado correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar crear el juego.'], 'create')
                        ->withInput(Input::all());
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $validator = Validator::make(['id' => $id], ['id' => 'exists:games']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
        }

        $game = $this->game->find($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de juegos', URL::route('admin.game.index'));
        Breadcrumb::addBreadcrumb($game->name);

        return View::make('admin.pages.edit')
                        ->with('restful', 'game')
                        ->with('model', $game)
                        ->with('header_title', "Editar juego (id: {$game->id})")
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
        $fields = Input::only([
                    'name', 'category_id', 'agerate_id', 'description', 'thumbnail_image_path',
                    'offer_image_path'
        ]);

        //Reglas de validación
        $rules = [
            'name' => "required|unique:games,name,$id",
            'category_id' => 'exists:categories,id',
            'agerate_id' => 'exists:agerates,id',
            'description' => 'string',
            'thumbnail_image_path' => 'mimes:jpeg,jpg,png|image|max:1024|image_size:256,256',
            'offer_image_path' => 'mimes:jpeg,jpg,png|image|max:2048|image_size:1920,1080'
        ];


        //Validación de los campos del formulario
        $validator = Validator::make($fields, $rules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'update')
                            ->withInput($fields);
        }
        
        //Imagenes
        $thumbnail = Input::file('thumbnail_image_path');
        $offer = Input::file('offer_image_path');

        //Para el alamacenamiento de la imagen de miniatura
        if ($thumbnail !== null) {
            $thumbnailDirectory = Config::get('constants.GAME_THUMBNAIL_IMAGE_DIR') . '/';
            $thumbnailFileName = "{$fields['name']}.{$thumbnail->getClientOriginalExtension()}";
            $fields['thumbnail_image_path'] = $thumbnailDirectory . $thumbnailFileName;
        } else {
            $fields['thumbnail_image_path'] = $this->game->find($id)->thumbnail_image_path;
        }

        //Para el alamacenamiento de la imagen de oferta
        if ($offer !== null) {
            $offerDirectory = Config::get('constants.GAME_OFFER_IMAGE_DIR') . '/';
            $offerFileName = "{$fields['name']}.{$offer->getClientOriginalExtension()}";
            $fields['offer_image_path'] = $offerDirectory . $offerFileName;
        } else {
            $fields['offer_image_path'] = $this->game->find($id)->offer_image_path;
        }

        //Se guardan las imagenes en la aplicación
        $thumbnail === null ? : $thumbnail->move($thumbnailDirectory, $thumbnailFileName);
        $offer === null ? : $offer->move($offerDirectory, $offerFileName);

        //Éxito al guardar el juego y las imagenes
        if ($this->game->update($id, $fields)) {

            return Redirect::back()->with('save_success', 'Juego modificado correctamente.');
        }

        //Error de SQL
        return Redirect::back()
                        ->withErrors(['error' => 'Error al intentar modificar el juego.'], 'update')
                        ->withInput(Input::all());
    }

    /**
     * 
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {

        $validator = Validator::make(['id' => $id], ['id' => 'exists:games']);

        //El id no existe
        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                            ], 400); // 400 being the HTTP code for an invalid request.
        }

        //Ruta de la imagen para borrarla
        $thumbnail_image_path = $this->game->find($id)->thumbnail_image_path;
        $offer_image_path = $this->game->find($id)->offer_image_path;

        //Éxito al eliminar
        if ($this->game->erase($id)) {
            File::delete($thumbnail_image_path);
            File::delete($offer_image_path);

            return Response::json(['success' => true], 200);
        }

        //Error de SQL
        return Response::json([
                    'success' => false,
                    'errors' => ['error' => 'Error al intentar borrar el juego.']
                        ], 400);

//        //El id no existe
//        if ($validator->fails()) {
//            return Redirect::back();
//        }
//
//        //Ruta de la imagen para borrarla
//        $thumbnail_image_path = $this->game->find($id)->thumbnail_image_path;
//        $offer_image_path = $this->game->find($id)->offer_image_path;
//
//        //Éxito al eliminar
//        if ($this->game->erase($id)) {
//            File::delete($thumbnail_image_path);
//            File::delete($offer_image_path);
//
//            return Redirect::back();
//        }
//
//        //Error de SQL
//        return Redirect::back()
//                        ->withErrors(['error' => 'Error al intentar borrar el juego.'], 'erase');
    }

    public function index() {
        $games = $this->game->paginateForIndexTable('games.name', 'asc', 20, Input::get('page'));

        if (Request::ajax()) {

            return Response::json(View::make('admin.includes.index_table')
                                    ->with([
                                        'data' => $games,
                                        'header' => ['ID', 'Juego', 'Categoría', 'Calificación por edad'],
                                        'restful' => 'game'])->render(), 200);
        }

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición');

        return View::make('admin.pages.index')
                        ->with([
                            'data' => $games,
                            'header' => ['ID', 'Juego', 'Categoría', 'Calificación por edad'],
                            'restful' => 'game'])
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
