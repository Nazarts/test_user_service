<?php

namespace App\Http\Controllers;

use App\Mail\UserRoleChangedMail;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile(Request $request) {
        return view('profile', [
            'user' => $request->user()
        ]);
    }

    public function profile_update(Request $request) {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'password' => 'string|min:8',
            'role_id' => 'integer|exists:user_roles,id',
            'email' => ['string', 'max:255', Rule::unique('users')->ignore($request->user()->id)],
            'user_image' => 'image',
            'description' => 'string'
        ]);

        if (array_key_exists('password', $validatedData)) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        if (array_key_exists('user_image', $validatedData)) {
            $filename = $request->user()->id . '_' . time() . '.' . request()->user_image->getClientOriginalExtension();
            request()->user_image->move(public_path('images'), $filename);
            $validatedData['user_image'] = $filename;
        }

        DB::table('users')->where('id', $request->user()->id)->update($validatedData);

        return redirect('/profile');
    }

    public function create() {
        return view('create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:user_roles,id',
            'email' => 'required|string|unique:users|max:255',
            'password' => ['required', 'string', 'min:8'],
            'user_image' => 'required|image',
            'description' => 'required|string'
        ]);

        $filename = $request->user()->id . '_' . time() . '.' . request()->user_image->getClientOriginalExtension();
        request()->user_image->move(public_path('images'), $filename);
        $validatedData['user_image'] = $filename;

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = new User($validatedData);

        $user->save();

        return redirect('/');
    }

    public function edit(Request $request, $id) {
        $user = DB::table('users')->find($id);
        $roles = DB::table('user_roles')->get();
        if ($user === null) {
            return view('404');
        }
        return view('edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, $id) {
        $user = DB::table('users')->where('id', '=', $id);
        if ($user === null) {
            return view('404');
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'role_id' => 'integer|exists:user_roles,id',
            'email' => ['string', 'max:255', Rule::unique('users')->ignore($id)],
            'user_image' => 'image',
            'description' => 'string'
        ]);

        if (array_key_exists('user_image', $validatedData)) {
            $filename = $request->user()->id . '_' . time() . '.' . request()->user_image->getClientOriginalExtension();
            request()->user_image->move(public_path('images'), $filename);
            $validatedData['user_image'] = $filename;
        }


        if (array_key_exists('role_id', $validatedData)) {
            $validatedData['role_id'] = (int)$validatedData['role_id'];
            if($user->first()->role_id !== 1 && $validatedData['role_id'] === 1) {
                Mail::to($request->email)->send(new UserRoleChangedMail($request->name));
            }
        }

        $user->update($validatedData);

        return redirect('/users/'.$id);
    }

    public function show(int $id) {
        $user = User::all()->find($id);
        if ($user === null) {
            return view('404');
        }
        return view('single', [
            'user' => $user
        ]);
    }

    public function delete($id) {
        $user = DB::table('users')->find($id);
        if ($user !== null)
            DB::table('users')->delete($id);
        else
            return redirect('404');
        return redirect('/');
    }
}
