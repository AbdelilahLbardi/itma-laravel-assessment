<?php


namespace App\Http\Controllers\Api;


use App\Http\Resources\UrlResource;
use App\Models\Url;

class UrlsController
{

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

        do {
            $slug = Url::newSlug();
        } while (Url::query()->where('slug', '=', $slug)->exists());

        $data['slug'] = $slug;

        // This will remove data wrapping {data} instead it will expose keys directly
        UrlResource::withoutWrapping();

        return new UrlResource(
            Url::query()->create($data)
        );
    }

}
