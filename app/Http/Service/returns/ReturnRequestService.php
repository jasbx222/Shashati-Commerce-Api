<?php
namespace App\Http\Service\returns;
use App\Models\ReturnRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class ReturnRequestService
{
    

    // إنشاء طلب مرتجع جديد
  public function store(array $data)
{
    $user = Auth::user();
    // إضافة client_id إلى البيانات
    $data['client_id'] = $user->id;

    // إنشاء طلب المرتجع
    $returnRequest = ReturnRequest::create($data);

    // معالجة العناصر المرتجعة
    foreach ($data['items'] as $item) {
        // إنشاء سجل المرتجع
        $returnRequest->returnItems()->create([
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
        ]);

        // إعادة كمية المنتج إلى الكمية الأصلية
        $product = Product::find($item['product_id']);
        if ($product) {
            $product->quantity += $item['quantity'];
            $product->save();
        }
    }

    return response()->json([
        'message' => 'تم ارسال الطلب بنجاح',
    ], 200);
}




}
