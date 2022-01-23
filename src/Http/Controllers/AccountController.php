<?php

namespace Dealskoo\Affiliate\Http\Controllers;

use Dealskoo\Affiliate\Notifications\EmailChangeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\throwException;

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
            throwException(__('Please upload file'));
        }
        return [];
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
            'password' => ['required', 'min:' . config('affiliate.password_length')],
            'new_password' => ['required', 'min:' . config('affiliate.password_length')],
            'new_password_confirmation' => ['required', 'min:' . config('affiliate.password_length'), 'same:new_password']
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
            $affiliate->password = bcrypt($request->input('new_password'));
            $affiliate->save();
            return back()->with('success', __('affiliate::affiliate.update_success'));
        }
    }
}
