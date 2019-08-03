<?php
namespace App\Repositories\User;

interface UserInterface{
    public function getAll($offset,$limit);
    public function find($id);
    public function save($import);
    public function delete($id);
    public function update($data);
}   