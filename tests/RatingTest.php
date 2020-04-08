<?php

namespace Kurt\Ratings\Tests;

use Kurt\Rating\Models\Rating;
use Kurt\Rating\Tests\TestCase;
use Kurt\Rating\Tests\Models\Post;
use Kurt\Rating\Tests\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

class RatingTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        \DB::enableQueryLog();
    }

    /** @test */
    public function user_can_rate_rateable_model()
    {
        $user = User::create(['name' => 'test']);
        $post = Post::create(['name' => 'test post']);

        $user->rate($post, 5);

        $this->assertCount(1, $user->ratings);
    }

    /** @test */
    public function it_can_return_rating_value_for_user_for_rateable_model()
    {
        $user = User::create(['name' => 'test']);
        $post = Post::create(['name' => 'test post']);

        $user->rate($post, 5);

        $this->assertEquals(5, $user->getRatingValue($post));
    }

    /** @test */
    public function it_can_update_user_rating_if_already_rated()
    {
        $user = User::create(['name' => 'test']);
        $post = Post::create(['name' => 'test post']);

        $user->rate($post, 5);
        $this->assertEquals(5, $user->getRatingValue($post));

        $user->rate($post, 10);
        $this->assertEquals(10, $user->getRatingValue($post));
    }

    /** @test */
    public function it_can_allow_user_to_rate_different_types()
    {
        $user = User::create(['name' => 'test']);
        $post = Post::create(['name' => 'test post']);

        $user->rate($post, 5, 'type1');
        $this->assertEquals(5, $user->getRatingValue($post, 'type1'));

        $user->rate($post, 10, 'type2');
        $this->assertEquals(10, $user->getRatingValue($post, 'type2'));
    }

    /** @test */
    public function it_can_return_avg_for_rateable_model()
    {
        $user1 = User::create(['name' => 'test1']);
        $user2 = User::create(['name' => 'test2']);
        $post = Post::create(['name' => 'test post']);

        $user1->rate($post, 5);
        $user2->rate($post, 10);

        $this->assertEquals(7.5, $post->ratingsAvg());
    }

    /** @test */
    public function it_can_return_count_for_rateable_model()
    {
        $user = User::create(['name' => 'test']);
        $user2 = User::create(['name' => 'test2']);
        $post = Post::create(['name' => 'test post']);

        $user->rate($post, 5);
        $user2->rate($post, 10);

        $this->assertEquals(2, $post->ratingsCount());
    }


    /** @test */
    public function it_can_work_with_morph_maps()
    {
        Relation::$morphMap = [
            'post' => Post::class,
            'user' => User::class
        ];

        $user = User::create(['name' => 'test']);
        $post = Post::create(['name' => 'test post']);

        $user->rate($post, 5);

        $this->assertEquals(5, $post->ratingsAvg());
    }
}
