<?php

namespace App\Http\Controllers\Api\Client\ReturnRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\returns\ReturnRequest as ReturnRequestStore;
use App\Http\Service\returns\ReturnRequestService;

class ReturnRequestController extends Controller
{

    private $return;

    public function __construct(ReturnRequestService $return)
    {
        $this->return = $return;
    }
    // عرض كل طلبات المرتجع للعميل
    // public function index()
    // {
    //     return $this->return->index();
    // }

    // إنشاء طلب مرتجع جديدذ
    public function store(ReturnRequestStore $request)
    {
        return $this->return->store($request->validated());
    }



    // عرض تفاصيل طلب معين
    // public function show($id)
    // {
    //     return $this->return->show($id);
    // }
}
