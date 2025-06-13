<?php

namespace Modules\User\Repositories;

use App\Models\Countries;
use App\Models\ExpirationTime;
use App\Models\Passwords;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Modules\User\Dto\UserDto;

class UserRepositories
{
    public function updateUser($id, UserDto $data, $picture_name)
    {
        $user = Users::where('id', '=', $id)->first();

        if($user) {
            $user->name = $data->name;
            $user->surname = $data->surname;
            $user->username = $data->username;
            $user->email = $data->email;
            $user->address = $data->address;
           // $user->id_country = $data->id_country;
            $user->phone = $data->phone;
            $user->picture = $picture_name;
            $user->id_expiration_time = $data->id_expiration_time;
            $user->user_type = $data->user_type;
            if(isset($data->password)) {
                $user->password = Hash::make($data->password);
            }
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
    public function getUserById($id)
    {
        $user = Users::where('id', '=', $id)->first();
        if($user) {
            return $user;
        }
        return null;
    }
    public function storePasswordUsers($id,$password)
    {
        $user = $this->getUserById($id);
        if($user) {
            $user->password =$password;
            return $user->save();
        }
        return null;
    }
    public function storePasswordPasswords($id, $password)
    {
        if (isset($password) && isset($id)) {
            $user = $this->getUserById($id);
            if ($user) {
                $password = Passwords::create([
                    'id_user' => $id,
                    'password' => $password]);
                if ($password) {
                    return $password;
                }
                return null;
            }
            return null;
        }
        return null;
    }
    public function previousPasswords($id_user)
    {
        $previousPasswords = Passwords::where('id_user', $id_user)->pluck('password');
        if ($previousPasswords) {
            return $previousPasswords;
        }
        return null;
    }
    public function getAllCountries()
    {
        $countries = Countries::where('active', '=', '1')->get();;
        if ($countries) {
            return $countries;
        }
        return null;
    }
    public function getAllExpirationTime()
    {
        $expirationTime = ExpirationTime::where('active', '=', '1')->get();;
        if ($expirationTime) {
            return $expirationTime;
        }
        return null;
    }
    public function getAssignCountries($id_user)
    {
        $user = Users::find($id_user);
        if (!$user) {
            return null;
        }
        return $user->countries;
    }
    public function updateCountries($id_user, $countries)
    {
        $user = $this->getUserById($id_user);
        if (!$user) {
            return null;
        }
        $user->countries()->sync($countries);
        return $user;
    }
}
