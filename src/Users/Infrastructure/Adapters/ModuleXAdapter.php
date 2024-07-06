<?php

namespace App\Users\Infrastructure\Adapters;

use App\ModuleX\Infrastructure\API\API;

class ModuleXAdapter
{
    public function __construct(private readonly API $moduleXApi)
    {
    }

    public function getData(): array
    {
        $this->moduleXApi->getData();
        //mapping
        return [];
    }
}