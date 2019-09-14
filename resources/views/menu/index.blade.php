@extends('layout',['title'=>'Menu'])

@section('navbar-botttom')
    <div class="bg-light py-2">
        <ol class="breadcrumb bg-light m-0">
            @foreach($categories as $category)
                @if($category->id == $categoryId)
                    <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{url('/menu/category', ['category'=>$category->id])}}">{{$category->name}}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
@endsection

@section('content')

    <section class="portfolio py-5">
        <div class="container py-xl-5 py-lg-3">
            <div class="title-section text-center mb-md-5 mb-4">
                <h3 class="w3ls-title mb-3">Our <span>Menu</span></h3>
                <p class="titile-para-text mx-auto">Inventore veritatis et quasi architecto beatae vitae dicta sunt
                    explicabo.Nemo
                    enim totam rem aperiam.</p>
            </div>
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
                                    <h4 class="p-mask">{{$product->name}} - <span>${{$product->price}}</span></h4>
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
                {{--                APPEND LINK TO ORDER BUTTON --}}
                <a href="#" class="button-w3ls active mt-3">Order Now
                    <span class="fa fa-caret-right ml-1" aria-hidden="true"></span>
                </a>
                <a class="close" href="#">×</a>
            </div>
        </div>
    @endforeach

@endsection
