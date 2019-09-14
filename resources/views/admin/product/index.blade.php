@extends('/admin/layout-admin',['title'=>'Quản lý sản phẩm'])

@section('content')

    <section class="portfolio py-5">
        <div class="container py-xl-5 py-lg-3">
            @if($products==null||sizeof($products)==0)
                <h1 style="color: red">Không có sản phẩm nào!</h1>
            @else
                {{--            List product--}}
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mt-4 mb-4">
                            <div class="gallery-demo">
                                <a href="{{'#p'.$product->id}}">
                                    <img src="{{$product->image}}" alt=" " class="img-fluid"/>
                                    <h4 class="p-mask">{{$product->name}} - <span>${{$product->price}}K</span></h4>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--            List product--}}
                <div class="d-flex justify-content-center mt-5">
                    {{$products->links()}}
                </div>
            @endif
        </div>
    </section>

    @foreach($products as $product)
        <div id="{{'p'.$product->id}}" class="pop-overlay">
            <div class="popup">
                <img class="img-fluid" src="{{$product->image}}" alt="">
                <h4 class="p-mask">{{$product->name}} - <span>$22</span></h4>
                <div class="d-flex justify-content-center">
                    <a href="{{route('product.edit', ['id'=>$product->id])}}" role="button" class="btn btn-primary mr-1">Sửa</a>
                    <form action="{{url('/admin/product',['id'=>$product->id])}}" method="POST" class="ml-1">
                        @csrf
                        {{ method_field('DELETE')}}
                        <button class="btn btn-danger" type="submit">Xóa</button>
                    </form>
                </div>
                <a class="close" href="#">×</a>
            </div>
        </div>
    @endforeach

@endsection
