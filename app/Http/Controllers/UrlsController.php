<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UrlsController
{
    public function index()
    {
        /** @var User $user */
        $user = request()->user();

        $urls = $user->urls()
            ->select('id', 'user_id', 'destination', 'slug', 'views', 'created_at', 'updated_at')
            ->orderByDesc('id')
            ->get();

        // FIXME: add support for pagination

        return view('url.list')->with(compact('urls'));
    }

    public function create()
    {
        return view('url.create');
    }

    public function store()
    {
        $data = request()->validate([
            'destination' => [
                'required',
                'url',
                /*
                 * Adding this rule to avoid potential malicious code.
                 */
                function ($attribute, $value, $fail) {
                    if (str_starts_with($value, config('app.url'))) {
                        $fail('You cannot use our URL as destination.');
                    }
                },
            ]
        ]);

        /** @var User $user */
        $user = request()->user();

        $user->urls()
            ->where('destination', '=', $data['destination'])
            ->firstOr(function () use ($user, $data) {
                do {
                    $slug = Url::newSlug();
                } while (Url::query()->where('slug', '=', $slug)->exists());

                $data['slug'] = $slug;

                return $user->urls()->create($data);
            });

        return redirect()->route('urls.index');
    }

    public function show(Url $url)
    {
        /*
         * As the majority of tools we will be working are for internal usage
         * We don't want to mix internal visit with real users visits.
         */

        if (request('type') !== 'internal') {
            $url->update([
                'views' => DB::raw('views + 1')
            ]);
        }

        return redirect()->to($url->destination);
    }

    public function destroy($slug)
    {
        /** @var User $user */
        $user = request()->user();

        $user->urls()->where('slug', '=', $slug)->delete();

        return redirect()->back();
    }
}
