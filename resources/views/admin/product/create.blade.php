@extends('/admin/layout-admin',['title'=>'Thêm sản phẩm'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col m-2">
                <form method="POST" action="{{ route('product.store') }}" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="category_id">Mã loại: </label>
                        <select class="form-control" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Tên sản phẩm:</label>
                        <input type="text" class="form-control" name="name" required/>
                    </div>

                    <div class="form-group">
                        <label for="price">Giá bán:</label>
                        <input type="text" class="form-control" name="price" required/>
                    </div>

                    <div class="form-group">
                        <label for="note">Ghi chú:</label>
                        <input type="text" class="form-control" name="note"/>
                    </div>

                    <div class="form-group">
                        <label for="image">Ảnh:</label>
                        <input type="file" id="img-upload" class="form-control" name="image" required/>
                    </div>

                    <a role="button" class="btn btn-info m-1" href="{{url('/admin/product')}}" style="color: white">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <button type="submit" class="btn btn-primary m-1">Thêm sản phẩm</button>
                </form>
            </div>

            <div class="col m-2">
                <img src="" id="img-upload-tag" style="width: 100%">
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
