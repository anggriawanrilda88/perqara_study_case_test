<?php

namespace Tests\Feature;

use Tests\TestCase;

class PostsListTest extends TestCase
{
    /**
     * @group test_get_list_post
     */
    public function test_get_list_post()
    {
        $response = $this->json('GET', '/api/posts', []);

        // Assert the response status code
        $response->assertStatus(200);

        if (count($response["data"]["data"]) !== 0) {
            $this->assertIsInt($response["data"]["data"][0]["id"]);
            $this->assertIsString($response["data"]["data"][0]["image"]);
            $this->assertIsString($response["data"]["data"][0]["title"]);
            $this->assertIsString($response["data"]["data"][0]["content"]);
        } else {
            $this->assertEquals(
                $response["data"]["data"],
                []
            );
        }
    }
}
