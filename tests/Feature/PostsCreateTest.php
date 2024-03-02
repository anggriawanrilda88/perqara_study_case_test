<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostsCreateTest extends TestCase
{
    public function test_create_posts_error_validation()
    {
        $response = $this->json('POST', '/api/posts', [
            "image" => "wrong image",
            "title" => "Post 1",
            "content" => "Post 1 Description",
        ]);

        // Assert the response status code
        $response->assertStatus(422);
        $this->assertEquals($response['image'][0], "The image must be an image.");
        $this->assertEquals($response['image'][1], "The image must be a file of type: jpeg, png, jpg, gif, svg.");
    }

    public function test_create_posts_error_dto()
    {
        // Mock an image file
        $file = UploadedFile::fake()->image('test_image.jpg');
        $response = $this->json('POST', '/api/posts', [
            "image" => $file,
            "title" => "Post 1",
            "content" => "Post 1 Description",
        ]);

        // Assert the response status code
        $response->assertStatus(201);
        $this->assertEquals($response['success'], true);
        $this->assertEquals($response['message'], "Data Post Berhasil Ditambahkan!");
    }
}
