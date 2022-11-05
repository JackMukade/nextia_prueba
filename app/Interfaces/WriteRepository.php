<?php 
namespace App\Interfaces;

interface WriteRepository { 

    public function create(array $data) : array; 

    public function update(string $id, array $data) : array; 

    public function delete(string $id)  : void; 

} 