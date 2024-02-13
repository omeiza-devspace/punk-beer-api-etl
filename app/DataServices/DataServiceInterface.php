<?php

namespace App\DataServices;

interface DataServiceInterface
{
    public function getData($params);
    public function transformData($data);
    public function processData($data);
}