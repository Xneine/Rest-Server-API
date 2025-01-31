<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\HttpCache\ResponseCacheStrategy;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return [
            "message" => 'Anda berhasil Logout'
        ];
    }
    public function me(Request $request){
        $user = Auth::user();
        // $post = Post::where('author', $user->id)->get();
        return response()->json($user);
    }
}
