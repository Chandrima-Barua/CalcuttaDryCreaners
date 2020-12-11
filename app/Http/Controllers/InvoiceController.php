<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Item;
use App\Order;
use App\OrderItem;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Response;
use Validator;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::groupby('invoice_no')->get();

        if ($request->wantsJson()) {
            return response()->json(['invoices' => $invoices]);
        } else {
            return view('invoice.index')->with(['invoices' => $invoices]);
        }
    }

    public function create()
    {
        $today = Carbon::today();
        $items = Item::all();
        $services = Service::all();

        return view('invoice.create')->with(['items' => $items, 'services' => $services, 'today' => $today]);
    }

    public function orderinvoice($id)
    {
        $today = Carbon::today();
        $order = Order::find($id);
        $branch = $order->branch;

        $orderitems = OrderItem::where('order_id', $id)->join('services', 'services.id', '=', 'order_items.service_id')
        ->join('items', 'items.id', '=', 'order_items.item_id')
        ->select('order_items.*', 'items.id as item_id', 'items.name as item_name', 'items.slug as item_slug', 'items.regularDeliveryTime as regulartime', 'items.urgentDeliveryTime as urgenttime', 'services.name as service_name')
        ->get();

        return view('invoice.create')->with(['today' => $today, 'order' => $order, 'orderitems' => $orderitems, 'branch' => $branch]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_no' => 'required|string',
            'customername' => 'required|string',
            'customer_address' => 'required|string',
            'qty' => 'required|integer',
            'discount' => 'string',
            'tax' => 'string',
            'amount' => 'required|integer',
            'subtotal' => 'required|integer',
            'total' => 'required|integer',
            'amount_due' => 'required|integer',
            'due_date' => 'required|date',
        ]);

        $invoice = new Invoice();
        $invoice->invoice_no = $request->input('invoice_no');
        $invoice->order_no = $request->input('order_no');
        $invoice->customername = $request->input('customername');
        $invoice->customer_address = $request->input('customer_address');
        $invoice->qty = $request->input('qty');
        $invoice->discount = $request->input('discount');
        $invoice->tax = $request->input('tax');
        $invoice->amount = $request->input('amount');
        $invoice->subtotal = $request->input('subtotal');
        $invoice->total = $request->input('total');
        $invoice->amount_due = $request->input('amount_due');

        // $invoice->due_date =Carbon::parse($request->input('due_date'));
        $invoice->due_date = $request->input('due_date');
        $invoice->save();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Invoice Created successfully',
            ], 200);
        } else {
            return redirect(route('invoice.index'))->with('successes', ['New Invoice Created!']);
        }
    }

    public function show(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $items = Item::all();
        $services = Service::all();
        if ($request->wantsJson()) {
            return response()->json(['invoice' => $invoice]);
        } else {
            return view('invoice.show')->with(['invoice' => $invoice, 'items' => $items, 'services' => $services]);
        }
    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $items = Item::all();
        $services = Service::all();

        return view('invoice.edit')->with(['invoice' => $invoice, 'items' => $items, 'services' => $services]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'invoice_no' => 'required|string',
            'customername' => 'required|string',
            'customer_address' => 'required|string',
            'services.*' => 'required',
            'items.*' => 'required',
            'qty' => 'required|integer',
            'rate' => 'required|integer',
            'tax' => 'required|string',
            'amount' => 'required|integer',
            'subtotal' => 'required|integer',
            'total' => 'required|integer',
            'amount_due' => 'required|integer',
            'due_date' => 'required|date',
        ]);
        $serviceIds = $request->input('services');
        foreach ($serviceIds as $serviceId) {
            $services = Service::find($serviceId);
        }
        $itemIds = $request->input('items');
        foreach ($itemIds as $itemId) {
            $items = Item::find($itemId);
        }
        $invoice = Invoice::find($id);
        $invoice->order_no = $request->input('order_no');
        $invoice->invoice_no = $request->input('invoice_no');
        $invoice->customername = $request->input('customername');
        $invoice->customer_address = $request->input('customer_address');
        $invoice->qty = $request->input('qty');
        $invoice->rate = $request->input('rate');
        $invoice->tax = $request->input('tax');
        $invoice->amount = $request->input('amount');
        $invoice->subtotal = $request->input('subtotal');
        $invoice->total = $request->input('total');
        $invoice->amount_due = $request->input('amount_due');
        $invoice->due_date = Carbon::parse($request->input('due_date'));

        $services->invoices()->save($invoice);
        $items->invoices()->save($invoice);

        return redirect(route('invoice.show', $id))->with('successes', ['Invoice Updated!']);
    }

    public function destroy(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'invoice deleted successfully',
            ], 200);
        } else {
            return redirect('/invoice')->with('success', 'Invoice deleted!');
        }
    }

    public function pdfview(Request $request, $invoice_id)
    {
        $today = Carbon::today();
        $order = Order::find($invoice_id);
        $branch = $order->branch;
        $orderitems = OrderItem::where('order_id', $invoice_id)->join('services', 'services.id', '=', 'order_items.service_id')
        ->join('items', 'items.id', '=', 'order_items.item_id')
        ->select('order_items.*', 'items.id as item_id', 'items.name as item_name', 'items.slug as item_slug', 'items.regularDeliveryTime as regulartime', 'items.urgentDeliveryTime as urgenttime', 'services.name as service_name')
        ->get();

        $invoices = Invoice::where('order_no', $invoice_id)->groupby('invoice_no')->get();

        $pdf = PDF::loadView('invoice.pdfview', compact('invoices', 'today', 'order', 'orderitems', 'branch'));

        return $pdf->download('invoice_no#'.$invoice_id.'.pdf');

        // return view('invoice.pdfview', compact('invoices', 'today', 'order', 'orderitems', 'branch'));
    }

    public function exportCSV()
    {
        $table = Invoice::all();

        $filename = 'invoices.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Invoice Number', 'Customer Name', 'Customer Address', 'Qty', 'Tax', 'Amount', 'Subtotal', 'Total', 'Amount Due', 'Due Date']);

        foreach ($table as $row) {
            fputcsv($handle, [$row['invoice_no'], $row['customer_name'], $row['customer_address'], $row['qty'], $row['tax'], $row['amount'], $row['subtotal'], $row['total'], $row['amount_due'], $row['due_date']]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return Response::download($filename, 'invoices.csv', $headers);
    }

    public function template()
    {
        $pdf = PDF::loadView('invoice.template');

        return $pdf->download('invoice_template.pdf');
        // return view('invoice.template');
    }

    public function pdfdata(Request $request, $invoice_id)
    {
        $today = Carbon::today();
        $order = Order::find($invoice_id);
        $branch = $order->branch;
        $orderitems = OrderItem::where('order_id', $invoice_id)->join('services', 'services.id', '=', 'order_items.service_id')
        ->join('items', 'items.id', '=', 'order_items.item_id')
        ->select('order_items.*', 'items.id as item_id', 'items.name as item_name', 'items.slug as item_slug', 'items.regularDeliveryTime as regulartime', 'items.urgentDeliveryTime as urgenttime', 'services.name as service_name')
        ->get();

        $invoices = Invoice::where('order_no', $invoice_id)->groupby('invoice_no')->get();

        $pdf = PDF::loadView('invoice.data', compact('invoices', 'today', 'order', 'orderitems', 'branch'));

        return $pdf->download('invoice_no#'.$invoice_id.'.pdf');
        // return view('invoice.data', compact('invoices', 'today', 'order', 'orderitems', 'branch'));
    }
}
