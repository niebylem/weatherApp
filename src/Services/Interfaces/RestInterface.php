<?php declare(strict_types = 1);

namespace App\Services\Interfaces;

interface RestInterface
{
    public function get(string $requestString);
    public function post();
    public function delete();
    public function put();
}
