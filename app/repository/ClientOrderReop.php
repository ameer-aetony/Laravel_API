<?php

use App\Models\ClientOrder;
use App\Interfaces\CrudRepoInterface;

class ClientOrderReop implements CrudRepoInterface
{
    public function store($request)
    {
        $clientId = auth()->guard('client')->id();
        if (ClientOrder::where('client_id', $clientId)->where('post_id', $request->post_id)->exists()) {
            return response()->json([
                'message' => 'dublicate order request'
            ], 406);
        }

        $data = $request->all();
        $data['client_id'] = auth()->guard('client')->id();
        $order = ClientOrder::create($data);
        return response()->json([
            'message' => 'success'
        ]);
    }


    public function show()
    {
        $orders = ClientOrder::with('post', 'client')->whereStatus('pending')->whereHas('post', function ($quary) {
            $quary->where('worker_id', auth()->guard('worker')->id());
        })->get();

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function update($id, $request)
    {
        $order = ClientOrder::findOrFail($id);
        $order->setAttribute('status', $request->status)->save();
        return response()->json([
            'message' => 'updated'
        ]);
    }
}
