<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostsUpdateTest extends TestCase
{
    /**
     * @group test_update_posts_error_validation
     */
    public function test_update_posts_error_validation()
    {
        $response = $this->json('GET', '/api/posts', []);

        // Assert the response status code
        $response->assertStatus(200);

        if (count($response["data"]["data"]) !== 0) {
            $response = $this->json('POST', '/api/posts/' . $response["data"]["data"][0]["id"], [
                "image" => "haha",
                "title" => "Post 1",
                "content" => "Post 1 Description",
                "_method" => "PUT",
            ]);

            // Assert the response status code
            $response->assertStatus(422);
            $this->assertEquals($response['image'][0], "The image must be an image.");
            $this->assertEquals($response['image'][1], "The image must be a file of type: jpeg, png, jpg, gif, svg.");
        } else {
            $this->assertEquals(
                $response["data"]["data"],
                []
            );
        }
    }

    /**
     * @group test_update_posts
     */
    public function test_update_posts()
    {
        // Mock an image file
        $file = UploadedFile::fake()->image('test_image.jpg');
        $response = $this->json('GET', '/api/posts', []);

        // Assert the response status code
        $response->assertStatus(200);

        if (count($response["data"]["data"]) !== 0) {
            $response = $this->json('POST', '/api/posts/' . $response["data"]["data"][0]["id"], [
                "image" => $file,
                "title" => "Post 1s",
                "content" => "Post 1 Description",
                "_method" => "PUT",
            ]);

            // Assert the response status code
            $response->assertStatus(200);
            $this->assertEquals($response['success'], true);
            $this->assertEquals($response['message'], "Data Post Berhasil Diubah!");
        } else {
            $this->assertEquals(
                $response["data"]["data"],
                []
            );
        }
    }
}
