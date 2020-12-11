<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Expense;
use App\Orderstatus;
use App\Order;
use App\ExpenseCategory;
use Carbon\Carbon;
use DB;

class StaffExpenseController extends Controller
{
    
    public function index(Request $request)
    {
        $from    = Carbon::parse(sprintf(
            '%s-%s-01',
            $request->query('y', Carbon::now()->year),
            $request->query('m', Carbon::now()->month),
            $request->query('d', Carbon::now()->day)
        ));
       
        $to      = clone $from;
        $to->day = $to->daysInMonth;

        //staff expense sum
        $exp_q = Expense::whereBetween('entry_date', [$from, $to]);

        //income by orders
        $inc_q = Order::whereBetween('created_at', [$from, $to]);

        $exp_total = $exp_q->sum('amount');
        $inc_total = $inc_q->sum('total');
        $exp_group = $exp_q->orderBy('amount', 'desc')->get()->groupBy('expense_category_id');
        $inc_group = $inc_q->orderBy('total', 'desc')->get()->groupBy('branch_id');
        $profit    = $inc_total - $exp_total;
        $exp_summary = [];
        foreach ($exp_group as $exp) {
            
            foreach ($exp as $line) {
                
                if (! isset($exp_summary[$line->expense_category->name])) {
                    $exp_summary[$line->expense_category->name] = [
                        'name'   => $line->expense_category->name,
                        'amount' => 0,
                    ];
                }
                $exp_summary[$line->expense_category->name]['amount'] += $line->amount;
            }
        }

        $inc_summary = [];
        foreach ($inc_group as $inc) {
            foreach ($inc as $line) {
                if (! isset($inc_summary[$line->branch->name])) {
                    $inc_summary[$line->branch->name] = [
                        'name'   => $line->branch->name,
                        'amount' => 0,
                    ];
                }
                $inc_summary[$line->branch->name]['amount'] += $line->total;
            }
        }
        // dd(Carbon::now()->year);
        if($request->y != null){

            $yearly_income = Order::whereYear('created_at', $request->y);
            $yearly_expense = Expense::whereYear('created_at', $request->y);

            

        }
        else{

            $yearly_income = Order::whereYear('created_at', Carbon::now()->year);
            $yearly_expense = Expense::whereYear('created_at', Carbon::now()->year);
        }
        
        $income= $yearly_income->sum('total');
        $expense= $yearly_expense->sum('amount');

        return view('staffexpense.index', compact(
            'exp_summary',
            'inc_summary',
            'exp_total',
            'inc_total',
            'profit',
            'expense',
            'income'
        ));

    }

   
    public function search(Request $request)
    {

        if( $request->day != 0){

            $expense = Expense::whereDay('created_at',  $request->day)->whereMonth('created_at', $request->m)->whereYear('created_at', $request->y);
       
       

        $income = Order::whereDay('created_at',  $request->day)->whereMonth('created_at', $request->m) 
        ->whereYear('created_at', $request->y);
        
        }

        else{

            $expense = Expense::whereMonth('created_at', $request->m)->whereYear('created_at', $request->y) ;
            $income = Order::whereMonth('created_at', $request->m)->whereYear('created_at', $request->y);

        }

        $exp_total = $expense->sum('amount');
        $inc_total = $income->sum('total');
        $exp_group = $expense->orderBy('amount', 'desc')->get()->groupBy('expense_category_id');
        $inc_group = $income->orderBy('total', 'desc')->get()->groupBy('branch_id');
        $profit    = $inc_total - $exp_total;
        $exp_summary = [];

        foreach ($exp_group as $exp) {
            
            foreach ($exp as $line) {
                
                if (! isset($exp_summary[$line->expense_category->name])) {
                    $exp_summary[$line->expense_category->name] = [
                        'name'   => $line->expense_category->name,
                        'amount' => 0,
                    ];
                }
                $exp_summary[$line->expense_category->name]['amount'] += $line->amount;
            }
        }
        

        $inc_summary = [];
        foreach ($inc_group as $inc) {
            foreach ($inc as $line) {
                if (! isset($inc_summary[$line->branch->name])) {
                    $inc_summary[$line->branch->name] = [
                        'name'   => $line->branch->name,
                        'amount' => 0,
                    ];
                }
                $inc_summary[$line->branch->name]['amount'] += $line->total;
            }
        }
        // dd(Carbon::now()->year);
        if($request->y != null){

            $yearly_income = Order::whereYear('created_at', $request->y);
            $yearly_expense = Expense::whereYear('created_at', $request->y);

            

        }
        else{

            $yearly_income = Order::whereYear('created_at', Carbon::now()->year);
            $yearly_expense = Expense::whereYear('created_at', Carbon::now()->year);
        }
        
        $income= $yearly_income->sum('total');
        $expense= $yearly_expense->sum('amount');

        return view('staffexpense.index', compact(
            'exp_summary',
            'inc_summary',
            'exp_total',
            'inc_total',
            'profit',
            'expense',
            'income'
        ));
    }

    
   
}