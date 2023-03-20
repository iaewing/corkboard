<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark as BookmarkModel;

class Bookmark extends Controller
{
    public function index()
    {
        return json_encode(\App\Models\Bookmark::all());
    }

    public function store()
    {
        $bookmark = \App\Models\Bookmark::create([
            'user_id' => request('userId'),
            'title' => request('title'),
            'url' => request('url'),
            'tags' => json_encode(request('tags')),
        ]);

        return json_encode($bookmark);
    }

    public function show()
    {
        $bookmark = BookmarkModel::query()->where('id', request('bookmarkId'))->first();
        return json_encode($bookmark);
    }
}
