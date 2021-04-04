<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Notifications\EmailChangedUserNotification;
use Illuminate\Http\Request;

class UserController extends CRUDController
{
    public function __construct()
    {
        $this->model = User::class;
        $this->essense = 'users';
        $this->td = ['id','name','email','email_verified_at','created_at'];
        $this->th = ['ID','Name','Email','Verified at','Registred At'];
        $this->oneText = 'User';
    }

    public function edit($id)
    {
        $user = $this->model::findOrFail($id);
        return view('admin.edit.'.$this->essense, [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->myValidate($request);

        $user = User::findOrFail($id);

        $verify = false;

        $data = $request->only('name');

        if ($request->password != false) {
            $data['password'] = $request->password;
        }
        if ($request->email !== $user->email) {
            $data['email'] = $request->email;
            $verify = null;
            $user->notify(new EmailChangedUserNotification($user));
        }

        if ($request->verify == "1") {
            $verify = now();
        }

        $user->update($data);

        if ($verify !== false) {
            $user->email_verified_at = $verify;
            $user->save();
            if ($verify === null) {
                $user->sendEmailVerificationNotification();
            }
        }
        return redirect()->back()->with('message',$this->oneText . ' has been updated successfully!');
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
    }
}
