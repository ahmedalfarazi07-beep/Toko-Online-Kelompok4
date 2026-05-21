<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validate(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($validated['code']))->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Coupon tidak ditemukan'], 404);
        }

        if (!$coupon->isValid($validated['total_amount'])) {
            return response()->json(['valid' => false, 'message' => 'Coupon tidak valid atau sudah kadaluarsa'], 422);
        }

        $discount = $coupon->calculateDiscount($validated['total_amount']);

        return response()->json([
            'valid' => true,
            'coupon_id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount_amount' => $discount,
            'message' => "Diskon Rp " . number_format($discount, 2, ',', '.'),
        ]);
    }
}
