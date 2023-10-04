
@extends('admin.layouts.admin')
@section('link')
    @parent
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
@endsection
@section('title_file', trans('form.product_category.'))

@section('content')
    <a href="{{ route('admin.product-category.index') }}" class="btn btn-primary mb-3"><i class="fas fa-list"></i> Danh mục sản phẩm</a>
    <div class="dd" id="nestable" data-url="{{ route('admin.product-category.updateTree') }}">
        <ol class="dd-list">
            @foreach ($cats as $shop)
                @include('admin.product-category.item', ['item'=>$shop])
            @endforeach
        </ol>
    </div>
@endsection

@section('script')
    @parent
    <script src="{{ asset('js/admin/jquery.nestable.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let dd = $('.dd')
        dd.nestable({  }).on('change', function(){
            let dataOutput = dd.nestable('serialize');
            try {
                $.ajax({
                    type: "post",
                    url: dd.data('url'),
                    data: {
                        _token : $('meta[name="csrf-token"]').attr("content"),
                        data: dataOutput
                    },
                    success: function (response) {
                        console.log(response);
                    }
                });
            } catch (error) {
                console.log(error);
            }
        });
    </script>
@endsection
