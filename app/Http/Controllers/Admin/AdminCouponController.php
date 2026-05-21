<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(15);
        return view('admin.coupons', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0.01',
            'usage_limit' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
        ]);

        Coupon::create(array_merge($validated, ['code' => strtoupper($validated['code'])]));

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon berhasil dibuat');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupon-edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0.01',
            'usage_limit' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
        ]);

        $coupon->update(array_merge($validated, ['code' => strtoupper($validated['code'])]));

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon berhasil diupdate');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon berhasil dihapus');
    }
}
