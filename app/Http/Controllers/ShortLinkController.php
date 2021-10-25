<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShortLinkController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $links = Cache::remember('links' . $page, 60, function () {
            return ShortLink::query()->withCount('history')->paginate();
        });

        return view('shortlink.create', compact('links'));
    }

    public function store(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $inputs = $this->validate($request, [
            'link' => ['required', 'string', 'min:1', 'max:255', 'regex:' . $regex, Rule::unique(ShortLink::class, 'link')]
        ]);
        $code = $this->generateRandomCode();
        ShortLink::create([
            'link' => $inputs['link'],
            'code' => $code,
        ]);
        Cache::forget('links');
        ShortLink::forgetCaches('links');
        return redirect()->route('home');
    }

    public function view($code)
    {
        $link = Cache::remember('code_' . $code, 60, function () use ($code) {
            return ShortLink::where('code', $code)->first();
        });

        return redirect()->away($link->link,301);

        /*$history = Cache::remember('code_history' . $code, 60, function () use ($link) {
            return $link->history()->paginate();
        });
        return view('shortlink.history', compact('history', 'code'));*/
    }

    public function generateRandomCode()
    {
        do {
            $randomString = strtolower(str_random(5));
            $code = ShortLink::where('code', $randomString)->first();
        } while (!empty($code));
        return $randomString;
    }
}
