<?php

namespace Modules\Auth\Repositories;

use App\Models\EmailType;
use App\Models\LogsEmail;
use App\Models\Passwords;
use App\Models\Users;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthRepositories
{
    public function getUserById($id_user)
    {
        return  Users::where(['id' => $id_user])->first();
    }
    public function getUserByEmail($email)
    {
        return Users::where('email', '=', $email)->first();
    }
    public function getUserByHash($hash)
    {
        return  Users::where(['password_reset_hash' => $hash])->first();
    }
    public function getUserByUsername($username)
    {
        return Users::where('username', '=', $username)->first();
    }
    public function getUserByHashVerificationCode($hash, $mfa_code)
    {
        return   Users::where('password_reset_hash', '=', $hash)
            ->where('verification_code', '=', $mfa_code)
            ->first();
    }
    public function getEmailType($id)
    {
        return EmailType::where('id', '=', $id)->first();
    }
    public function storePassUsers($hash,$newPassword)
    {
        $user = $this->getUserByHash($hash);
        if($user) {
            $user->password =$newPassword;
            return $user->save();
        }
        return null;
    }
    public function storePassPasswords($password,$id_user)
    {
        if (isset($password)&&isset($id_user)) {
            return Passwords::create([
                'id_user' => $id_user,
                'password' => $password]);
        }
        return null;
    }
    public function storeNewHash($hash,$id_user,$type, $date)
    {
        $user = $this->getUserById($id_user);
        if($user) {
            $user->password_reset_hash =$hash;
            $user->password_reset_type =$type;
            $user->password_reset_hash_date =$date;
            return $user->save();
        }
        return null;
    }
    public function saveEmail($id_user,$id_email_type, $email_type, $content)
    {
        $logs_email=LogsEmail::insert([
            'id_user' => $id_user,
            'id_email_type' => $id_email_type,
            'email_type' => $email_type,
            'content' => $content,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]);
        if($logs_email)
        {
            return $logs_email;
        }
        return null;
    }
    public function storeVerificationCode($id_user, $verificationCode,$verificationCodeExpire)
    {
        $user = $this->getUserById($id_user);
        if($user) {
            $user->verification_code =$verificationCode;
            $user->verification_code_expire =$verificationCodeExpire;
            return $user->save();
        }
        return null;
    }

    public function previousPasswords($id_user)
    {
        return Passwords::where('id_user', $id_user)->pluck('password');

    }
    public function lastPassword($id_user)
    {
       return Passwords::where('id_user', '=', $id_user)->orderBy('id', 'desc')->first();

    }
//////////////////////////////////////////////////////////////////////////////////////////////////
    public function expiredPeriod($id_user)
    {
        return Users::where('users.id', '=', $id_user)
            ->leftJoin('_expiration_time', '_expiration_time.id', '=', 'users.id_expiration_time')
            ->select(['_expiration_time.value AS value'])
            ->first();

    }
    public function deleteHash($id_user): bool
    {
        $user = $this->getUserById($id_user);

        if (!$user) {return false;}

        $user->password_reset_hash = null;
        $user->password_reset_type= null;
        $user->password_reset_hash_date = null;

        if (!$user->save()) {return false;}

        return true;
    }

    public function deleteVerificationCode($id_user): bool
    {
        $user = $this->getUserById($id_user);

        if (!$user) {return false;}

        $user->verification_code = null;
        $user->verification_code_expire = null;

        if (!$user->save()) {return false;}

        return true;
    }
    public function logoutOtherDevices(): void
    {
        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', Session::getId())  // Зачувај ја тековната сесија
            ->delete();
    }
}
