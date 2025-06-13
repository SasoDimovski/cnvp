<?php

namespace Modules\Auth\Services;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\AuthForgottenMail;
use Modules\Auth\Emails\AuthMfaMail;
use Modules\Auth\Emails\AuthSuccessMail;
use Modules\Auth\Repositories\AuthRepositories;
use Illuminate\Support\Facades\Session;
use Modules\Auth\Services\Responses\ResponseError;
use Modules\Auth\Services\Responses\ResponseSuccess;

class AuthServices
{
    use AuthenticatesUsers, ThrottlesLogins;
    protected string $forgottenLink;
    protected string $registrationLink;
    protected string $expiredLink;
    protected string $passwordResetTypeForgotten;
    protected string $passwordResetTypeExpired;
    protected string $passwordResetTypeRegistration;
    protected string $passwordResetTypeMfa;
    protected string $limitedAttempts;
    protected string $limitedAttemptsMax;
    protected string $limitedAttemptsDecay;
    protected string $passwordMultiFactor;
    protected int $passwordMultiFactorTime;
    protected string $passwordMultiFactorCode;
    protected string $isUserActive;
    protected string $passwordExpired;
    protected string $passwordExpiredMonths;
    protected string $logoutOtherDevices;
    protected string $passwordUsed;
    protected string $archiveEmails;
    protected ?int $archiveEmailsMessage1;
    protected ?int $archiveEmailsMessage3;
    protected ?int $archiveEmailsMessage4;
    protected ?int $archiveEmailsMessage5;
    protected ?string $classPath;

