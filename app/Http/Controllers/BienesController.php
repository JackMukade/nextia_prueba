<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Repositories\BienesRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Imports\ItemImport;
use Illuminate\Support\Facades\Storage;

class BienesController extends Controller {

    protected $bienes;
    protected $user;
   
    public function __construct() { 
        $this->bienes = new BienesRepository(); 
        $this->user   = Auth::user();
    }

    public function create(Request $request) {

        $user          = $this->user;
        $data          = $request->all();
        $data['user']  = $user['id']; #Le agrego el id del usuario que lo creo
           
        $create        = $this->bienes->create($data);
        $response      = (count($create) > 0 ) ? true : false;

        return response()->json(['response' => true, 'item' => $create, 'user' => $user], 200);

    }

    public function filescsv(Request $request) {

        $user         = $this->user;
        $itemsInExcel = Excel::toArray(new ItemImport, storage_path('Prueba_Tecnica_php.csv')); #Toma los datos de los archivos
        foreach ($itemsInExcel[0] as $item) {
                        
            $data   = ['id' => $item[0], 'articulo' => $item[1], 'descripcion' => $item[2], 'user' => $user['id']];
            $create = $this->bienes->create($data); #Va agregando los datos que se encontraban el archivo
           
        }

        return response()->json(['response' => true, 'user' => $user], 200);
      
    }

    public function read(Request $request, string $id) {

        $read     = $this->bienes->find($id); #Busca los datos segun el id dado
        $response = (count($read) > 0 ) ? true : false; #SI encontro datos esta bien

        $user     = $this->user;
       
        return response()->json(['response' => true, 'item' => $read, 'user' => $user], 200);

    }

    public function filter(Request $request, string $id) {

        $ids       = explode(',', $id); #Crea un array con los datos datos
        $idCollect = collect($ids);  #Crea un collection de laravel para trabajar el array
        $collect   = $idCollect->map(function ($id) { return intval(trim($id)); })->toArray(); #Convierte en ids
       
        $read      = $this->bienes->filter($collect); #Busca los ids
        $response  = (count($read) > 0 ) ? true : false;

        
        $user     = $this->user;
       
        return response()->json(['response' => true, 'items' => $read, 'user' => $user], 200);

    }

    public function update(Request $request) {

        $data     = $request->all();
        $read     = $this->bienes->find($data['id']); #Busca por el id dado el usuario
        $idReal   = $read['id']; #toma el consecutivo como id real
        $update   = $this->bienes->update($idReal, $data); #Actualiza los datos segun el id consectuvio
        $response = (count($update) > 0 ) ? true : false;

        $user     = $this->user;
       
        return response()->json(['response' => true, 'item' => $update, 'user' => $user], 200);

    }

    public function delete(Request $request) {

        $data     = $request->all();
        $read     = $this->bienes->find($data['id']);#Busca por el id dado el usuario
        $idReal   = $read['id']; 
        $this->bienes->delete($idReal); #Elimina los datos segun el id consectuvio

        $user     = $this->user;
        return response()->json(['response' => true, 'user' => $user], 200);

    }

}
