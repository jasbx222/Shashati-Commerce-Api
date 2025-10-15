<?php


namespace App\Http\Service\Admin\clients;

use App\Http\Resources\Admin\clients\ClientOredersResource;
use App\Http\Resources\Admin\clients\ClientResource;
use App\Models\Client;

class ClientService
{


    public function  index()
    {
        $clients = Client::with(['favorites', 'orders'])->paginate(15);
        return response()->json([
            'client' => ClientResource::collection($clients),
            'meta' => [
                'current_page' => $clients->currentPage(),
                'last_page' => $clients->lastPage(),
                'per_page' => $clients->perPage(),
                'total' => $clients->total(),
            ]
        ]);
    }

    public function show($client)
    {
        return new ClientResource($client);
    }


public function block_client( $client)
{
    $client->update(['is_active' => !$client->is_active]);

    return response()->json([
        'message' => 'تم تعديل حالة الحساب بنجاح',
         'is_active' => $client->is_active, 
    ]);
}




public function getAllOrders( $client)
{
    // استدعاء الطلبات المرتبطة بالعميل
    $orders = $client->orders()->where('status','completed')->get();

    return  ClientOredersResource::collection($orders);
}




public function store(array $data){
    $data['user_id']=auth()->user()->id;
    Client::create($data);
     return response()->json([
        'message' => 'تم اضافة  الحساب بنجاح',
    ]);
}




public function update(array $data, $client){

$data['user_id']=auth()->user()->id;
    if(!$client){
        return failedResponse('هذا العميل غير موجود');
    }

    $client->update($data);

    return response()->json([
        'message'=>'updated successfully'
    ]);

}


public function destroy($client){


    $client->delete();
  return response()->json([
        'message'=>'deleted successfully'
    ]);
}
}