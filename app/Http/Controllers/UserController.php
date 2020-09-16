<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show($function = 'info')
    {
        return view('pages.profile', compact('function'));
    }

    public function userList()
    {
        try {
            $users = User::query()->orderBy('role')->withCount('courses')->paginate(10);
        } catch (Exception $e) {
            dd($e);
        }

        return view('pages.admin.user', [
            'users' => $users
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);
        try {
            $result = User::query()
                ->where('name', 'like', '%' . $request->input('search') . '%')
                ->withCount('courses')
                ->paginate(10);
        } catch (Exception $e) {
            dd($e);
        }
        return view('pages.admin.user', [
            'users' => $result,
            'search' => $request->input('search')
        ]);
    }

    public function remove(User $user)
    {
        try {
            $user->delete();
            $user->courses()->detach();
        } catch (Exception $e) {
            dd($e);
        }

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old-password' => 'string|required',
            'password' => ['required', 'min:8', 'confirmed']
        ]);


        // Neu mat khau cu nhap dung
        if (Hash::check($request->input('old-password'), Auth::user()->getAuthPassword())) {
            try {
                User::query()->findOrFail(Auth::id())->update([
                    'password' => Hash::make($request->input('password'))
                ]);
            } catch (Exception $e) {
                logger('Password Exception', [
                    'Exception' => $e->getMessage()
                ]);
            }

            return redirect()->route('profile');
        }


        return redirect()->back();
    }

    public function changePasswordAdmin(Request $request, User $user)
    {
        dd($user);
        $request->validate([
            'password' => ['required', 'min:8']
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->input('password'))
            ]);
        } catch (Exception $e) {

        }


        return redirect()->back();
    }

    public function getAll()
    {

    }
}
