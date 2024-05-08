<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientOrderRequest;
use App\Interfaces\CrudRepoInterface;
use App\Models\ClientOrder;
use Illuminate\Http\Request;

class ClinetOrderController extends Controller
{
    protected $crudRepoInterface;

    public function __construct(CrudRepoInterface $crudRepoInterface)
    {
        $this->crudRepoInterface = $crudRepoInterface;
    }

    public function addOrder(ClientOrderRequest $request)
    {
        return $this->crudRepoInterface->store($request);
    }

    public function workerOrder()
    {
        return $this->crudRepoInterface->show();
    }

    public function update($id,Request $request)
    {

    }
}
