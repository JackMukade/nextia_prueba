<?php 
namespace App\Interfaces;

interface ReadRepository { 

    public function filter(array $data): array; 

    public function find(string $id)      : array; 

} 