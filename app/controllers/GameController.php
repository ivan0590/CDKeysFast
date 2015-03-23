<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Repositories\Game\GameRepositoryInterface as GameRepositoryInterface;
use Services\Validation\Laravel\GameValidator as GameValidator;

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
        $data = Input::only([
                    'name', 'category_id', 'agerate_id', 'description', 'thumbnail_image_path',
                    'offer_image_path'
        ]);

        //Validador del controlador
        $gameValidator = new GameValidator(App::make('validator'));

        //Los campos son válidos
        if ($gameValidator->with($data)->passes()) {

            //Imagenes
            $thumbnail = Input::file('thumbnail_image_path');
            $offer = Input::file('offer_image_path');

            //Para el alamacenamiento de la imagen de miniatura
            if ($thumbnail !== null) {
                $thumbnailDirectory = Config::get('constants.GAME_THUMBNAIL_IMAGE_DIR') . '/';
                $thumbnailFileName = "{$data['name']}.{$thumbnail->getClientOriginalExtension()}";
                $data['thumbnail_image_path'] = $thumbnailDirectory . $thumbnailFileName;
            }

            //Para el alamacenamiento de la imagen de oferta
            if ($offer !== null) {
                $offerDirectory = Config::get('constants.GAME_OFFER_IMAGE_DIR') . '/';
                $offerFileName = "{$data['name']}.{$offer->getClientOriginalExtension()}";
                $data['offer_image_path'] = $offerDirectory . $offerFileName;
            }

            $this->game->create($data);

            //Se guardan las imagenes del juego
            $thumbnail === null ? : $thumbnail->move($thumbnailDirectory, $thumbnailFileName);
            $offer === null ? : $offer->move($offerDirectory, $offerFileName);


            return Redirect::back()->with('save_success', 'Juego creado correctamente.');
        }

        return Redirect::back()
                        ->withErrors($gameValidator->errors(), 'create')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:games,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }


        $game = $this->game->getById($id);

        //Miga de pan
        Breadcrumb::addBreadcrumb('Edición de juegos', URL::route('admin.game.index'));
        Breadcrumb::addBreadcrumb($game->name);

        return View::make('admin.pages.edit')
                        ->with([
                            'restful' => 'game',
                            'model' => $game,
                            'header_title' => "Editar juego (id: {$game->id})"])
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:games,id']);

        //El id no existe
        if ($idValidator->fails()) {
            throw new NotFoundHttpException;
        }

        //Campos del formulario
        $data = Input::only([
                    'name', 'category_id', 'agerate_id', 'description', 'thumbnail_image_path',
                    'offer_image_path'
        ]);

        //Validación de los campos del formulario
        $gameValidator = new GameValidator(App::make('validator'), $id);

        //Los campos son válidos
        if ($gameValidator->with($data)->passes()) {
            
            //Imagenes
            $thumbnail = Input::file('thumbnail_image_path');
            $offer = Input::file('offer_image_path');

            //Para el alamacenamiento de la imagen de miniatura
            if ($thumbnail !== null) {
                $thumbnailDirectory = Config::get('constants.GAME_THUMBNAIL_IMAGE_DIR') . '/';
                $thumbnailFileName = "{$data['name']}.{$thumbnail->getClientOriginalExtension()}";
                $data['thumbnail_image_path'] = $thumbnailDirectory . $thumbnailFileName;
            } else {
                $data['thumbnail_image_path'] = $this->game->getById($id)->thumbnail_image_path;
            }

            //Para el alamacenamiento de la imagen de oferta
            if ($offer !== null) {
                $offerDirectory = Config::get('constants.GAME_OFFER_IMAGE_DIR') . '/';
                $offerFileName = "{$data['name']}.{$offer->getClientOriginalExtension()}";
                $data['offer_image_path'] = $offerDirectory . $offerFileName;
            } else {
                $data['offer_image_path'] = $this->game->getById($id)->offer_image_path;
            }

            $this->game->updateById($id, $data);

            //Se guardan las imagenes del juego
            $thumbnail === null ? : $thumbnail->move($thumbnailDirectory, $thumbnailFileName);
            $offer === null ? : $offer->move($offerDirectory, $offerFileName);


            return Redirect::back()->with('save_success', 'Juego modificado correctamente.');
        }

        return Redirect::back()
                        ->withErrors($gameValidator->errors(), 'update')
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
        $idValidator = Validator::make(['id' => $id], ['id' => 'exists:games,id']);

        //El id no existe
        if ($idValidator->fails()) {
            return Response::json([
                        'success' => false,
                        'errors' => $idValidator->getMessageBag()->toArray()
                            ], 400);
        }

        //Ruta de la imagen para borrarla
        $thumbnail_image_path = $this->game->getById($id)->thumbnail_image_path;
        $offer_image_path = $this->game->getById($id)->offer_image_path;

        $this->game->deleteById($id);

        //Se borran las imagenes del juego
        File::delete($thumbnail_image_path);
        File::delete($offer_image_path);

        return Response::json(['success' => true], 200);
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
