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
                    <td>{{$invoiceDetail->product->price * 1000}}</td>
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

        <div class="d-flex flex-row justify-content-sm-between align-items-center mt-5">
            <p>Tổng tiền: <span id="total-price"></span> VND</p>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Đặt hàng</button>
        </div>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thông tin khách hàng</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="POST" action="{{url('/order')}}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Họ và tên:</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại:</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ:</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Xong</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
