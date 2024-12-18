<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;

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

    public function update()
    {
        return Bookmark::query()->update([
            'user_id' => request('user_id'),
            'title' => request('title'),
            'url' => request('url'),
            'tags' => request('tags'),
        ]);
    }
}
