<?php

namespace Dededede4\CsvDisplayer\Providers;


use Dededede4\CsvDisplayer\Transformers\ProductsTransformer;

class ProductsProvider implements ProviderInterface
{
    private static $url = 'https://recrutement.dnd.fr/products.csv';
    private static $separator = ';';

    public function getUrl(): string {
        return self::$url;
    }

    public function getSeparator(): string {
        return self::$separator;
    }

    public function getTransformer() {
        return new ProductsTransformer();
    }
}