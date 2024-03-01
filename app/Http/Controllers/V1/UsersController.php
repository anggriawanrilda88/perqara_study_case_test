<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\UsersModel;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Number;

class UsersController extends Controller
{
    public function Create(Request $request): JsonResponse
    {
        // validate request
        $this->validate($request, [
            'address' => 'required|string',
            'age' => 'required|integer',
            'avatar' => 'required|image|max:' . MAX_FILE_UPLOAD,
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string|in:Man,Woman',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $modelUsers = new UsersModel;
        try {
            $req = $request->input();

            if (isset($_FILES['avatar'])) {
                $avatarExtension = str_replace('image/', '.', $_FILES['avatar']['type']);
                $req['avatar'] = Str::random(34) . $avatarExtension;
                $request->file('avatar')->move(storage_path('avatar'), $req['avatar']);
            }

            // hash password
            $req['password'] = password_hash($req['password'], PASSWORD_BCRYPT, ['cost' => 9]);

            $users = $modelUsers->Create($req);
            unset($users->password);
            $modelUsers->DB::commit();
            $response = [
                'data' => $users,
            ];

            return response()->json($response);
        } catch (\Throwable $th) {
            $modelUsers->DB::rollBack();
            throw new Exception($th);
        }
    }

    public function Edit(Request $request, $id): JsonResponse
    {
        // validate request
        $this->validate($request, [
            'email' => 'email',
            'password' => 'string|min:8',
            'first_name' => 'string',
            'last_name' => 'string',
            'phone' => 'string',
            'gender' => 'string|in:Man,Woman',
            'address' => 'string',
            'age' => 'integer',
            'status' => 'string|in:active,inactive',
        ]);

        $modelUsers = new UsersModel;
        try {
            $req = $request->input();

            if (count($req) === 0) {
                throw new Exception("No data updated", Response::HTTP_FORBIDDEN);
            }

            // get user data from token
            $users = $modelUsers->FindOneById($id, '*');

            $set = '';
            $bind = [];

            if (isset($req['username'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} username=:username";
                $bind['username'] = $req['username'];
            }

            if (isset($req['password'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} password=:password";
                $bind['password'] = password_hash($req['password'], PASSWORD_BCRYPT, ['cost' => 9]);
            }

            if (isset($req['first_name'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} first_name=:first_name";
                $bind['first_name'] = $req['first_name'];
            }

            if (isset($req['last_name'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} last_name=:last_name";
                $bind['last_name'] = $req['last_name'];
            }

            if (isset($req['email'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} email=:email";
                $bind['email'] = $req['email'];
            }

            if (isset($req['phone'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} phone=:phone";
                $bind['phone'] = $req['phone'];
            }

            if (isset($req['gender'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} gender=:gender";
                $bind['gender'] = $req['gender'];
            }

            if (isset($req['address'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} address=:address";
                $bind['address'] = $req['address'];
            }

            if (isset($req['age'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} age=:age";
                $bind['age'] = $req['age'];
            }

            if (isset($req['status'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} status=:status";
                $bind['status'] = $req['status'];
            }

            $comma = count($bind) > 0 ? ',' : '';
            $set = "{$set} {$comma} updated_at=:updated_at";
            $bind['updated_at'] = date("Y-m-d h:i:s");

            // bind id user
            $bind['id'] = $id;

            $users = $modelUsers->Edit($bind, $set);

            unset($users->id);
            unset($users->password);

            $response = [
                'data' => $users,
            ];
            return response()->json($response);
        } catch (\Throwable $th) {
            $modelUsers->DB::rollBack();
            throw new Exception($th);
        }
    }

    public function EditAvatar(Request $request, $id): JsonResponse
    {
        // validate request
        $this->validate($request, [
            'avatar' => 'required|image|max:' . MAX_FILE_UPLOAD,
        ]);

        $modelUsers = new UsersModel;
        try {
            // get user data from token
            $users = $modelUsers->FindOneById($id, '*');

            $set = '';
            $bind = [];


            if (isset($_FILES['avatar'])) {
                $comma = count($bind) > 0 ? ',' : '';
                $set = "{$set} {$comma} avatar=:avatar";
                $bind['avatar'] = $_FILES['avatar']['name'];
            }

            // dd($_FILES['avatar']);
            // upload avatar image
            if (isset($_FILES['avatar'])) {
                $avatarExtension = str_replace('image/', '.', $_FILES['avatar']['type']);
                $bind['avatar'] = Str::random(34) . $avatarExtension;
                $request->file('avatar')->move(storage_path('avatar'), $bind['avatar']);

                // jika input avatar terisi upload avatar dan hapus image sebelumnya
                if ($users->avatar !== null) {
                    $currentAvatarPath = storage_path('avatar') . '/' . $users->avatar;
                    if (file_exists($currentAvatarPath)) {
                        unlink($currentAvatarPath);
                    }
                }
            }

            // bind id user
            $bind['id'] = $id;

            $users = $modelUsers->Edit($bind, $set);

            unset($users->id);
            unset($users->password);

            $response = [
                'data' => [
                    "avatar" => $users->avatar
                ],
            ];
            return response()->json($response);
        } catch (\ErrorException $th) {
            $modelUsers->DB::rollBack();
            throw new Exception($th);
        }
    }

    public function List(Request $request): JsonResponse
    {
        // validate request
        $this->validate($request, [
            'limit' => 'required|integer',
            'offset' => 'required|integer',
            'keyword' => 'string',
        ]);

        $modelUsers = new UsersModel;
        try {
            $req = $request->input();

            // setting where untuk sql query
            $where = "where status = 'active'";
            $bind = [];

            if (isset($req['keyword'])) {
                $bind['keyword'] = "%{$req['keyword']}%";
                $where .= " and (";
                $where .= "us.first_name ilike :keyword or ";
                $where .= "us.last_name ilike :keyword or ";
                $where .= "us.email ilike :keyword or ";
                $where .= "us.status ilike :keyword or ";
                $where .= "us.address ilike :keyword or ";
                $where .= "CAST(us.age AS VARCHAR) ilike :keyword or ";
                $where .= "us.gender ilike :keyword or ";
                $where .= "us.phone ilike :keyword or ";
                $where .= "us.created_at::Character Varying = :keyword";
                $where .= ")";
            }

            // mendapatkan total row
            $total = $modelUsers->FindTotal($where, $bind);

            // set bind limit offset
            $bind['limit'] = $req['limit'];
            $bind['offset'] = $req['offset'];

            $users = $modelUsers->Find($where, $bind);
            $response = [
                'limit' => intval($req['limit']),
                'offset' => intval($req['offset']),
                'total' => $total,
                'data' => $users,
            ];
            return response()->json($response);
        } catch (\ErrorException $th) {
            $modelUsers->DB::rollBack();
            throw new Exception($th);
        }
    }

    public function Detail(Request $request, $id): JsonResponse
    {
        $modelUsers = new UsersModel;
        $user = $modelUsers->FindOneById($id);

        $response = [
            'data' => $user,
        ];
        return response()->json($response);
    }

    public function Delete(Request $request, $id): JsonResponse
    {
        $modelUsers = new UsersModel;
        $modelUsers->DeleteOne($id);

        $response = [
            'data' => [
                'message' => "Delete user success",
            ]
        ];
        return response()->json($response);
    }
}
