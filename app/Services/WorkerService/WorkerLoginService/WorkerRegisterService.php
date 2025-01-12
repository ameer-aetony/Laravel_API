<?php


namespace App\Services\WorkerService\WorkerLoginService;

use App\Models\Worker;
use App\Mail\verificaionEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class WorkerRegisterService
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

    function store($data,$request)
    {

        $worker = $this->model->create(array_merge(
            $data->validated(),
            [
                'password' => bcrypt($request->password),
                'photo' => $request->file('photo')->store('clients'),

                ]
        ));
        return $worker->email;
    }

    function generateToken($email)
    {

        $token = substr(md5(rand(0, 9) . $email . time()), 0, 32);
        $worker = $this->model->whereEmail($email)->first();
        $worker ->verfication_token = $token;
        $worker ->save();

        return $worker;
    }

    function sendEmail($worker)
    {
      return  Mail::to($worker->email)->send(new verificaionEmail($worker));

    }

    function register($request)
    {
        try {
        DB::beginTransaction();
        $data = $this->validation($request);

        $email = $this->store($data,$request);

        $worker = $this->generateToken($email);
        $this->sendEmail($worker);
        Db::commit();
        return response()->json([
            "message" => "account has been created please check your email"
        ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();

        }



    }
}
