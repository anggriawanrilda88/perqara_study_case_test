<?php

namespace Tests\Feature;

use Tests\TestCase;

class PostsDeleteTest extends TestCase
{
    /**
     * @group test_delete_post_not_found
     */
    public function test_delete_post_not_found()
    {
        $response = $this->json('DELETE', '/api/posts/10000', []);

        // Assert the response status code
        $response->assertStatus(404);
    }

    /**
     * @group test_delete_post
     */
    public function test_delete_post()
    {
        $response = $this->json('GET', '/api/posts', []);

        // Assert the response status code
        $response->assertStatus(200);

        if (count($response["data"]["data"]) !== 0) {
            $response = $this->json('DELETE', '/api/posts/' . $response["data"]["data"][0]["id"], []);

            // Assert the response status code
            $response->assertStatus(200);
        } else {
            $this->assertEquals(
                $response["data"]["data"],
                []
            );
        }
    }

    // /**
    //  * @group test_get_detail_post
    //  */
    // public function test_get_detail_post()
    // {
    //     $response = $this->json('GET', '/api/posts', []);

    //     // Assert the response status code
    //     $response->assertStatus(200);

    //     if (count($response["data"]["data"]) !== 0) {
    //         $response = $this->json('GET', '/api/posts/' . $response["data"]["data"][0]["id"], []);

    //         // Assert the response status code
    //         $response->assertStatus(200);

    //         if (count($response["data"]["data"]) !== 0) {
    //             $this->assertIsInt($response["data"]["id"]);
    //             $this->assertIsString($response["data"]["image"]);
    //             $this->assertIsString($response["data"]["title"]);
    //             $this->assertIsString($response["data"]["content"]);
    //         } else {
    //             $this->assertEquals(
    //                 $response["data"]["data"],
    //                 []
    //             );
    //         }
    //     } else {
    //         $this->assertEquals(
    //             $response["data"]["data"],
    //             []
    //         );
    //     }
    // }
}
