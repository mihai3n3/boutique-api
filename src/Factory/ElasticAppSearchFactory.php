<?php

namespace App\Factory;

use App\Manager\ElasticAppSearchManager;

class ElasticAppSearchFactory
{
    public function initialize($apiEndpoint,$apiKey,$engine)
    {
        return new ElasticAppSearchManager($apiEndpoint,$apiKey,$engine);
    }
}