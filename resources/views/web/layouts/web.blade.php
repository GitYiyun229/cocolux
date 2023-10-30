@extends('web.layouts.app')
@section('page')
    <div id="app">
        <!-- Header -->
        @include('web.partials._header')
        <!-- /.Header -->
        <div class="content">
            @yield('content')
        </div>
        <!-- Main Footer -->
        @include('web.partials._footer')
    </div>
    <nav class="menu-mobile d-block d-lg-none" id="menu-mobile">
        <ul>
            @php
            $routeName = \Route::currentRouteName();
            @endphp
            <li class="w-100 h-100">
                <a href="{{ route('home') }}" class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'home' ? 'text-danger' : ''}}">
                    <i class="fa-solid fa-house-chimney"></i>
                    Trang chủ
                </a>
            </li>
            <li class="w-100 h-100">
                <a href="{{ route('dealHotProducts') }}" class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'dealHotProducts' ? 'text-danger' : ''}}">
                    <i class="fa-solid fa-gift"></i>
                    Ưu đãi
                </a>
            </li>
            <li class="w-100 h-100">
                <a href="{{ route('homeArticle') }}" class="d-flex align-items-center justify-content-center h-100 flex-column {{ $routeName == 'homeArticle' ? 'text-danger' : ''}}">
                    <i class="fa-regular fa-newspaper"></i>
                    Xu hướng
                </a>
            </li>
        </ul>
    </nav>
@endsection

@section('link')
    <link rel="stylesheet" href="{{ asset('/js/web/fontawesome-free-6.1.1-web/css/all.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('/css/mmenu.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/css/web/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css">
    <link rel="stylesheet" href="{{ asset('/css/web/template.css') }}?ver=2.0">
    <link rel="stylesheet" href="{{ asset('/css/web/style.css') }}?ver=2.0">
@endsection

@section('script')
    <!-- Bootstrap -->
    <script src="{{ asset('/js/web/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/web/template.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="{{ asset('js/web/main.js') }}" defer></script>
    <script>
        let toastrSuccsee = '{{ Session::get('success') }}';
        let toastrDanger = '{{ Session::get('danger') }}';
        if (toastrDanger.length > 0 || toastrSuccsee.length > 0) {
            if (toastrDanger.length > 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: toastrDanger,
                })
                toastr["error"](toastrDanger)
            } else {
                Swal.fire(
                    'Thành công!',
                    toastrSuccsee,
                    'success'
                )
            }
        }
    </script>
    <script>
        const autoCompleteJS = new autoComplete({
            selector: "#keyword",
            placeHolder: "Tìm sản phẩm bạn mong muốn...",
            data: {
                src: async (query) => {
                    try {
                        // Fetch Data from external Source
                        const product_ids = $('#products_add').val();
                        const response = await fetch(`{{ route('admin.article.search') }}`,{
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                keyword: query,
                                product_ids: product_ids,
                                _token: $('meta[name="csrf-token"]').attr("content")
                            })
                        });
                        // Data should be an array of `Objects` or `Strings`
                        const data = await response.json();
                        return data.data;
                    } catch (error) {
                        return error;
                    }
                },
                keys: ["title","sku",'slug']
            },
            resultsList: {
                element: (list, data) => {
                    const info = document.createElement("p");
                    if (data.results.length > 0) {
                        // info.innerHTML = `Displaying <strong>${data.results.length}</strong> out of <strong>${data.matches.length}</strong> results`;
                    } else {
                        info.innerHTML = `Found <strong>${data.matches.length}</strong> matching results for <strong>"${data.query}"</strong>`;
                    }
                    list.prepend(info);
                },
                noResults: true,
                maxResults: 30,
                tabSelect: true
            },
            resultItem: {
                element: (item, data) => {
                    // Modify Results Item Style
                    item.style = "display: flex; justify-content: space-between;";
                    // Modify Results Item Content
                    item.innerHTML = `
                      <a style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;" href="${data.value.link_product}">
                        ${data.value.title}
                      </a>`;
                },
                highlight: true,
            },
            diacritics: true,
            events: {
                input: {
                    click: () => {

                    },
                }
            }
        });
    </script>

@endsection
