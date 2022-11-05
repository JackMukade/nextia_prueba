<?php 
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repository;
use App\Models\User;

class UserRepository implements Repository {

    public function filter(array $receive): array { 

        $user  = User::find($receive['id']);
        $roles = $user->roles()->get();
        return $roles->toArray();

    }

    public function find(string $id): array { return User::find(intval($id))->toArray(); }

    public function create(array $data): array { 

        $add               = new User;
        $add->name         = $data['name'];
        $add->email        = $data['email'];
        $add->password     = Hash::make($data['password']);
        $save              = $add->save();
        $token             = ($save) ? Auth::login($add) : '';

        $response          = $add->toArray();
        $response['token'] = $token;

        return $response;

    }

    public function update(string $id, array $data): array { }

    public function delete(string $id): void {  }

}