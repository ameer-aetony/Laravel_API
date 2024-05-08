<?php

namespace App\Services\WorkerService\WorkerLoginService;

use App\Models\Worker;
use Illuminate\Support\Facades\Validator;

class WorkerLoginService
{

    protected $model;

    function __construct()
    {
        $this->model = new Worker();
    }


    function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return $validator;
    }

    function isValidate($data)
    {
        if (!$token = auth()->guard('worker')->attempt($data->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
    }

    function isVerified($email)
    {
        $worker = $this->model->whereEmail($email)->first();
        $verified = $worker->verified_at;
        return $verified;
    }

    function getStatus($email)
    {
        $worker = $this->model->whereEmail($email)->first();
        $status = $worker->status;
        return $status;
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('worker')->user()
        ]);
    }

    function Login($request)
    {
        $data = $this->validation($request);
        $token = $this->isValidate($data);
        $status = $this->getStatus($request->email);
        $verified = $this->isVerified($request->email);
        if ($verified == Null) {
            return  response()->json(["message" => "your Account is Not Verified"], 422);
        } else if ($status == 0) {
            return  response()->json(["message" => "your Account is Peniding"], 422);
        }
        return  $this->createNewToken($token);
    }
}
