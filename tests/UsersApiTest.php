<?php

namespace Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersApiTest extends TestCase
{
    public function test_create_users_error_dto()
    {
        $this->json('POST', '/api/v1/users', [
            "address" => " haha",
            "age" => " 20",
            "first_name" => " sdfsd",
            "last_name" => " sdfsdf",
            "gender" => "Man",
            "email" => "anggriawan@gmail.com",
            "phone" => "343434",
            "status" => "active",
        ]);

        // // Assert the response status code
        $this->assertResponseStatus(422);
    }

    public function test_create_users()
    {
        // Mock an image file
        $file = UploadedFile::fake()->image('test_image.jpg');
        $this->post('/api/v1/users', [
            "address" => "haha",
            "avatar" => $file,
            "age" => "20",
            "email" => random_int(99999, 99999999) . "test@gmail.com",
            "first_name" => "sdfsd",
            "last_name" => "sdfsdf",
            "gender" => "Man",
            "password" => "12345678",
            "phone" => "343434d",
            "status" => "active",
        ]);

        // Assert the response status code
        $this->assertResponseStatus(200);

        // Assert response
        $this->assertIsString($this->response["data"]["id"]);
        $this->assertIsString($this->response["data"]["first_name"]);
        $this->assertIsString($this->response["data"]["last_name"]);
        $this->assertIsString($this->response["data"]["phone"]);
        $this->assertIsString($this->response["data"]["email"]);
        $this->assertIsString($this->response["data"]["status"]);
        $this->assertIsString($this->response["data"]["gender"]);
        $this->assertIsString($this->response["data"]["address"]);
        $this->assertIsString($this->response["data"]["created_at"]);
        $this->assertIsString($this->response["data"]["updated_at"]);
        $this->assertIsNotString($this->response["data"]["deleted_at"]);
        $this->assertIsInt($this->response["data"]["age"]);
        $this->assertIsString($this->response["data"]["avatar"]);
    }

    public function test_get_list_users_error()
    {
        $this->json('GET', '/api/v1/users', []);

        // // Assert the response status code
        $this->assertResponseStatus(422);

        $error = ["limit" => ["The limit field is required."], "offset" => ["The offset field is required."]];

        $this->assertEquals(
            json_encode($error),
            $this->response->getContent()
        );
    }

    public function test_get_list_users()
    {
        $test = $this->json('GET', '/api/v1/users?limit=10&offset=0', []);

        // assert status api
        $this->assertResponseStatus(200);

        // assert response
        if (count($this->response["data"]) !== 0) {
            $this->assertIsString($this->response["data"][0]["id"]);
            $this->assertIsString($this->response["data"][0]["first_name"]);
            $this->assertIsString($this->response["data"][0]["last_name"]);
            $this->assertIsString($this->response["data"][0]["phone"]);
            $this->assertIsString($this->response["data"][0]["email"]);
            $this->assertIsString($this->response["data"][0]["status"]);
            $this->assertIsString($this->response["data"][0]["gender"]);
            $this->assertIsString($this->response["data"][0]["address"]);
            $this->assertIsString($this->response["data"][0]["created_at"]);
            $this->assertIsString($this->response["data"][0]["updated_at"]);
            $this->assertIsNotString($this->response["data"][0]["deleted_at"]);
            $this->assertIsInt($this->response["data"][0]["age"]);
            $this->assertIsString($this->response["data"][0]["avatar"]);
        } else {
            $this->assertEquals(
                $this->response["data"],
                []
            );
        }
    }

    /**
     * @group test_get_detail_users
     * Tests the api edit form
     */
    public function test_get_detail_users()
    {
        $this->json('GET', '/api/v1/users?limit=10&offset=0', []);

        // assert status api
        $this->assertResponseStatus(200);

        // assert response
        $userID = "";
        if (count($this->response["data"]) !== 0) {
            $userID = $this->response["data"][0]["id"];
            $this->json('GET', '/api/v1/users/' . $userID, []);

            // assert status api
            $this->assertResponseStatus(200);

            // assert response
            if (isset($this->response["data"])) {
                $this->assertIsString($this->response["data"]["id"]);
                $this->assertIsString($this->response["data"]["first_name"]);
                $this->assertIsString($this->response["data"]["last_name"]);
                $this->assertIsString($this->response["data"]["phone"]);
                $this->assertIsString($this->response["data"]["email"]);
                $this->assertIsString($this->response["data"]["status"]);
                $this->assertIsString($this->response["data"]["gender"]);
                $this->assertIsString($this->response["data"]["address"]);
                $this->assertIsString($this->response["data"]["created_at"]);
                $this->assertIsString($this->response["data"]["updated_at"]);
                $this->assertIsNotString($this->response["data"]["deleted_at"]);
                $this->assertIsInt($this->response["data"]["age"]);
                $this->assertIsString($this->response["data"]["avatar"]);
            } else {
                $this->assertEquals(
                    $this->response["data"],
                    []
                );
            }
        }
    }

    public function test_update_users_error_dto()
    {
        $this->json('GET', '/api/v1/users?limit=10&offset=0', []);

        // assert status api
        $this->assertResponseStatus(200);

        // assert response
        $userID = "";
        if (count($this->response["data"]) !== 0) {
            $userID = $this->response["data"][0]["id"];

            $this->json('PATCH', '/api/v1/users/' . $userID, [
                "address" => " haha",
                "age" => " 20",
                "first_name" => " sdfsd",
                "last_name" => " sdfsdf",
                "gender" => "Laki-laki",
                "email" => "anggriawan@gmail.com",
                "phone" => "343434",
                "status" => "active",
            ]);

            // assert status api
            $this->assertResponseStatus(422);
        }
    }

    /**
     * @group update_success
     * Tests the api edit form
     */
    public function test_update_users_success()
    {
        $this->json('GET', '/api/v1/users?limit=10&offset=0', []);

        // assert status api
        $this->assertResponseStatus(200);

        // assert response
        $userID = "";
        if (count($this->response["data"]) !== 0) {
            $userID = $this->response["data"][0]["id"];
            $firstName = $this->response["data"][0]["first_name"];
            $this->json('PATCH', '/api/v1/users/' . $userID, [
                "first_name" => "anggri",
            ]);

            // assert status api
            $this->assertResponseStatus(200);
        }
    }
}
