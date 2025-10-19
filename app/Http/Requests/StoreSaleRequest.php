<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
    public function rules(): array // دي الداتا اللي هتدخل بعد التحقق منها فالفورم 
{
    return [
        'client_id' => 'required|exists:clients,id',
        'unit_id' => 'required|exists:units,id',
        'down_payment' => 'nullable|numeric|min:0',
        'installments_count' => 'required|integer|min:1',
        'installment_dates' => 'required|array',
        'installment_dates.*' => 'date|after_or_equal:today',
    ];
}
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
   public function messages(): array
{
    return [
        'installment_dates.required' => 'لازم تختار تواريخ الأقساط.',
        'installment_dates.array' => 'تواريخ الأقساط لازم تكون في صورة قائمة (Array).',
        'installment_dates.*.date' => 'كل تاريخ من تواريخ الأقساط لازم يكون مكتوب بشكل صحيح (مثال: 2025-11-01).',
        'installment_dates.*.after_or_equal' => 'لا يمكن اختيار تاريخ قسط أقدم من تاريخ اليوم.',
        
        // باقي الحقول لو عايز تخصص رسائلها
        'client_id.required' => 'لازم تختار عميل.',
        'client_id.exists' => 'العميل المختار غير موجود.',
        'unit_id.required' => 'لازم تختار وحدة.',
        'unit_id.exists' => 'الوحدة المختارة غير موجودة.',
        'total_price.required' => 'لازم تدخل إجمالي سعر الوحدة.',
        'total_price.numeric' => 'إجمالي السعر لازم يكون رقم.',
        'installments_count.required' => 'عدد الأقساط مطلوب.',
        'installments_count.integer' => 'عدد الأقساط لازم يكون عدد صحيح.',
        'installment_type.in' => 'نوع الأقساط لازم يكون إما شهري أو ربع سنوي.',
    ];
}

}
