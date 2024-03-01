<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class UsersModel
{
    public $DB;

    public function __construct()
    {
        $this->DB = new DB;
    }

    public function Create($bind)
    {
        $results = $this->DB::selectOne("INSERT INTO public.users(
                address,
                age,
                avatar,
                email,
                first_name,
                last_name,
                gender,
                password,
                phone,
                status
            ) VALUES (
                :address,
                :age,
                :avatar,
                :email,
                :first_name,
                :last_name,
                :gender,
                :password,
                :phone,
                :status
             ) returning *;", $bind);

        return $results;
    }

    public function CreateCustomer($bind, $column = 'id, first_name, last_name, email, phone')
    {
        $results = $this->DB::selectOne("INSERT INTO public.users(
                first_name,
                last_name,
                email,
                phone
            ) VALUES (
                :first_name,
                :last_name,
                :email,
                :phone
             ) returning {$column};", $bind);

        return $results;
    }

    public function Edit($bind, $set)
    {
        $results = $this->DB::selectOne("
            UPDATE public.users SET
                {$set}
            WHERE
                id = :id returning *;
        ", $bind);
        return $results;
    }

    public function Find($where, $bind, $column = null)
    {
        // set default column
        $column = $column === null ? '
           us.id,
           us.first_name,
           us.last_name,
           us.phone,
           us.email,
           us.status,
           us.gender,
           us.address,
           us.created_at,
           us.updated_at,
           us.deleted_at,
           us.age,
           us.avatar' : $column;

        // query sql
        $SQL = "SELECT {$column} FROM users as US
        {$where} limit :limit offset :offset;";

        $results = $this->DB::select($SQL, $bind);
        return $results;
    }

    public function FindTotal($where, $bind)
    {
        // query sql
        $SQL = "SELECT count(US.id) as total FROM users as US
        {$where};";

        $results = $this->DB::selectOne($SQL, $bind)->total;
        return $results;
    }

    public function FindOne($phone, $column = '*')
    {
        $results = $this->DB::selectOne("SELECT {$column} FROM users Where phone = :phone;", ['phone' => $phone]);
        return $results;
    }

    public function FindOneByEmail($email)
    {
        $results = $this->DB::selectOne("SELECT * FROM users Where email = :email;", ['email' => $email]);
        return $results;
    }

    public function FindOneById($id, $column = null)
    {
        // set default column
        $column = $column === null ? '
        US.id,
        US.first_name,
        US.last_name,
        US.phone, 
        US.email, 
        US.status, 
        US.gender, 
        US.address, 
        US.created_at, 
        US.updated_at, 
        US.deleted_at, 
        US.age, 
        US.avatar' : $column;

        // sql query
        $SQL = "SELECT {$column} FROM users as US Where US.id = :id;";

        $results = $this->DB::selectOne($SQL, ['id' => $id]);
        return $results;
    }

    public function DeleteOne($id)
    {
        $results = $this->DB::selectOne("DELETE FROM users Where id = :id;", ['id' => $id]);
        return $results;
    }
}
