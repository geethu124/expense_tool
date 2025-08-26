<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    //
    public function index(){
        $expenses = Expense::latest()->get();
        return view('Employees.index', compact('expenses'));
    }
     public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png,xlsx,doc,docx|max:5120',

        ]);

        $expense = new Expense();
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->user_id = Auth::id();

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('expenses', 'public');
            $expense->file_path = $filePath;
        }

        $expense->save();

        return redirect()->back()->with('success', 'Expense added successfully.');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png,xlsx,doc,docx|max:4096',
    ]);

    $expense = Expense::findOrFail($id);

    $expense->title = $request->title;
    $expense->amount = $request->amount;
    $expense->description = $request->description;

    if ($request->hasFile('file_path')) {
        $filePath = $request->file('file_path')->store('expenses', 'public');
        $expense->file_path = $filePath;
    }

    $expense->save();

    return response()->json(['message' => 'Expense updated successfully']);
}

}
