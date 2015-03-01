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
    public function create() {
        return View::make('admin.pages.create.game')
                        ->with(['restful' => 'game']);
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
        $validationRules = [
            'name' => 'required|unique:games',
            'category_id' => 'exists:categories,id',
            'agerate_id' => 'exists:agerates,id',
            'description' => 'string',
            'thumbnail_image_path' => 'image',
            'offer_image_path' => 'image'
        ];

        //Validación de los campos del formulario
        $validator = Validator::make($fields, $validationRules);

        //Los campos no son válidos
        if ($validator->fails()) {
            return Redirect::back()
                            ->withErrors($validator, 'create')
                            ->withInput($fields);
        }

        $thumbnail = Input::file('thumbnail_image_path');
        if ($thumbnail !== null) {
            $thumbnailDirectory = Config::get('constants.GAME_THUMBNAIL_IMAGE_DIR') . '/';
            $thumbnailFileName = "{$fields['name']}.{$thumbnail->getClientOriginalExtension()}";
            $fields['thumbnail_image_path'] = $thumbnailDirectory . $thumbnailFileName;
        }

        $offer = Input::file('offer_image_path');
        if ($offer !== null) {
            $offerDirectory = Config::get('constants.GAME_OFFER_IMAGE_DIR') . '/';
            $offerFileName = "{$fields['name']}.{$offer->getClientOriginalExtension()}";
            $fields['offer_image_path'] = $offerDirectory . $offerFileName;
        }

        //Éxito al guardar
        if ($this->game->create($fields) &&
                ($thumbnail === null || $thumbnail->move($thumbnailDirectory, $thumbnailFileName)) &&
                ($offer     === null || $offer->move($offerDirectory, $offerFileName))) {

            return Redirect::back()->with(['save_success' => 'Juego creado correctamente.']);
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
        //
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
        
        $validator = Validator::make(['id' => $id], ['id' => 'exists:games']);

        //El id no existe
        if ($validator->fails()) {
            return Redirect::back();
        }
        
        //Éxito al eliminar
        if($this->game->erase($id)){
            return Redirect::back();
            
        //Error de SQL
        } else {
            return Redirect::back()
                            ->withErrors(['error' => 'Error al intentar borrar el juego.'], 'create');          
        }
    }

    public function edition() {
        $games = $this->game->paginateForEditionTable('games.name', 'asc', 20);

        return View::make('admin.pages.edition')
                        ->with(['data' => $games,
                            'header' => ['ID', 'Juego', 'Categoría', 'Calificación por edad'],
                            'restful' => 'game']);
    }

}
