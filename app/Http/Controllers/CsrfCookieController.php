<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsrfCookieController extends Controller
{
    public function show(Request $request)
    {
        \Log::info('-1 show.CsrfCookieController ::' . print_r(-1, true));

        if ($request->expectsJson()) {
            \Log::info('-2 show.CsrfCookieController ::' . print_r(-2, true));
            return new JsonResponse(null, 204);
        }
        \Log::info('-3 show.CsrfCookieController ::' . print_r(-3, true));

        return new Response('', 204);
    }
}
