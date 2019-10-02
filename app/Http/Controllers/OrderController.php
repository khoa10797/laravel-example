<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoiceDetails = session()->get('invoice-details');
        return view('order.index', ['invoiceDetails' => $invoiceDetails]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $invoice = new Invoice([
            'customer_name' => $request->get('name'),
            'customer_phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'price' => $this->calculatingPrice()
        ]);

        $invoice->save();
        $this->insertInvoiceDetail($invoice->id);
        Session::flush();

        return redirect('/menu');
    }

    private function insertInvoiceDetail($invoiceId)
    {
        $invoiceDetails = (array)session()->get('invoice-details');

        $invoiceDetails = array_map(function ($element) use ($invoiceId) {
            $element->invoice_id = $invoiceId;
            return $element;
        }, $invoiceDetails);

        foreach ($invoiceDetails as $invoiceDetail) {
            $invoiceDetail->save();
        }
    }

    private function calculatingPrice()
    {
        $invoiceDetails = (array)session()->get('invoice-details');

        $payouts = array_map(function ($element) {
            return (int)$element->quantity * $element->product->price;
        }, $invoiceDetails);

        return array_sum($payouts);
    }

    public function get(Request $request)
    {
        $this->authorize('view-order');
        $invoices = Invoice::query();

        $status = $request->get('status');
        $startDateString = $request->get('start-date');
        $endDateString = $request->get('end-date');

        $startDateString != null ?: $startDateString = date('d-m-Y', strtotime('-7 days'));
        $endDateString != null ?: $endDateString = date('d-m-Y');
        $status != null ?: $status = '-101';

        $startDate = \DateTime::createFromFormat('d-m-Y H:i:s', $startDateString . ' 00:00:00');
        $endDate = \DateTime::createFromFormat('d-m-Y H:i:s', $endDateString . ' 23:59:59');

        if ($status != '-101') {
            $invoices->where('status', '=', $status);
        }
        $invoices->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate);

        return view('order.index-admin', [
            'invoices' => $invoices->paginate(20),
            'status' => $status,
            'startDate' => $startDateString,
            'endDate' => $endDateString
        ]);
    }

    public function updateStatus($id, $status)
    {
        $this->authorize('update-order');

        $invoice = Invoice::query()->find($id);
        $invoice->status = $status;
        $invoice->save();

        return \App::make('redirect')->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::query()->find($id);
        return view('order.detail', ['invoice' => $invoice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'product-id' => 'required',
            'quantity' => 'required'
        ]);

        $productId = $request->get('product-id');
        $quantity = $request->get('quantity');

        $invoiceDetails = (array)session()->get('invoice-details');
        if ($invoiceDetails != null || count($invoiceDetails) > 0) {
            $exitsInvoiceDetail = $this->findInvoiceDetailByProductId($invoiceDetails, $productId);

            if ($exitsInvoiceDetail != null) {
                $this->updateInvoiceDetail($productId, $quantity);
                return redirect('/menu');
            }

        }

        $invoiceDetail = new InvoiceDetail([
            'product_id' => $productId,
            'quantity' => $quantity
        ]);

        $invoiceDetails = (array)session()->get('invoice-details');
        array_push($invoiceDetails, $invoiceDetail);

        session(['invoice-details' => $invoiceDetails]);
        session(['total-item' => $this->getTotalItem($invoiceDetails)]);

        return redirect('/menu');
    }

    public function removeItem($productId)
    {
        $invoiceDetails = session()->get('invoice-details');
        $key = $this->findInvoiceDetailKeyByProductId($invoiceDetails, $productId);
        unset($invoiceDetails[$key]);

        session(['invoice-details' => $invoiceDetails]);
        session(['total-item' => $this->getTotalItem($invoiceDetails)]);

        return redirect('/order');
    }

    public function updateItem(Request $request)
    {
        $productId = $request->get('productId');
        $quantity = $request->get('quantity');

        $this->updateInvoiceDetail($productId, $quantity);
        return session()->get('total-item');
    }

    private function updateInvoiceDetail($productId, $quantity)
    {
        $invoiceDetails = session()->get('invoice-details');

        $key = $this->findInvoiceDetailKeyByProductId($invoiceDetails, $productId);
        $invoiceDetails[$key]->quantity = $quantity;

        session(['invoice-details' => $invoiceDetails]);
        session(['total-item' => $this->getTotalItem($invoiceDetails)]);
    }

    private function getTotalItem(array $invoiceDetails)
    {
        $items = array_map(function ($value) {
            return $value->quantity;
        }, $invoiceDetails);

        return array_sum($items);
    }

    /** Find invoice detail exist in array by product id
     * If not exist return null
     * @param $productId
     * @param array $array
     * @return InvoiceDetail
     */
    private function findInvoiceDetailByProductId(array $array, $productId)
    {
        $arrayResult = array_filter($array, function ($value) use ($productId) {
            return $value->product->id == $productId;
        });

        if (count($arrayResult) == 0) {
            return null;
        }

        $arrayResult = array_values($arrayResult);
        return $arrayResult[0];
    }

    /** Find index invoice detail exist in array by product id
     * If not exist return null
     * @param $productId
     * @param array $array
     * @return integer
     */
    private function findInvoiceDetailKeyByProductId(array $array, $productId)
    {
        $result = $this->findInvoiceDetailByProductId($array, $productId);
        if ($result == null) {
            return null;
        }

        return array_search($result, $array);
    }
}
