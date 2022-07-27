<?php

namespace Dededede4\CsvDisplayer\Providers;

interface ProviderInterface
{
    public function getUrl(): string;
    public function getSeparator(): string;
}