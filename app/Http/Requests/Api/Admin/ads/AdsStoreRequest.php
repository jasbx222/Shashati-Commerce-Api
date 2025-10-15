<?php



namespace App\Http\Requests\Api\Admin\ads;

use App\Enums\AdsType;
use Illuminate\Foundation\Http\FormRequest;

class AdsStoreRequest extends FormRequest


{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'min:4'],
            'type'=>['string','in:slider,banner,last'],
            'image' => ['image', 'mimes:jpg,png,jpeg', 'max:2048','nullable'],
            'video_url'=>['string','url','nullable'],
            'product_id' => ['nullable', 'exists:products,id'],
        ];
    }
}
