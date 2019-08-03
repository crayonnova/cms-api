<?php

namespace App\Repositories\User;


use App\Repositories\User\UserInterface as UserInterface;
use App\User;

class UserRepository implements UserInterface
{
    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll($offset,$limit)
    {
         return $this->user::orderBy('created_at','desc')
            ->skip($offset)
            ->take($limit)
            ->get()->toArray();
        // $total = User::count();
    }
    public function find($id)
    {
        // dd($id);
        return $this->user->find($id);
    }
    public function save($import)
    {
        
        return $this->user->fill($import)->save();
        // return $this->user->save();
    }
    public function delete($id)
    {
        return $this->user->deleteUser($id);
    }
    public function update($data)
    {
        // dd($data);
        return $this->user->find($data['id'])->update($data);
        // $this->user->fill($data);
        // return $this->user->save();
    }
}