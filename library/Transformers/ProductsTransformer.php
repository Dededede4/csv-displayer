<?php

namespace Dededede4\CsvDisplayer\Transformers;

use Symfony\Component\String\Slugger\AsciiSlugger;

class ProductsTransformer
{
    private const FORMATED_PRICE_DECIMALS = 2;

    public function getHeader() {
        return [
            'Sku',
            'Slug',
            'Status',
            'Price',
            'Currency',
            'Description',
            'Date'
        ];
    }

    public function getCallablesForValues() {
        return [
            'sku' => [$this, 'noTransform'],
            'title' => [$this, 'slugify'],
            'is_enabled' => [$this, 'humanReadableBoolean'],
            'price' => [$this, 'formatedPrice'],
            'currency' => [$this, 'noTransform'],
            'description' => [$this, 'removeHtml'],
            'created_at' => [$this, 'UTCDate']
        ];
    }

    public function noTransform($data) {
        return $data;
    }

    public function slugify($data) {
        $slugger = new AsciiSlugger();
        return $slugger->slug($data);
    }

    public function humanReadableBoolean($data) {
        return $data ? 'Enabled' : 'Disabled';
    }

    public function formatedPrice($data) {
        return number_format($data, self::FORMATED_PRICE_DECIMALS);
    }

    public function removeHtml($data) {
        return strip_tags($data);
    }

    public function UTCDate($data) {
        return (new \DateTime($data))->format('r');
    }
}