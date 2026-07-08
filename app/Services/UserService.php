<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers($perPage = 15)
    {
        return $this->repository->all($perPage);
    }

    public function getUserById($id)
    {
        return $this->repository->find($id);
    }

    public function createUser(array $data)
    {
        try {
            if ($this->repository->findByEmail($data['email'])) {
                throw new Exception('Email sudah terdaftar');
            }

            $data['password'] = Hash::make($data['password']);
            return $this->repository->create($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateUser($id, array $data)
    {
        try {
            if (isset($data['email'])) {
                $existing = $this->repository->findByEmail($data['email']);
                if ($existing && $existing->id != $id) {
                    throw new Exception('Email sudah terdaftar');
                }
            }

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteUser($id)
    {
        return $this->repository->delete($id);
    }

    public function getUsersByRole($role)
    {
        return $this->repository->getByRole($role);
    }

    public function getActiveUsers()
    {
        return $this->repository->getActive();
    }
}
