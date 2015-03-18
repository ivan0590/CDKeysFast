<?php

use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;
use Repositories\Game\GameRepositoryInterface as GameRepositoryInterface;
use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Developer\DeveloperRepositoryInterface as DeveloperRepositoryInterface;
use Repositories\Publisher\PublisherRepositoryInterface as PublisherRepositoryInterface;
use Repositories\Language\LanguageRepositoryInterface as LanguageRepositoryInterface;
use Repositories\Agerate\AgerateRepositoryInterface as AgerateRepositoryInterface;

class MassiveUploadController extends \BaseController {

    public function __construct(
    ProductRepositoryInterface $product, GameRepositoryInterface $game, PlatformRepositoryInterface $platform, CategoryRepositoryInterface $category, DeveloperRepositoryInterface $developer, PublisherRepositoryInterface $publisher, LanguageRepositoryInterface $language, AgerateRepositoryInterface $agerate) {
        $this->product = $product;
        $this->game = $game;
        $this->platform = $platform;
        $this->category = $category;
        $this->developer = $developer;
        $this->publisher = $publisher;
        $this->language = $language;
        $this->agerate = $agerate;
    }

    /**
     * 
     *
     * @return Response
     */
    public function create() {

        //Miga de pan
        Breadcrumb::addBreadcrumb('Carga masiva de categorías, juegos y productos');

        return View::make('admin.pages.massive_upload')
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * 
     *
     * @return Response
     */
    public function store() {

        //Para evitar que salten excepciones al validar el código XML
        libxml_use_internal_errors(true);

        //Objeto XML
        $xml = simplexml_load_file(Input::file('xml'));

        //El texto no está en formato XML
        if (!$xml) {
            return Redirect::back()
                            ->withErrors(['error' => 'El texto introducido no está en formato XML.'], 'Formato incorrecto');
        }

        //Objeto DOM
        $dom = new DOMDocument();
        $dom->loadXML($xml->asXML());
        $dom->saveXML();
        libxml_clear_errors();

        //El texto está en XML pero no cumple con el esquema
        if (!$dom->schemaValidate(app_path() . '/massive-upload.xsd')) {
            return Redirect::back()
                            ->withErrors(['error' => 'El código XML no cumple el esquema solicitado'], 'Esquema incorrecto');
        }

        //Iterador
        $iterator = new SimpleXmlIterator($xml->asXML());

        //Éxitos
        $successMessages = ['categorias' => [], 'juegos' => [], 'productos' => []];

        //GRUPO-CATEGORIAS
        foreach ($iterator->{'grupo-categorias'}->categoria as $categoryIterator) {

            $categoryName = strval($categoryIterator->attributes()->nombre);

            $data = ['name' => $categoryName];

            $rules = ['name' => 'unique:categories,name'];

            $messages = ['name.unique' => "Ya existe una categoría con el nombre '$categoryName'."];

            //Se comprueba que no haya ya una categoría con ese nombre
            $categoryValidator = Validator::make($data, $rules, $messages);

            if ($categoryValidator->passes()) {

                $data = [
                    'name' => $categoryName,
                    'description' => strval($categoryIterator->descripcion),
                ];

                $this->category->create($data);

                array_push($successMessages['categorias'], "Categoría '$categoryName' creada correctamente.");
            }
        }

        //GRUPO-JUEGOS
        foreach ($iterator->{'grupo-juegos'}->categoria as $categoryIterator) {

            //Se itera por los juegos de la categoría
            foreach ($categoryIterator as $gameIterator) {

                $gameName = strval($gameIterator->attributes()->nombre);
                $categoryName = strval($categoryIterator->attributes()->nombre);
                $agerateName = strval($gameIterator->{'calificacion-edad'});

                $data = [
                    'game' => $gameName,
                    'category' => $categoryName,
                    'agerate' => $agerateName
                ];

                $rules = [
                    'game' => 'unique:games,name',
                    'category' => 'exists:categories,name',
                    'agerate' => 'exists:agerates,name'
                ];

                $messages = [
                    'game.unique' => "Ya existe un juego con el nombre '$gameName' (categoría: $categoryName).",
                    'category.exists' => "La categoría '$categoryName' no existe.",
                    'agerate.exists' => "La calificación de edad '$agerateName' no existe (categoría: $categoryName, juego: $gameName)."
                ];

                //Se comprueba que no haya ya un juego con ese nombre
                $gameValidator = Validator::make($data, $rules, $messages);

                if ($gameValidator->passes()) {

                    $data = [
                        'category_id' => $this->category->getByName($categoryName)->id,
                        'agerate_id' => $this->agerate->getByName($agerateName)->id,
                        'name' => $gameName,
                        'description' => strval($gameIterator->descripcion),
                    ];

                    $this->game->create($data);

                    array_push($successMessages['juegos'], "Juego '$gameName' para la categoría '$categoryName' creado correctamente.");
                }
            }
        }


        //Errores
        $errorMessagesProducts = [];

        //GRUPO-PRODUCTOS
        foreach ($iterator->{'grupo-productos'}->plataforma as $platformIterator) {

            //Se itera por los productos de la plataforma
            foreach ($platformIterator as $productIterator) {

                $gameName = strval($productIterator->attributes()->juego);
                $platformName = strval($platformIterator->attributes()->nombre);
                $publisherName = strval($productIterator->distribuidora);

                //Se obtienen las claves ajenas
                $game = $this->game->getByName($gameName);
                $platform = $this->platform->getByName($platformName);
                $publisher = $this->publisher->getByName($publisherName);

                //Se comprueba que existan
                if ($game !== null && $platform !== null && $publisher !== null) {

                    $data = ['game_id' => $game->id, 'platform_id' => $platform->id];
                    $rules = ['game_id' => 'unique_with:products,platform_id'];

                    //Se comprueba que no haya ya un producto para dicho juego y plataforma
                    $validator = Validator::make($data, $rules);

                    if ($validator->passes()) {

                        $data = [
                            'game_id' => $game->id,
                            'platform_id' => $platform->id,
                            'publisher_id' => $publisher->id,
                            'price' => round(floatval($productIterator->precio), 2, PHP_ROUND_HALF_UP),
                            'discount' => round(floatval($productIterator->descuento), 2, PHP_ROUND_HALF_UP),
                            'stock' => intval($productIterator->stock),
                            'launch_date' => new dateTime(strval($iterator->{'fecha-lanzamiento'})),
                            'highlighted' => boolval($productIterator->destacado),
                            'singleplayer' => strval($productIterator->attributes()->un_jugador),
                            'multiplayer' => strval($productIterator->attributes()->multijugador),
                            'cooperative' => strval($productIterator->attributes()->cooperativo)
                        ];

                        $this->product->create($data);

                        $product = $this->product->getByGameAndPlatform($game->id, $platform->id);

                        //Desarrolladoras
                        foreach ($productIterator->{'grupo-desarrolladoras'} as $developerIterator) {
                            $developer = $this->developer->getByName($developerIterator->desarrolladora);

                            if ($developer !== null) {
                                $this->product->addDeveloper($product->id, $developer->id);
                            } else {
                                $warning = true;
                                array_push($errorMessagesProducts, "La desarrolladora '{$developerIterator->desarrolladora}' no existe (plataforma: $platformName, juego: $gameName).");
                            }
                        }

                        //Audio
                        foreach ($productIterator->audio as $audioIterator) {
                            $language = $this->language->getByName($audioIterator->idioma);

                            if ($language !== null) {
                                $this->product->addLanguage($product->id, $language->id, 'audio');
                            } else {
                                $warning = true;
                                array_push($errorMessagesProducts, "El idioma '{$audioIterator->idioma}' no existe (plataforma: $platformName, juego: $gameName).");
                            }
                        }

                        //Texto
                        foreach ($productIterator->texto as $textIterator) {
                            $language = $this->language->getByName($textIterator->idioma);

                            if ($language !== null) {
                                $this->product->addLanguage($product->id, $language->id, 'text');
                            } else {
                                $warning = true;
                                array_push($errorMessagesProducts, "El idioma '{$textIterator->idioma}' no existe (plataforma: $platformName, juego: $gameName).");
                            }
                        }

                        array_push($successMessages['productos'], "Producto para el juego '$gameName' y la plataforma '$platformName' creado " . (isset($warning) ? 'con algunos errores.' : 'correctamente.'));
                    } else {
                        array_push($errorMessagesProducts, "Ya existe un producto para el juego '$gameName' y la plataforma '$platformName'.");
                    }
                } else {
                    $platform !== null ? : array_push($errorMessagesProducts, "La plataforma '$platformName' no existe.");
                    $game !== null ? : array_push($errorMessagesProducts, "El juego '$gameName' no existe (plataforma: $platformName).");
                    $publisher !== null ? : array_push($errorMessagesProducts, "La distribuidora '$publisherName' no existe (plataforma: $platformName, juego: $gameName).");
                }
            }
        }

        return Redirect::back()
                        ->withErrors($categoryValidator, 'Errores en el grupo de categorias')
                        ->withErrors($gameValidator, 'Errores en el grupo de juegos')
                        ->withErrors($errorMessagesProducts, 'Errores en el grupo de productos')
                        ->with('save_success', $successMessages);
    }

}
