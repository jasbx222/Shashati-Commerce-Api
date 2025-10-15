<?php

namespace App\Http\Controllers\Api\Admin\clients;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\client\ClientRequest;
use App\Http\Service\Admin\clients\ClientService;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * @var ClientService
     */
    private ClientService $client;

    /**
     * ClientController constructor.
     *
     * @param ClientService $client_service
     */
    public function __construct(ClientService $client_service)
    {
        $this->client = $client_service;
    }




    /**
     * عرض قائمة العملاء
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->client->index();
    }

    public function update(ClientRequest $request,Client $client){
        return $this->client->update($request->validated(),$client);
    }



    
    public function store(ClientRequest $request){

        return $this->client->store($request->validated());
    }
    /**
     * عرض بيانات عميل واحد
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function show(Client $client)
    {
        return $this->client->show($client);
    }

    /**
     * حظر عميل من استخدام الحساب
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function block_client(Client $client)
    {
        return $this->client->block_client($client);
    }
    public function getAllOrders(Client $client)
    {
        return $this->client->getAllOrders($client);
    }



    
    public function destroy(Client $client){
        return $this->client->destroy($client);
    }

    
}
