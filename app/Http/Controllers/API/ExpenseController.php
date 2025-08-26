<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
        $user = auth('api')->user();
        $query = Expense::where('user_id', $user->id);
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        $expenses = $query->orderBy('created_at', 'desc')->get();
        return response()->json($expenses);
    }


    public function show($id)
    {
        $user = auth('api')->user();
        $expense = Expense::where('user_id', $user->id)->findOrFail($id);
        return response()->json($expense);
    }
}
