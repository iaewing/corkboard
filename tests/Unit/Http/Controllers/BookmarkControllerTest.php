<?php

use App\Models\Bookmark;
use App\Models\User;

describe('show', function () {
    it('returns a bookmark', function () {
        $bookmark = Bookmark::factory()->create();
        $expected = json_encode($bookmark);
        $response = $this->get(route('bookmark.show', $bookmark->id))
            ->assertSuccessful();

        expect($response->content())->toBeJson($expected);
    });

    it('returns an empty when no matching bookmark found', function () {
        $response = $this->get(route('bookmark.show', '1'))
            ->assertSuccessful();

        expect($response->content())->toBe('[]');
    });
});

describe('index', function () {
    it('returns all bookmarks for a user', function () {
        $user = User::factory()->create();
        $bookmark = Bookmark::factory()->withUser($user)->create();
        $secondBookmark = Bookmark::factory()->withUser($user)->create();
        $bookmarkFromDifferentUser = Bookmark::factory()->withUser(User::factory()->create())->create();

        $response = $this->get(route('bookmark.index', $user->id))
            ->assertSuccessful();

        expect($response->content())->not()->toContain($bookmarkFromDifferentUser)
            ->and($response->content())->toBeJson($secondBookmark)
            ->and($response->content())->toBeJson($bookmark);
    });

    it('returns an empty null json object when no matching bookmark found', function () {
        $response = $this->get(route('bookmark.index', '1'))
            ->assertSuccessful();

        expect($response->content())->toBe('[]');
    });
});
