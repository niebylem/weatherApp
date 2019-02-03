<?php

namespace App\Services\Interfaces;

interface RestInterface
{
    public function get();
    public function post();
    public function delete();
    public function put();
}
