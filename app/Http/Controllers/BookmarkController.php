<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function show()
    {
        $bookmark = Bookmark::query()->where('id', request('bookmark'))->first();
        return json_encode($bookmark);
    }

    public function index()
    {
        return json_encode(Bookmark::all());
    }

    public function store()
    {
        return Bookmark::query()->create([
            'user_id' => request('user_id'),
            'title' => request('title'),
            'url' => request('url'),
            'tags' => request('tags'),
        ]);
    }

    public function update(Request $request, Bookmark $bookmark)
    {
        $fields = $request->only(['user_id', 'title', 'url', 'tags']);

        $fields = array_filter($fields, fn($value) => !is_null($value));

        return $bookmark->update($fields);
    }
}
