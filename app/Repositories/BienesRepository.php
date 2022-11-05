<?php 
namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repository;
use App\Models\Bienes;

class BienesRepository implements Repository {

    public function filter(array $data): array { 

        $bienes  = Bienes::select('id', 'idItem', 'articulo', 'descripcion')->whereIn('idItem', $data)->get();
        return ($bienes !== NULL) ? $bienes->toArray() : array();

    }

    public function find(string $id): array { 

        $bienes  = Bienes::select('id', 'idItem', 'articulo', 'descripcion')->where('idItem', $id)->first();
        return ($bienes !== NULL) ? $bienes->toArray() : array();

    }

    public function create(array $data): array { 

        $add               = new Bienes;
        $add->idItem       = $data['id'];
        $add->articulo     = $data['articulo'];
        $add->descripcion  = $data['descripcion'];
        $add->user_id      = $data['user'];
        $saved             = $add->save();
        return $add->toArray();

    }

    public function update(string $id, array $data): array { 

        $upd               = Bienes::find(intval($id));
        $upd->idItem       = $data['id'];
        $upd->articulo     = $data['articulo'];
        $upd->descripcion  = $data['descripcion'];
        $upd->user_id      = 1;
        return $upd->toArray();

    }

    public function delete(string $id): void {  

        $del = Bienes::find(intval($id));       
        $del->delete();

    }

}