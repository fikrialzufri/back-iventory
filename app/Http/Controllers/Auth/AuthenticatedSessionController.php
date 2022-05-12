<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user()->id;
        $role = Auth::user()->role;

        $dataRole = [];
        $dataPermission = [];

        foreach ($role as $key => $value) {
            $dataRole[$key] = $value->slug;
            foreach ($value->permissions as $index => $item) {
                $dataPermission[$index] = $item->slug;
            }
        }

        $result = [
            'user' => $user,
            'role' => $dataRole,
            'permissions' => $dataPermission,
        ];

        $message = 'Berhasil login';
        return $this->sendResponse($result, $message, 200);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
