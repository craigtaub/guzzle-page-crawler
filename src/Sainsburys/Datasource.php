<?php

namespace Sainsburys;

use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;


class Datasource {

    const HOSTNAME = "http://www.sainsburys.co.uk";

    public function requestAll () {
        $result = null;

        try {
            $client = $this->getClient();
            $request = $this->_getRequestObject($client);
            $response = $request->send();

            $result = $response->getBody(true);

        } catch (\Exception $e) {
            // something has gone wrong
            throw $e;
        }

        return $result;
    }

    public function requestItem ($uri) {

        try {
            $client = $this->getClient();
            $request = $this->_getSimpleRequestObject($client, $uri);
            $response = $request->send();

            $result = $response->getBody(true);

        } catch (\Exception $e) {
            // something has gone wrong
            throw $e;
        }

        return $result;
    }

    public function getClient() {
        $client = new \Guzzle\Http\Client(self::HOSTNAME);

        return $client;
    }

    private function _getRequestObject($client) {
        $params = array(
            'msg'=> '',
            'langId' => 44,
            'categoryId' => 185749,
            'storeId' => 10151,
            'krypto' => 'BYbtRBKm5Av3wrX%2FkOcwzIbinIAPutPJvpz5IvpGf%2B1jcn1X9rT9WNh4wp2DnKjhlb8eOJD1yT48%0A%2B%2BP9xIDco%2Fgdg8fVV1VoIxH009mliFn0%2F6ixNnC%2FdF1siTai0D0iJ97UVbve9M%2FqXQ8rmkhcC2kQ%0ATvsv%2BqlXxZE3Zh%2BxOY5Nxg5InyuPJMuMQUfiLK3RYkAf84QIrKcx0J81LEWojDMM4F2TbRViN%2BRr%0AAk%2BDWV%2B0plWX9W8lpMGiyXP%2FvPiv693IXCSfHzqT9C5HpvBJ0ZGnPYKROcOKTVMHPUuUUJo%3D#langId=44',
            'storeId' => 10151,
            'catalogId' => 10137,
            'categoryId'=>185749,
            'parent_category_rn' => 12518,
            'top_category' => 12518,
            'pageSize' => 20,
            'orderBy'=> 'FAVOURITES_FIRST',
            'searchTerm' => '',
            'beginIndex' => 0,
            'hideFilters' => true
        );

        $uri = "/webapp/wcs/stores/servlet/CategoryDisplay";

        $cookiePlugin = new CookiePlugin(new ArrayCookieJar());
        $client->addSubscriber($cookiePlugin);

        return $client->get(
            $uri,
            array(),
            array(
                'query' => $params,
                'timeout' => 6, // 6 seconds
                'connect_timeout' => 5 // 5 seconds
            )
        );
    }

    private function _getSimpleRequestObject($client, $uri) {

        $cookiePlugin = new CookiePlugin(new ArrayCookieJar());
        $client->addSubscriber($cookiePlugin);

        return $client->get(
            $uri,
            array(),
            array(
                'query' => array(),
                'timeout' => 6, // 6 seconds
                'connect_timeout' => 5 // 5 seconds
            )
        );
    }

}