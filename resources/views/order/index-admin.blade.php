@extends('/admin/layout-admin',['title'=>'Danh sách đơn hàng'])

@section('content')
    <link href="{{asset('css/gijgo.min.css')}}" rel="stylesheet" type="text/css">

    <style>
        .with-datepicker {
            width: 150px !important;
        }
    </style>

    <div class="d-flex justify-content-sm-between align-items-center mt-5">
        <a href="{{url('/order/export')}}" role="button" class="btn btn-primary">Xuất file excel</a>

        <form class="form-inline" method="GET" action="{{url('/admin/order')}}">
            <label for="status" class="mr-3">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="-101" {{$status == '-101' ? 'selected' : ''}}>
                    ---
                </option>
                <option value="1" {{$status == '1' ? 'selected' : ''}}>
                    Thành công
                </option>
                <option value="0" {{$status == '0' ? 'selected' : ''}}>
                    Đang chờ
                </option>
                <option value="-1" {{$status == '-1' ? 'selected' : ''}}>
                    Hủy
                </option>
            </select>

            <label for="start-date" class="m-3">Từ</label>
            <input id="start-datepicker" class="with-datepicker" name="start-date"
                   {{$startDate != null ? "value = $startDate":""}} required/>

            <label for="end-date" class="m-3">Đến</label>
            <input id="end-datepicker" class="with-datepicker" name="end-date"
                   {{$endDate != null ? "value = $endDate":""}} required/>

            <button type="submit" class="btn btn-primary ml-3">Tìm kiếm</button>
        </form>
    </div>


    <table id="table-order" class="table table-hover mt-5">
        <thead>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Tên khách</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Status</th>
            <th>Giá tiền</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{$invoice->id}}</td>
                <td>{{$invoice->customer_name}}</td>
                <td>{{$invoice->customer_phone}}</td>
                <td>{{$invoice->address}}</td>
                <td>
                    @switch($invoice->status)
                        @case(-1)
                        <span>Hủy</span>
                        @break
                        @case(0)
                        <span>Đang xử lý</span>
                        @break
                        @default
                        <span>Thành công</span>
                    @endswitch
                </td>
                <td>{{number_format($invoice->price * 1000)}}</td>
                <td>
                    <a href="{{url('/admin/order', ['id'=>$invoice->id])}}" role="button" class="btn btn-primary">Chi
                        tiết</a>
                </td>
                @if($invoice->status != 1)
                    <td>
                        <a href="{{url("/admin/order/update/$invoice->id/1")}}" role="button" class="btn btn-success">Xong</a>
                    </td>
                @endif
                @if($invoice->status == 0)
                    <td>
                        <a href="{{url("/admin/order/update/$invoice->id/-1")}}" role="button" class="btn btn-danger">Hủy</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-5">
        {{$invoices->links()}}
    </div>

    <script src="{{asset('js/gijgo.min.js')}}" type="text/javascript"></script>
    <script>
        $('#start-datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy'
        });

        $('#end-datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy'
        });
    </script>
@endsection
