<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResource;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $manager = Manager::where('email', $request->email)->first();

        if (!$manager || !Hash::check($request->password, $manager->password) || !$manager->is_active) {
            throw ValidationException::withMessages([
                'email' => ['بيانات الاعتماد المقدمة غير صحيحة.'],
            ]);
        }

        $token = $manager->createToken('auth-token')->plainTextToken;

        return response()->json([
            'manager' => new ManagerResource($manager),
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return new ManagerResource($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
