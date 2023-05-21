<?php

namespace App\Http\Controllers;

use App\Services\YandexMusicParser;

class YandexMusicParserController extends Controller
{
    public function parseAll()
    {

        $parser = new YandexMusicParser('https://music.yandex.ru/artist/36800');

        $parser->parseArtist();
        $parser->parseTracks();

        return 'Tracks parsed and saved successfully.';
    }
}
