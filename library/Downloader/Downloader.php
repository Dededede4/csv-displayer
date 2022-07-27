<?php

namespace Dededede4\CsvDisplayer\Downloader;

use Dededede4\CsvDisplayer\Providers\ProviderInterface;

class Downloader
{
    private ProviderInterface $provider;

    public function __construct(ProviderInterface $provider) {
        $this->provider = $provider;
    }

    private function csvReader():\Generator {
        $url = $this->provider->getUrl();
        $handle = fopen($url, 'r');
        $keys = [];
        while (($data = fgetcsv($handle, 0, $this->provider->getSeparator())) !== FALSE) {
            if (empty($keys)) {
                $keys = $data;
                continue;
            }
            yield array_combine($keys, $data); // Le generateur renverra un tableau associatif
        }
    }

    public function getHeaders(): array
    {
        return $this->provider->getTransformer()->getHeader();
    }

    public function getRows(): array
    {
        $callables = $this->provider->getTransformer()->getCallablesForValues();
        $rows = [];
        foreach ($this->csvReader() as $line) {
            $row = [];
            foreach ($line as $key => $value) {
                $row[] = $callables[$key]($value);
            }
            $rows[] = $row;
        }
        return $rows;
    }
}