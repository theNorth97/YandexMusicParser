<?php

use App\Services\YandexMusicParser;

require_once 'YandexMusicParser.php';

// Пример использования
$parser = new YandexMusicParser('https://music.yandex.ru/artist/36800/tracks');
$parser->parseTracks();
$parser->parseArtist();
