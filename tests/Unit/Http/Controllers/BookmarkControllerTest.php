<?php

use App\Models\Bookmark;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

describe('show', function () {
    beforeEach(function () {
        Sanctum::actingAs(User::factory()->create());
    });

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
    beforeEach(function () {
        Sanctum::actingAs(User::factory()->create());
    });

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

describe('store', function () {
    beforeEach(function () {
        Sanctum::actingAs(User::factory()->create());
    });

    it('creates a bookmark for a user', function () {
        $user = User::factory()->create();
        $title = fake()->sentence();
        $url = fake()->url();

        $expected = [
            'user_id' => $user->id,
            'title' => $title,
            'url' => $url,
            'tags' => null,
        ];

        $response = $this->post(route('bookmark.store', [
            'user_id' => $user->id,
            'title' => $title,
            'url' => $url,
        ]))
            ->assertSuccessful();

        $this->assertDatabaseCount(Bookmark::class, 1);
        $this->assertDatabaseHas(Bookmark::class, [
            'user_id' => $user->id,
            'title' => $title,
            'url' => $url,
        ]);
        expect($response->json())->toMatchArray($expected);
    });

    it('creates a bookmark with tags for a user', function () {
        $user = User::factory()->create();
        $title = fake()->sentence();
        $url = fake()->url();
        $tags = 'lactose intolerance, pineapples, van halen';

        $expected = [
            'user_id' => $user->id,
            'title' => $title,
            'url' => $url,
            'tags' => $tags,
        ];

        $response = $this->post(route('bookmark.store', [
            'user_id' => $user->id,
            'title' => $title,
            'url' => $url,
            'tags' => $tags,
        ]))
            ->assertSuccessful();

        $this->assertDatabaseCount(Bookmark::class, 1);
        $this->assertDatabaseHas(Bookmark::class, [
            'user_id' => $user->id,
            'title' => $title,
            'url' => $url,
            'tags' => $tags
        ]);
        expect($response->json())->toMatchArray($expected);
    });


    it('returns an empty null json object when no matching bookmark found', function () {
        $response = $this->get(route('bookmark.index', '1'))
            ->assertSuccessful();

        expect($response->content())->toBe('[]');
    });
});

describe('update', function () {
    beforeEach(function () {
        Sanctum::actingAs(User::factory()->create());
    });

    it('updates an existing bookmark for a user', function () {
        $user = User::factory()->create();
        $bookmark = Bookmark::factory()->withUser($user)->create();

        $newTag = 'diarrhea relief';
        $newTitle = 'No more constipation';

        $expected = [
            'user_id' => $user->id,
            'title' => $newTitle,
            'url' => $bookmark->url,
            'tags' => $newTag,
        ];

        $this->put(route('bookmark.update', $bookmark), [
            'title' => $newTitle,
            'tags' => $newTag
        ])
            ->assertSuccessful();

        $this->assertDatabaseCount(Bookmark::class, 1);
        $this->assertDatabaseHas(Bookmark::class, $expected);
    });

    it('returns an empty null json object when no matching bookmark found', function () {
        $response = $this->get(route('bookmark.index', '1'))
            ->assertSuccessful();

        expect($response->content())->toBe('[]');
    })->skip();
});
