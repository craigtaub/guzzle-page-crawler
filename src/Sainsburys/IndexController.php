<?php

namespace Sainsburys;

class IndexController {

    private $_datasource;
    private $_crawley;

    public function __construct() {
        $this->_datasource = new Datasource(); 
        $this->_crawley = new Crawley();
    }

    public function run () {
        $markup = $this->_getProducts();
        $allItems = $this->_buildResultsAndTotal($markup);

        return $this->_buildResponse($allItems);
    }

    private function _getProducts() {
        try {
            $result = $this->_datasource->requestAll();
        } catch (\Exception $e) {
            // something has gone wrong
        }

        return $result;

    }

    private function _buildResultsAndTotal($markup) {
        $results = array();
        $total = 0;
        $parsedTitalAndPrice = $this->_crawley->parseTitlePriceTotal($markup);

        $mergeAllData = function ($item) use (&$total) {
            try {
                $markup = $this->_datasource->requestItem($item['link']);
            } catch (\Exception $e) {
                // something has gone wrong
                return array();
            }

            $total += $item['unit_price'];
            $parsedDescAndSize = $this->_crawley->parseDescAndSize($markup);

            return array(
                'title' => $item['title'],
                'size' => $this->_parseBytesToKb($parsedDescAndSize['size']),
                'unit_price' => $item['unit_price'],
                'description' => $parsedDescAndSize['description']
            );
        };
        $results = array_map($mergeAllData, $parsedTitalAndPrice);

        return array('results' => $results, 'total' => $total);
    }

    private function _buildResponse($dataArray) {
        return json_encode(
            array(
                'results' => $dataArray['results'], 
                'total' => $dataArray['total']
            )
        );
    }

    private function _parseBytesToKb($number) {
        return number_format($number / 1024, 2) . 'kb';
    }
}   