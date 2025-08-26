<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $query = Expense::with('user');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        $expenses = $query->latest()->paginate(10);
        $users = User::where('is_admin', 0)->get();
        return view('admin.dashboard', compact('expenses', 'users'));
    }
    public function show($id)
    {
         $expense = Expense::with('user')
                ->whereRaw('MD5(id) = ?', [$id])
                ->firstOrFail();

       return view('admin.expense', compact('expense'));
    }
    public function approve(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->status = 1;
        $expense->remarks = $request->remark;
        $expense->save();

        return redirect()->route('admin.dashboard')->with('success', 'Expense approved successfully.');
    }

public function reject(Request $request, $id)
{
    $expense = Expense::findOrFail($id);
    $expense->status = 2;
    $expense->remarks = $request->remark;
    $expense->save();

    return redirect()->route('admin.dashboard')->with('success', 'Expense rejected successfully.');
}

}
