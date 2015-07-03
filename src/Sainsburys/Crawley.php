<?php

namespace Sainsburys;

use \Symfony\Component\DomCrawler\Crawler;

class Crawley {

    public function parseTitlePriceTotal($markup) {

        $items = array();
        $crawler = new Crawler();
        $crawler->addHtmlContent($markup, 'UTF-8');

        $filter = $crawler->filter('.product');

        foreach ($filter as $content) {
            $crawler = new Crawler($content);

            $title = trim($crawler->filter('h3')->text());
            $pricePerUnit = trim($crawler->filter('.pricePerUnit')->text());
            $pricePerUnit = str_replace("/unit", "", $pricePerUnit);
            $link = $crawler->filter('.productInfo a')->attr('href');
            $items[] = array('title' => $title, 'unit_price' => $pricePerUnit, 'link' => $link);
        }

        return $items;
    }

    public function parseDescAndSize($markup) {

        $items = array();
        $crawler = new Crawler();
        $crawler->addHtmlContent($markup, 'UTF-8');

        $description = trim($crawler->filter('#information .productText')->text());

        return array('description' => $description, 'size' => strlen($markup));


    }
    
}