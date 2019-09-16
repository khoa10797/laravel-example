<?php

namespace App\Http\Controllers;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
