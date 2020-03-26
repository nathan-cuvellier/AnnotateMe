<?php

namespace App\Http\Controllers\Account;

use App\Expert;
use App\PasswordResets;
use App\Http\Requests\Account\ResetRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ResetTokenRequest;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetController extends Controller
{

    /**
     * @var int Time in minute of validate token
     */
    static $DURATION_TOKEN = 5;

    /**
     * Show the form for put email
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view()
    {
        // redirect the user if it already connected
        if (session()->has('expert'))
            return redirect()->route('project.list');

        return view('account.reset');
    }

    /**
     * When user write a email in the input
     *
     * @param ResetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(ResetRequest $request)
    {
        if(session()->has('expert'))
            return redirect()->route('project.list');

        $expert = Expert::query()->where('mail_exp', $request->mail_exp)->first();

        if (!is_null($expert)) {

            // delete token if it already exist, in order to have only one by account
            PasswordResets::query()->where('id_exp', $expert->id_exp)->delete();

            $passwordResets = PasswordResets::create([
                'id_exp' => $expert->id_exp,
                'token' => $this->random('64'),
                'created_at' => new DateTime()
            ]);

            Mail::send(['mail.reset_password', 'mail.reset_password_text'], ['expert' => $expert, 'passwordResets' => $passwordResets, 'DURATION_TOKEN' => self::$DURATION_TOKEN], function ($message) use ($expert){
                $message->to($expert->mail_exp)->subject('Password reset - AnnotateMe');
            });
        }

        return redirect()->route('account.reset')->with('success', 'If you have entered a valid email you will receive a message containing a reset password link');
    }

    /**
     * Show the form for reset password if the query and the token is valid
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetView(Request $request)
    {
        if(session()->has('expert'))
            return redirect()->route('project.list');

        if (!$this->hasValidQuery($request))
            return view('account.reset_token', ['error' => $this->getErrorMessage()]);

        $passwordResets = PasswordResets::query()->where('token', $request->k)->where('id_exp', $request->id_exp)->first();
        if (!$this->isValidToken($request))
            return view('account.reset_token', ['error' => $this->getErrorMessage()]);

        return view('account.reset_token');
    }

    /**
     * Function use when the user click for update his password
     *
     * @param ResetTokenRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function resetPost(ResetTokenRequest $request)
    {
        if(session()->has('expert'))
            return redirect()->route('project.list');

        if (!$this->hasValidQuery($request))
            return view('account.reset_token', ['error' => $this->getErrorMessage()]);

        if ($this->isValidToken($request)) {
            $expert = Expert::findOrFail($request->id_exp);
            $expert->update(['pwd_exp' => Hash::make($request->pwd_exp)]);
            PasswordResets::query()
                ->where('token', $request->k)
                ->where('id_exp', $request->id_exp)
                ->delete();

            return redirect()->route('auth.login')->with('success', 'Your password has been updated');
        } else {
            return view('account.reset_token');
        }

        return view('account.reset_token');
    }

    /**
     * Check if the token and the id of expert is in URL
     *
     * @param Request $request
     * @return bool
     */
    public function hasValidQuery(Request $request): bool
    {
        return !is_null($request->k) && !is_null($request->id_exp);
    }

    /**
     * Check if the token in the url matches that in the database
     * And if the token is not expired
     *
     * @param Request $request
     * @return bool
     */
    public function isValidToken(Request $request): bool
    {
        $passwordResets = PasswordResets::query()->where('token', $request->k)->where('id_exp', $request->id_exp)->first();
        return !is_null($passwordResets) && (new DateTime() < (new DateTime($passwordResets->created_at))->modify("+" . self::$DURATION_TOKEN . " minutes"));
    }

    /**
     * @return String
     */
    public function getErrorMessage(): String
    {
        return "The link is expired <a href='" . route('account.reset') . "'>try again ?</a>";
    }


    /**
     * return a random String, use for create token
     *
     * @param $length
     * @return string
     */
    public function random($length): string
    {
        $alphanumeric = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle(str_repeat($alphanumeric, $length)), 0, $length);
    }
}
