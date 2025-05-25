<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return response()->json([
            'status' => 'success',
            'data' => $vouchers
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'voucher_rate' => 'required|integer|min:0|max:100',
            'status' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $voucher = Voucher::create([
            'voucher_rate' => $request->voucher_rate,
            'status' => $request->status ? Carbon::parse($request->status) : null,
            'time_stamp' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher created successfully',
            'data' => $voucher
        ], 201);
    }

    public function show($id)
    {
        $voucher = Voucher::find($id);
        
        if (!$voucher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Voucher not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $voucher
        ]);
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::find($id);
        
        if (!$voucher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Voucher not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'voucher_rate' => 'integer|min:0|max:100',
            'status' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        if (isset($data['status'])) {
            $data['status'] = Carbon::parse($data['status']);
        }

        $voucher->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher updated successfully',
            'data' => $voucher
        ]);
    }

    public function destroy($id)
    {
        $voucher = Voucher::find($id);
        
        if (!$voucher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Voucher not found'
            ], 404);
        }

        $voucher->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher deleted successfully'
        ]);
    }
}