    public function __construct(private readonly AuthRepositories $authRepository)
    {
        $this->forgottenLink = config('auth.forgotten_link');
        $this->registrationLink = config('auth.registration_link');
        $this->expiredLink = config('auth.expired_link');

        $this->passwordResetTypeForgotten = config('auth.password_reset_type.forgotten');
        $this->passwordResetTypeExpired= config('auth.password_reset_type.expired');
        $this->passwordResetTypeRegistration = config('auth.password_reset_type.registration');
        $this->passwordResetTypeMfa = config('auth.password_reset_type.mfa');

        // 1. MODULE LIMITED TIMES OF ATTEMPTS
        $this->limitedAttempts = config('auth.limited_attempts');
        $this->limitedAttemptsMax = config('auth.limited_attempts_parameters.max');
        $this->limitedAttemptsDecay = config('auth.limited_attempts_parameters.decay');

        // 2. MODULE MULTI FACTOR LOGIN
        $this->passwordMultiFactor = config('auth.password_multi_factor');
        $this->passwordMultiFactorTime = config('auth.password_multi_factor_parameters.time');
        $this->passwordMultiFactorCode = config('auth.password_multi_factor_parameters.code');

        // 3. MODULE IS USER ACTIVE
        $this->isUserActive = config('auth.is_user_active');

        // 4. MODULE PASSWORD EXPIRED
        $this->passwordExpired = config('auth.password_expired');
        $this->passwordExpiredMonths = config('auth.password_expired_parameters.months');

        // 5. LOGOUT OTHER DEVICES
        $this->logoutOtherDevices = config('auth.logout_other_devices');

        // 6. MODULE PASSWORD USED
        $this->passwordUsed = config('auth.password_used');

        // 7. MODULE ARCHIVE EMAILS
        $this->archiveEmails = config('auth.archive_emails');
        $this->archiveEmailsMessage1 = config('auth.archive_emails_parameters.message_1');
        $this->archiveEmailsMessage3 = config('auth.archive_emails_parameters.message_3');
        $this->archiveEmailsMessage4 = config('auth.archive_emails_parameters.message_4');
        $this->archiveEmailsMessage5 = config('auth.archive_emails_parameters.message_5');
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';


    }
    public function loginPost($authLoginDto, Request $request):ResponseError|ResponseSuccess
    {
        $methodName = "loginPost(\$authLoginDto, Request \$request)";
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 1. MODULE LIMITED TIMES OF ATTEMPTS
        if ($this->limitedAttempts==1 && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
                return new ResponseError($methodName, $this->classPath,
                    [
                        'id_error'=>'1',
                        'decayMinutes'=>$this->limitedAttemptsDecay,
                        'maxAttempts'=>$this->limitedAttemptsMax
                    ]);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // 2. MODULE MULTI FACTOR LOGIN
        if ($this->passwordMultiFactor == 1) {
            $auth_username = Auth::once(['username' => $authLoginDto->username, 'password' => $authLoginDto->password]);
            $auth_email = Auth::once(['email' => $authLoginDto->username, 'password' => $authLoginDto->password]);

            if ($auth_username || $auth_email) {
                $user = $auth_username
                    ? $this->authRepository->getUserByUsername($authLoginDto->username)
                    : $this->authRepository->getUserByEmail($authLoginDto->username);

                $uniqueHash = md5($user->email . '-' . Carbon::now()->toDateTimeString());
                $this->authRepository->storeNewHash($uniqueHash, $user->id, $this->passwordResetTypeMfa, Carbon::now());

                Session::put('id_user', $user->id);
                Session::put('email', $user->email);
                Session::put('password', $authLoginDto->password);
                Session::put('hash', $uniqueHash);

                return new ResponseError($methodName, $this->classPath, ['id_error'=>'2']);

            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // CHECK IF USER EXIST AND LOGIN USER
        $auth = Auth::attempt(['username' => $authLoginDto->username, 'password' => $authLoginDto->password]) ||
            Auth::attempt(['email' => $authLoginDto->username, 'password' => $authLoginDto->password]);

        if (!$auth) {
            // 1. MODULE LIMITED TIMES OF ATTEMPTS
            if ($this->limitedAttempts==1) {
                $this->incrementLoginAttempts($request);
            }
            ////////////////////////////////////////////////////////////////////////////////////////
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'3']);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // 3. MODULE IS USER ACTIVE
        $user = Auth::user();
        if ($this->archiveEmails==1&&$user->active == 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'4']);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // 4. MODULE PASSWORD EXPIRED
        if ($this->passwordExpired && $uniqueHash=$this->_passExpired($user)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'5','hash'=>$uniqueHash]);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //DELETE TEMP HASH DATA/////////////////////////////////////////////////////
        $deleteTempData= $this->_deleteTempData($user->id);
        if (!$deleteTempData) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'6']);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // 5. MODULE LOGOUT OTHER DEVICES
        if ($this->logoutOtherDevices==1) {
            $this->authRepository->logoutOtherDevices();
             Auth::logoutOtherDevices($authLoginDto->password);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        return new ResponseSuccess($methodName,$this->classPath,['logoutOtherDevices'=>$this->logoutOtherDevices]);
    }

    public function reset($hash, $resetType): ResponseSuccess|ResponseError
    {
        $methodName = "reset(\$hash \$resetType)";
        //CHECK IF THERE IS HASH IN LINK///////////////////////////////////////////////////////////////////////////
        if (!$hash) {
            //error_no_hash
            //admin
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'1']);
        }
        //CHECK IF THERE IS USER WITH ENTERED HASH///////////////////////////////////////////////////////////////////////////
        $user = $this->authRepository->getUserByHash($hash);

        if (!$user) {
            //error_hash_user
            //admin
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'3']);
        }
        //CHECK IF THERE IS RESET HASH DATE
        $password_reset_hash_date = $user->password_reset_hash_date;
        if (!$password_reset_hash_date) {
            //error_hash_date
            //admin
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'4']);
        }
        //CHECK IF DATE EXPIRED
        $password_reset_hash_date = Carbon::parse($password_reset_hash_date);
        $dateNow = Carbon::now();
        $hoursDifference = $password_reset_hash_date->diffInHours($dateNow);

        $link = match ($resetType) {
            'registration' => $this->registrationLink,
            'forgotten' => $this->forgottenLink,
            'expired' => $this->expiredLink,
            default => null,
        };
        if ($hoursDifference > $link) {

            //DELETE TEMP HASH DATA/////////////////////////////////////////////////////
            $deleteTempData= $this->_deleteTempData($user->id);
            if (!$deleteTempData) {
                //error_delete_temp_data
                //admin
                return new ResponseError($methodName, $this->classPath, ['id_error'=>'5']);
            }
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // error_expire_hash
            // admin
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'4']);
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        //CHECK IF TYPE OF RESET IS CORRECT
        $typeTemp = match ($resetType) {
            'registration' => $this->passwordResetTypeRegistration,
            'forgotten' => $this->passwordResetTypeForgotten,
            'expired' => $this->passwordResetTypeExpired,
            default => null,
        };

        $type = $user->password_reset_type ?? '';

        if (!isset($hash) || $type !== $typeTemp) {
            //error_wrong_type_reset
            //admin
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'6']);
        }

        //dd($hash);
        return new ResponseSuccess($methodName, $this->classPath, [ 'hash'=>$hash]);

    }
    public function forgottenEmailPost(Request $request): ResponseSuccess|ResponseError
    {
        $methodName = "forgottenEmailPost(Request \$request)";
        $email=$request->get('email');

        // CHECK IF USER EXIST BY EMAIL ///////////////////////////////////////////////
        $user = $this->authRepository->getUserByEmail($email);
        if (!$user) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'1']);
        }
        // GENERATE HASH ///////////////////////////////////////////////
        $uniqueHash = md5($email . '-' . Carbon::now()->toDateTimeString());
        if (!$uniqueHash) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'2']);
        }
        // STORE HASH ///////////////////////////////////////////////
        $hash = $this->authRepository->storeNewHash($uniqueHash, $user->id, $this->passwordResetTypeForgotten, Carbon::now());
        if (!$hash) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'3']);
        }
        // SEND EMAIL ///////////////////////////////////////////////
        $url = url("/forgotten?hash=$uniqueHash");
        $sendEmail = Mail::to($email)->send(new AuthForgottenMail($url, $user->name, $user->surname, $user->email));
        if (!$sendEmail) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'4']);
        }
        // 7. MODULE ARCHIVE EMAILS  ///////////////////////////////////////////////
        if ($this->archiveEmails == 1) {
            $email_type = $this->authRepository->getEmailType($this->archiveEmailsMessage1) ;
            $save_email = $this->authRepository->saveEmail($user->id, $email_type->id, $email_type->name, $url);
            if (!$save_email) {
                return new ResponseError($methodName, $this->classPath, ['id_error'=>'5']);
            }
        }
        return new ResponseSuccess($methodName, $this->classPath, []);
    }
    public function forgottenPost(Request $request): ResponseSuccess|ResponseError
    {
        return $this->processRequest($request, 'forgotten');
    }
    public function registrationPost(Request $request): ResponseSuccess|ResponseError
    {
        return $this->processRequest($request, 'registration');
    }
    public function expiredPost(Request $request): ResponseSuccess|ResponseError
    {
        return $this->processRequest($request, 'expired');
    }
    private function processRequest(Request $request, string $type): ResponseSuccess|ResponseError
    {
        $hash = $request->get('hash');
        $password = $request->get('password');
        $newPassword = $request->get('new-password');
        $methodName = "processRequest(Request \$request, string \$type)";
        // CHECK IF USER EXIST BY HASH ///////////////////////////////////////////////
        $user = $this->authRepository->getUserByHash($hash);
        if (!$user) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'1','hash'=>$hash]);
        }
        // CHECK IF OLD PASSWORD EXIST IN TABLE USERS //////////////////////////////////////////////////////////////
        if ($type === 'expired' && !Hash::check($password, $user->password)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'2','hash'=>$hash]);
        }
        // CHECK IF OLD PASSWORD EXIST IN TABLE PASSWORDS /////////////////////////////////////////////////////////
        $lastPassword = $this->authRepository->lastPassword($user->id);
        if ($type === 'expired' && !Hash::check($password, $lastPassword->password)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'3','hash'=>$hash]);
        }
        // 3. MODULE PASSWORD USED ///////////////////////////////////////////////
        if ($this->passwordUsed == 1 && in_array($type, ['expired', 'forgotten'])) {
           // dd($this->passwordUsed );
            $previousPasswords = $this->authRepository->previousPasswords($user->id);
            foreach ($previousPasswords as $hashedPassword) {
                if (Hash::check($newPassword, $hashedPassword)) {
                    return new ResponseError($methodName, $this->classPath, ['id_error'=>'4','hash'=>$hash]);
                }
            }
        }
        // STORE NEW PASSWORD IN USERS//////////////////////////////////////////////////////////////////////////////
        if (!$this->authRepository->storePassUsers($hash,Hash::make($newPassword))) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'5','hash'=>$hash]);
        }
        // STORE NEW PASSWORD IN PASSWORDS///////////////////////////////////////////////////////////////////////////
        if (!$this->authRepository->storePassPasswords(Hash::make($newPassword), $user->id)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'6','hash'=>$hash]);
        }
        // SEND EMAIL /////////////////////////////////////////////////////////
        $sendEmail = Mail::to($user->email)->send(new AuthSuccessMail($hash, $user->name, $user->surname, $user->email));
        if (!$sendEmail) {
            //dd($hash);
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'7']);
        }
        // 7. MODULE ARCHIVE EMAILS  /////////////////////////////////////////////
        if ($this->archiveEmails == 1) {
            $message = match ($type) {
                'registration' => $this->archiveEmailsMessage5,
                'forgotten' => $this->archiveEmailsMessage3,
                'expired' => $this->archiveEmailsMessage4,
                default => null};
            $emailType = $this->authRepository->getEmailType($message);
            $saveEmail = $this->authRepository->saveEmail($user->id, $emailType->id, $emailType->name, $newPassword);
            if (!$saveEmail) {
                return new ResponseError($methodName, $this->classPath, ['id_error'=>'8']);
            }
        }
        //DELETE TEMP HASH DATA/////////////////////////////////////////////////////
        if (!$this->_deleteTempData($user->id)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'9']);
        }
        // SUCCESS
        return new ResponseSuccess($methodName, $this->classPath, []);
    }
    public function mfaCode(): ResponseSuccess|ResponseError
    {
        $methodName = "mfaCode()";
        $hash_ses = Session::get('hash');
        if (! isset($hash_ses) ) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'1']);
        }
        $hash_db =  $this->authRepository->getUserByHash($hash_ses);
        if (!isset($hash_db)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'2']);
        }
        return new ResponseSuccess($methodName,$this->classPath,['email'=>Session::get('email')]);
    }
    public function mfaCodePost(): ResponseSuccess|ResponseError
    {
        $methodName = "mfaCodePost()";
        $hash_ses = Session::get('hash');
        if (! isset($hash_ses) ) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'1']);
        }
        $hash_db =  $this->authRepository->getUserByHash($hash_ses);
        if (!isset($hash_db)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'2']);
        }
        $email = Session::get('email');
        $id_user = Session::get('id_user');
        $verificationCode = str_pad(rand(0, pow(10, $this->passwordMultiFactorCode) - 1), $this->passwordMultiFactorCode, '0', STR_PAD_LEFT);
        $verificationCodeExpire = now()->addMinutes($this->passwordMultiFactorTime);
        $this->authRepository->storeVerificationCode($id_user, $verificationCode, $verificationCodeExpire);
        $sendEmail = Mail::to($email)->send(new AuthMfaMail($verificationCode));
        if (!$sendEmail) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'3']);
        }
        Session::put('mfa', $verificationCode);
        return new ResponseSuccess($methodName,$this->classPath,[]);
    }
    public function mfa(): ResponseSuccess|ResponseError
    {
        $methodName = "mfa()";
        $hash_ses = Session::get('hash');
        if (! isset($hash_ses) ) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'1']);
        }
        $hash_mfa = Session::get('mfa');
        if (! isset($hash_mfa) ) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'2']);
        }
        $hash_db =  $this->authRepository->getUserByHash($hash_ses);
        if (!isset($hash_db)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'3']);
        }
        return new ResponseSuccess($methodName,$this->classPath,['email'=>Session::get('email')]);
    }
    public function mfaPost($request): ResponseSuccess|ResponseError
    {
        $methodName = "mfaPost(\$request)";
        $hash_ses = Session::get('hash');
        if (!isset($hash_ses)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'1']);
        }
        $hash_mfa = Session::get('mfa');
        if (!isset($hash_mfa)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'2']);
        }
        $hash_db = $this->authRepository->getUserByHash($hash_ses);
        if (!isset($hash_db)) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'3']);
        }
        $mfa_code = $request->get('mfa_code');
        $user = $this->authRepository->getUserByHashVerificationCode($hash_ses, $mfa_code);
        if (!$user) {
            $this->incrementLoginAttempts($request);
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'4']);
        }

        //CHECK IF CODE IS EXPIRED/////////////////////////////////////////////////////////////////
        $verification_code_expire_date = $this->authRepository->getUserByEmail($user->email)->verification_code_expire;
        $verification_code_expire_date = Carbon::parse($verification_code_expire_date);
        $dateNow = Carbon::now();
        $minutesDifference = $verification_code_expire_date->diffInMinutes($dateNow);
        if ($minutesDifference > $this->passwordMultiFactorTime) {
            return new ResponseError($methodName, $this->classPath, ['id_error'=>'5']);
        }
        ////////////////////////////////////////////////////////////////////////////////////////
        Auth::login($user);

       // dd($this->_passExpired($user));
        // 4. MODULE PASSWORD EXPIRED ///////////////////////////////////////////////
        if ($this->passwordExpired == 1) {
            $uniqueHash = $this->_passExpired($user);
            if ($uniqueHash === 'error') {
                return new ResponseError($methodName, $this->classPath, ['id_error' => '6']);
            }
            if ($uniqueHash !== null) {
                return new ResponseError($methodName, $this->classPath, ['id_error' => '7', 'hash' => $uniqueHash]);
            }
        }
        ////////////////////////////////////////////////////////////////////////

        //DELETE TEMP HASH DATA
        $this->_deleteTempData(Auth::id());


        // 5. MODULE LOGOUT OTHER DEVICES
        if ($this->logoutOtherDevices==1) {
            $this->authRepository->logoutOtherDevices();
            Auth::logoutOtherDevices(Session::get('password'));
        }

        Session::forget('password');
        Session::forget('hash');
        Session::forget('id_user');
        Session::forget('email');
        Session::forget('mfa');

        return new ResponseSuccess($methodName,$this->classPath,['logoutOtherDevices'=>$this->logoutOtherDevices]);
    }
    public function logout(Request $request): ResponseSuccess
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return new ResponseSuccess('','',[]);
    }
    public function _passExpired($user): ?string
    {
        $lastPassword = $this->authRepository->lastPassword($user->id);
        if (!$lastPassword) {
            return 'error';
        }

        $lastPasswordDate = $this->authRepository->lastPassword($user->id)->created_at;
        $expiredPeriod = $this->authRepository->expiredPeriod($user->id)->value ?? $this->passwordExpiredMonths;
        $dateNow = Carbon::now();
        $monthDifference = $lastPasswordDate->diffInMonths($dateNow);
        if ($monthDifference > $expiredPeriod) {
            $uniqueHash = md5($user->email . '-' . now());
            $this->authRepository->storeNewHash($uniqueHash, $user->id, $this->passwordResetTypeExpired, now());
            Auth::logout();
            return $uniqueHash;
        }
        return null;
    }
    public function _deleteTempData($user): bool
    {
        $deleteHash=$this->authRepository->deleteHash($user);
        $deleteVerificationCode=$this->authRepository->deleteVerificationCode($user);
        if (!$deleteHash&&!$deleteVerificationCode) {
            return false;
        }
        return true;
    }
}
