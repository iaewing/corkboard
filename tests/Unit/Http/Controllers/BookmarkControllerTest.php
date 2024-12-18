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
