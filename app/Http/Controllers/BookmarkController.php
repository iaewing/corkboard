<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function index()
    {
        return json_encode(Bookmark::all());
    }

    public function store()
    {
        $bookmark = Bookmark::create([
            'user_id' => request('userId'),
            'title' => request('title'),
            'url' => request('url'),
            'tags' => json_encode(request('tags')),
        ]);

        return json_encode($bookmark);
    }

    public function show()
    {
        $bookmark = Bookmark::query()->where('id', request('bookmarkId'))->first();
        return json_encode($bookmark);
    }
}
