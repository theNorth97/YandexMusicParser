<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\Track;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class YandexMusicParser
{
    protected $artistUrl;
    private $artistName;

    public function __construct($artistUrl)
    {
        $this->artistUrl = $artistUrl;
    }

    public function parseArtist()
    {
        $client = new Client();

        $crawlerTracks = $client->request('GET', $this->artistUrl . '/tracks');
        $crawlerAlbums = $client->request('GET', $this->artistUrl . '/albums');
        $crawlerInfo = $client->request('GET', $this->artistUrl . '/info');

        $artistName = $this->getCrawlerTextValue($crawlerTracks, '.page-artist__title');
        $subscribersCount = $this->getCrawlerTextValue($crawlerTracks, '.d-button__label', 0);
        $listenersMonthCount = $this->getCrawlerTextValue($crawlerTracks, '.page-artist__summary', 0);
        $artistInfo = $this->getCrawlerTextValue($crawlerInfo, '.page-artist__description');

        $albumsCount = $this->getAlbumsCount($crawlerAlbums);

        $artist = new Artist();
        $artist->name = $artistName;
        $artist->subscribers_count = $this->parseNumber($subscribersCount);
        $artist->listeners_month_count = $this->parseNumber($listenersMonthCount);
        $artist->albums_count = $albumsCount;
        $artist->artist_info = $artistInfo;
        $artist->save();
    }

    public function parseTracks()
    {
        $client = new Client();

        $crawlerTracks = $client->request('GET', $this->artistUrl . '/tracks');

        $trackElements = $crawlerTracks->filter('.d-track[data-id]');

        $this->artistName = $this->getCrawlerTextValue($crawlerTracks, '.page-artist__title');
        $artist = Artist::firstOrCreate(['name' => $this->artistName]);

        foreach ($trackElements as $trackElement) {
            $crawler = new Crawler($trackElement);

            $trackName = $crawler->filter('.d-track__name a')->text();
            $trackAlbum = $crawler->filter('.deco-link')->text();

            //Проверяю, есть ли трек или альбом в базе данных
            if ($this->checkTrackInDb($trackName) || $this->checkTrackInDb($trackAlbum)) {
                continue;
            }

            //Получаю продолжительность песни
            $trackduration = $crawler->filter('.typo-track.deco-typo-secondary')->text();

            $track = new Track();
            $track->name = trim($trackName);
            $track->album = trim($trackAlbum);
            $track->duration = trim($trackduration);

            // Связываем трек с артистом
            if ($artist) {
                $track->artist()->associate($artist);
            }

            $track->save();
        }
    }

    //Проверка на отсутствие элеменов.
    private function getCrawlerTextValue(Crawler $crawler, $selector, $index = 0)
    {
        return $crawler->filter($selector)->count() > $index ? $crawler->filter($selector)->eq($index)->text() : '';
    }

    //Кол-во альбомов
    private function getAlbumsCount($crawler)
    {
        $albumElements = $crawler->filter('.album');
        $albumsCount = $albumElements->count();
        return $albumsCount;
    }

    //Удаляю пробелы + преобразую в целое число)
    private function parseNumber($number)
    {
        return intval(str_replace(' ', '', $number));
    }

    //Проверка, есть ли трек с указанным названием в базе данных
    public function checkTrackInDb($trackName)
    {
        $track = Track::where('name', $trackName)->first();

        return $track !== null;
    }
}

