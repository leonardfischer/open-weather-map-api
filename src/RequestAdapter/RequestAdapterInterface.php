<?php

namespace lfischer\openWeatherMap\RequestAdapter;

interface RequestAdapterInterface
{
    public function request(string $url): string;
}
