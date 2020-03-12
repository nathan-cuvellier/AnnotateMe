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

    static $DURATION_TOKEN = 5;

    public function view()
    {
        if (session()->has('expert'))
            return redirect()->route('project.list');

        return view('account.reset');
    }

    public function post(ResetRequest $request)
    {
        $expert = Expert::query()->where('mail_exp', $request->mail_exp)->first();

        if (!is_null($expert)) {

            PasswordResets::query()->where('id_exp', $expert->id_exp)->delete();

            $passwordResets = PasswordResets::create([
                'id_exp' => $expert->id_exp,
                'token' => $this->random('64'),
                'created_at' => new DateTime()
            ]);

            Mail::send(['mail.reset_password', 'mail.reset_password_text'], ['expert' => $expert, 'passwordResets' => $passwordResets], function ($message) {
                $message->to('nathan@gmail.com')->subject('Password reset - AnnotateMe');
            });
        }

        return redirect()->route('account.reset')->with('success', 'If you have entered a valid email you will receive a message containing a reset password link');
    }

    public function resetView(Request $request)
    {
        if (!$this->hasValidQuery($request))
            return view('account.reset_token', ['error' => $this->getErrorMessage()]);

        $passwordResets = PasswordResets::query()->where('token', $request->k)->where('id_exp', $request->id_exp)->first();
        if(!$this->isValidToken($request))
            return view('account.reset_token', ['error' => $this->getErrorMessage()]);

        return view('account.reset_token');
    }

    public function resetPost(ResetTokenRequest $request)
    {
        if (!$this->hasValidQuery($request))
            return view('account.reset_token', ['error' => $this->getErrorMessage()]);

        if($this->isValidToken($request)) {
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

    public function hasValidQuery(Request $request){
        return !is_null($request->k) && !is_null($request->id_exp);
    }

    public function isValidToken(Request $request) : bool {
        $passwordResets = PasswordResets::query()->where('token', $request->k)->where('id_exp', $request->id_exp)->first();
        return !is_null($passwordResets) && (new DateTime() < (new DateTime($passwordResets->created_at))->modify("+" . self::$DURATION_TOKEN . " minutes"));
    }

    public function getErrorMessage() : String {
        return "The link is expired <a href='". route('account.reset') ."'>try again ?</a>";
    }

    public function random($length)
    {
        $alphanumeric = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle(str_repeat($alphanumeric, $length)), 0, $length);
    }
}
