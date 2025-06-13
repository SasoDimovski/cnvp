<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\Auth\Dto\AuthLoginDto;
use Modules\Auth\Http\Requests\AuthExpiredRequest;
use Modules\Auth\Http\Requests\AuthForgottenEmailRequest;
use Modules\Auth\Http\Requests\AuthForgottenRequest;
use Modules\Auth\Http\Requests\AuthMfaRequest;
use Modules\Auth\Http\Requests\AuthRegistrationRequest;
use Modules\Auth\Services\AuthServices;
use Modules\Auth\Http\Requests\AuthLoginRequest;

class AuthController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;
    public function __construct(public AuthServices $authServices, private readonly AuthLoginDto $authLoginDto)
    {
    }

    public function login(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('Auth::auth.login');
    }

    public function loginPost(AuthLoginRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        $authLoginDto = $this->authLoginDto->fromRequest($request);
        $return = $this->authServices->loginPost($authLoginDto, $request);
        //$method=$return->method;
        $method=null;
        $class=$return->class;
        //dd($return->data['id_error']);
        if ($return->status == 'error') {
        switch ($return->data['id_error']) {
            case "1":
                return redirect()->route('admin')
                    ->with('error', __('auth.loginPost.throttle', ['minutes' => $return->data['decayMinutes'], 'attempts' => $return->data['maxAttempts']]));
                break;
            case "2":
                return redirect()->route('mfa-code')
                    ->with('warning', __('auth.loginPost.mfa_verification'))
                    ->with('warning', $method);
                break;
            case "3":
                return redirect()->route('admin')
                    ->with('error', __('auth.loginPost.credentials_no'))
                    ->with('warning', $method);
                break;
            case "4":
                return redirect()->route('admin')
                    ->with('error', __('auth.loginPost.user_no_longer_active'))
                    ->with('warning', $method);
            case "5":
                return redirect('expired?hash='.$return->data['hash'])
                    ->with('error', __('auth.loginPost.password_expired'))
                    ->with('warning', $method);
                break;
            case "6":
                return redirect()->route('admin')
                    ->with('error', __('auth.loginPost.unable_to_delete_temp_data'))
                    ->with('warning', $method);
                break;
        }
    }

        if ($return->status == 'success'&&$return->data['logoutOtherDevices']==0) {
            return redirect()->route('main', ['lang' => App::getLocale()])->with('warning', __('auth.login_success'));
        }
        return redirect()->route('main', ['lang' => App::getLocale()])->with('warning', __('auth.login_success_logout_other_devices'));
    }

    public function forgottenEmail(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('Auth::auth.forgotten-email');
    }

    public function forgottenEmailPost(AuthForgottenEmailRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        $return = $this->authServices->forgottenEmailPost($request);
        if ($return->status === 'error') {
            $errors = [
                "1" => __('auth.forgottenEmailPost.error_user_mail'),
                "2" => __('auth.forgottenEmailPost.error_generate_hash'),
                "3" => __('auth.forgottenEmailPost.error_save_hash'),
                "4" => __('auth.forgottenEmailPost.error_send_email'),
                "5" => __('auth.forgottenEmailPost.error_save_email'),
            ];
            $errorMessage = $errors[$return->data['id_error']] ?? __('auth.error_unknown');
            return redirect('/forgotten-email')->with('error', $errorMessage);
        }
        return redirect()->route('admin')->with('success', __('auth.forgottenEmailPost.success_send_email'));
    }

    public function forgotten(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return $this->_handleReset($request, 'forgotten', 'Auth::auth.forgotten');
    }

    public function forgottenPost(AuthForgottenRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        $return = $this->authServices->forgottenPost($request);
        if ($return->status === 'error') {

            $errors = [
                "1" => __('auth.post.error_hash_not_found'),
                "4" => __('auth.post.error_password_used'),
                "5" => __('auth.post.error_password_no_recorded_in_users'),
                "6" => __('auth.post.error_password_no_recorded_in_pass'),
                "7" => __('auth.post.error_send_email'),
                "8" => __('auth.post.error_save_email'),
                "9" => __('auth.post.error_delete_temp_data'),
            ];
            $errorMessage = $errors[$return->data['id_error']] ?? __('auth.unknown_error');


            if (in_array($return->data['id_error'], [7, 8, 9], true)) {
                return redirect()->route('admin')->with('error', $errorMessage);
            }

            return redirect('forgotten?hash=' . $return->data['hash'])->with('error', $errorMessage);
        }

        return redirect()->route('admin')->with('success', __('auth.post.success_password_changed'));
    }

    public function registration(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return $this->_handleReset($request, 'registration', 'Auth::auth.registration');
    }

    public function registrationPost(AuthRegistrationRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        $return = $this->authServices->registrationPost($request);

        if ($return->status === 'error') {
            $errors = [
                "1" => __('auth.post.error_hash_not_found'),
                "5" => __('auth.post.error_password_no_recorded_in_users'),
                "6" => __('auth.post.error_password_no_recorded_in_pass'),
                "7" => __('auth.post.error_send_email'),
                "8" => __('auth.post.error_save_email'),
                "9" => __('auth.post.error_delete_temp_data'),
            ];

            $errorMessage = $errors[$return->data['id_error']] ?? __('auth.post.unknown_error');
            // Check if redirect to a specific route is needed
            if (in_array($return->data['id_error'], [7, 8, 9], true)) {
                return redirect()->route('admin')->with('error', $errorMessage);
            }
            return redirect('registration?hash=' . $return->data['hash'])->with('error', $errorMessage);
        }
        return redirect()->route('admin')->with('success', __('auth.post.success_password_registered'));
    }

    public function expired(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return $this->_handleReset($request, 'expired', 'Auth::auth.expired');
    }

    public function expiredPost(AuthExpiredRequest $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        $return = $this->authServices->expiredPost($request);
        if ($return->status === 'error') {
            $errors = [
                "1" => __('auth.post.error_hash_not_found'), // CHECK IF USER EXIST BY HASH
                "2" => __('auth.post.error_no_pass_in_users'),// CHECK IF OLD PASSWORD EXIST IN TABLE USERS
                "3" => __('auth.post.error_no_pass_in_passwords'),// CHECK IF OLD PASSWORD EXIST IN TABLE PASSWORDS
                "4" => __('auth.post.error_password_used'),// CHECK IF PASSWORD IS USED PREVIOUS (3. MODULE PASSWORD USED)
                "5" => __('auth.post.error_password_no_recorded_in_users'),// STORE NEW PASSWORD IN TABLE USERS
                "6" => __('auth.post.error_password_no_recorded_in_pass'), // STORE NEW PASSWORD IN TABLE PASSWORDS
                "7" => __('auth.post.error_send_email'), // SEND EMAIL
                "8" => __('auth.post.error_save_email'),// ARCHIVE EMAIL (7. MODULE ARCHIVE EMAILS)
                "9" => __('auth.post.error_delete_temp_data'),//DELETE TEMP HASH DATA
            ];
            $errorMessage = $errors[$return->data['id_error']] ?? __('auth.post.unknown_error');
            if (in_array($return->data['id_error'], [7, 8, 9], true)) {
                return redirect()->route('admin')->with('error', $errorMessage);
            }
            return redirect('expired?hash=' . $return->data['hash'])->with('error', $errorMessage);
        }
        return redirect()->route('admin')->with('success', __('auth.post.success_password_changed'));
    }

    public function mfaCode(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $return = $this->authServices->mfaCode();
        if ($return->status == 'error') {
            switch ($return->data['id_error']) {
                case "1":
                    return redirect()->route('admin')->with('error', __('auth.mfaCode.session_expired'));
                case "2":
                    return redirect()->route('admin')->with('error', __('auth.mfaCode.no_hash_in_db'));
            }
        }
        $email=$return->data['email'];
        return view('Auth::auth.mfa-code', compact('email'));
    }

    public function mfaCodePost(): \Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $return = $this->authServices->mfaCodePost();
        if ($return->status == 'error') {
            switch ($return->data['id_error']) {
                case "1":
                    return redirect()->route('admin')->with('error', __('auth.mfaCodePost.session_expired'));
                case "2":
                    return redirect()->route('admin')->with('error', __('auth.mfaCodePost.no_hash_in_db'));
                case "3":
                    return redirect()->route('mfa-code')->with('error', __('auth.mfaCodePost.error_send_email'));
            }
        }
        return redirect('mfa')->with('success', __('auth.mfaCodePost.generate_code_notification'));
    }

    public function mfa(): \Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $return = $this->authServices->mfa();
        if ($return->status == 'error') {
            switch ($return->data['id_error']) {
                case "1":
                case "2":
                    return redirect()->route('admin')->with('error', __('auth.mfa.session_expired'));
                case "3":
                    return redirect()->route('admin')->with('error', __('auth.mfa.no_hash_in_db'));
            }
        }
        return view('Auth::auth.mfa');
    }

    public function mfaPost(AuthMfaRequest $request): RedirectResponse
    {
        $return = $this->authServices->mfaPost($request);
        if ($return->status == 'error') {
            switch ($return->data['id_error']) {
                case "1":
                case "2":
                    return redirect()->route('admin')->with('error', __('auth.mfaPost.session_expired'));
                case "3":
                    return redirect()->route('admin')->with('error', __('auth.mfaPost.no_hash_in_db'));
                case "4":
                    return redirect()->route('mfa')->with('error', __('auth.mfaPost.code_verification_missing'));
                case "5":
                    return redirect()->route('mfa')->with('error', __('auth.mfaPost.code_verification_expire'));
                case "6":
                    return redirect()->route('mfa')->with('error', __('auth.mfaPost.date_not_found_in_table'));
                case "7":
                    return redirect("expired?hash=" . $return->data['hash'])->with('error', __('auth.mfaPost.password_expired'));
            }
        }
        if ($return->status == 'success'&&$return->data['logoutOtherDevices']==0) {
            return redirect()->route('main', ['lang' => App::getLocale()])->with('warning', __('auth.login_success'));
        }
        return redirect()->route('main', ['lang' => App::getLocale()])->with('warning', __('auth.login_success_logout_other_devices'));
    }
    public function logout(Request $request): RedirectResponse
    {
        $return = $this->authServices->logout($request);
        if ($return->status == 'error') {
            return redirect()->route('admin')->with('error', __('auth.logout_error'));
        }
        return redirect()->route('admin')->with('success', __('auth.logout_success'));

    }

    public function _handleReset(Request $request, string $type, string $view): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $hash = $request->query('hash');
        //dd($hash);
        $return = $this->authServices->reset($hash, $type);
        if ($return->status === 'error') {
            $errors = [
                "1" => __('auth.reset.error_no_hash'),
                "2" => __('auth.reset.error_hash_user'),
                "3" => __('auth.reset.error_hash_date'),
                "4" => __('auth.reset.error_expire_hash'),
                "5" => __('auth.reset.error_delete_temp_data'),
                "6" => __('auth.reset.error_wrong_type_reset'),
            ];
            $errorMessage = $errors[$return->data['id_error']] ?? __('auth.error_unknown');
            return redirect()->route('admin')->with('error', $errorMessage);
        }
        $hash = $return->data['hash'];
        return view($view, compact('hash'));
    }
}
