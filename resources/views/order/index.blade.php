@extends('layout',['title'=>'Đặt hàng'])
@section('content')
    @if($invoiceDetails == null)
        <h1 class="mt-5">Bạn chưa mua sản phẩm nào!</h1>
    @else
        <table id="table-order" class="table table-hover mt-5">
            <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoiceDetails as $invoiceDetail)
                <tr>
                    <td>{{$invoiceDetail->product->name}}</td>
                    <td>
                        <input class="input-product-order" type="number" value="{{$invoiceDetail->quantity}}" min="1"
                               max="50" data-product-id="{{$invoiceDetail->product->id}}"
                               data-price="{{$invoiceDetail->product->price}}">
                    </td>
                    <td>{{$invoiceDetail->product->price}}</td>
                    <td id="{{'payout'.$invoiceDetail->product->id}}" class="payout">
                        {{$invoiceDetail->quantity * $invoiceDetail->product->price * 1000}}
                    </td>
                    <td>
                        <a href="{{url('/order/invoiceDetail/remove', ['productId' => $invoiceDetail->product->id])}}"
                           role="button"
                           class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p class="mt-5">Tổng tiền: <span id="total-price"></span> VND</p>
    @endif
@endsection
