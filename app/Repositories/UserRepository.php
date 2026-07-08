<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\Paginator;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all($perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getByRole($role)
    {
        return $this->model->where('role', $role)->paginate(15);
    }

    public function getActive()
    {
        return $this->model->where('is_active', true)->paginate(15);
    }
}
