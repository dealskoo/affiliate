<?php

namespace Dealskoo\Affiliate\Http\Controllers;

use Dealskoo\Affiliate\Exceptions\AffiliateException;
use Dealskoo\Affiliate\Notifications\EmailChangeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);
        $affiliate = $request->user();
        $affiliate->fill($request->only(['name', 'bio', 'company_name', 'website']));
        $affiliate->save();
        return back()->with('success', __('affiliate::affiliate.update_success'));
    }

    /**
     * @throws AffiliateException
     */
    public function avatar(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:1000']
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $affiliate = $request->user();
            $filename = $affiliate->id . '.' . $image->guessExtension();
            $path = $request->file('file')->storeAs('affiliate/avatars', $filename);
            $affiliate->avatar = $path;
            $affiliate->save();
            return ['url' => Storage::url($path)];
        } else {
            throw new AffiliateException(__('Please upload file'));
        }
    }

    public function email(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'unique:affiliates']]);
        Notification::route('mail', $request->input('email'))->notify(new EmailChangeNotification());
        return back()->withInput($request->only(['email']))->with('success', __('Email Verify Notification Send Success'));
    }

    public function emailVerify(Request $request)
    {
        $email = Session::get('affiliate_email_change_verify');
        if (hash_equals($request->route('hash'), sha1($email))) {
            $affiliate = $request->user();
            $affiliate->email = $email;
            $affiliate->save();
            return redirect()->route('affiliate.account.email')->with('success', __('Email Change Success'));
        } else {
            return redirect()->route('affiliate.account.email')->withErrors([__('Link expired')]);
        }
    }

    public function password(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:' . config('auth.password_length')],
            'new_password' => ['required', 'confirmed', Rules\Password::min(config('auth.password_length'))],
        ]);

        if (!$this->guard()->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            return back()->withErrors([
                'password' => [__('The provided password does not match our records.')]
            ]);
        } else {
            $affiliate = $request->user();
            $affiliate->password = Hash::make($request->input('new_password'));
            $affiliate->save();
            return back()->with('success', __('affiliate::affiliate.update_success'));
        }
    }
}
