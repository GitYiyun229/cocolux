<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    @if (request()->is('web.config') ||
            str_contains(request()->fullUrl(), '?') ||
            request()->is('*slug*') ||
            request()->is('*sid*') ||
            request()->is('search') ||
            request()->query('keyword') ||
            request()->is('*page*') ||
            request()->query('utm_source') ||
            request()->query('source') ||
            request()->query('attributes'))
        <meta name="robots" content="noindex, follow, noarchive">
    @else
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    @endif
    <link type='image/x-icon' href='{{ asset('images/favicon.ico') }}' rel='icon' />
    <!-- Styles -->
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    @yield('link')
    @yield('preload')
    <script type="text/javascript">
        // Đặt thời gian trì hoãn là 7 giây (7000 milliseconds)
        setTimeout(function() {
            // Tạo script đầu tiên
            var script1 = document.createElement('script');
            script1.src = "https://www.googletagmanager.com/gtm.js?id=GTM-NGPB3KQ";
            script1.async = true;
            document.head.appendChild(script1);

            // Tạo script thứ hai
            var script2 = document.createElement('script');
            script2.src = "https://www.googletagmanager.com/gtag/js?id=G-JKPNMVXR47&l=dataLayer&cx=c";
            script2.async = true;
            script2.setAttribute("nonce", "g3FmeM9o");
            document.head.appendChild(script2);

            // Thực thi mã JavaScript sau khi các script đã được tải
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-NGPB3KQ');
            ! function(w, d, t) {
                w.TiktokAnalyticsObject = t;
                var ttq = w[t] = w[t] || [];
                ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready",
                    "alias", "group", "enableCookie", "disableCookie", "holdConsent", "revokeConsent",
                    "grantConsent"
                ], ttq.setAndDefer = function(t, e) {
                    t[e] = function() {
                        t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                    }
                };
                for (var i = 0; i < ttq.methods.length; i++) ttq.setAndDefer(ttq, ttq.methods[i]);
                ttq.instance = function(t) {
                    for (
                        var e = ttq._i[t] || [], n = 0; n < ttq.methods.length; n++) ttq.setAndDefer(e, ttq
                        .methods[n]);
                    return e
                }, ttq.load = function(e, n) {
                    var r = "https://analytics.tiktok.com/i18n/pixel/events.js",
                        o = n && n.partner;
                    ttq._i = ttq._i || {}, ttq._i[e] = [], ttq._i[e]._u = r, ttq._t = ttq._t || {}, ttq._t[
                        e] = +new Date, ttq._o = ttq._o || {}, ttq._o[e] = n || {};
                    n = document.createElement("script");
                    n.type = "text/javascript", n.async = !0, n.src = r + "?sdkid=" + e + "&lib=" + t;
                    e = document.getElementsByTagName("script")[0];
                    e.parentNode.insertBefore(n, e)
                };


                ttq.load('CR43I7JC77U3DSAS3MJ0');
                ttq.page();
            }(window, document, 'ttq');
        }, 7000); // 7000 milliseconds = 7 seconds
    </script>
</head>

<body>
    @yield('page')
    <!-- Scripts -->
    @yield('script')
    <div class="circle-tel d-flex align-items-center justify-content-center">
        <a href="tel:{{ $setting['hotline'] }}">
            <svg class="shake-bottom" width="30" height="30" viewBox="0 0 32 32" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.9597 13.5093C15.9597 13.808 16.1997 14.0427 16.4931 14.0427C17.1011 14.0427 17.5917 14.5387 17.5917 15.1413C17.5917 15.4347 17.8317 15.6747 18.125 15.6747C18.4184 15.6747 18.6584 15.4347 18.6584 15.1413C18.6584 13.9467 17.6877 12.976 16.4931 12.976C16.1997 12.976 15.9597 13.216 15.9597 13.5093ZM24.6424 15.6747C24.9411 15.6747 25.1757 15.4347 25.1757 15.1413C25.1757 10.352 21.2824 6.45868 16.4931 6.45868C16.1997 6.45868 15.9597 6.69865 15.9597 6.99201C15.9597 7.28534 16.1997 7.52535 16.4931 7.52535C20.6957 7.52535 24.1091 10.944 24.1091 15.1413C24.1091 15.4347 24.349 15.6747 24.6424 15.6747Z"
                    fill="white"></path>
                <path
                    d="M20.8503 15.1414C20.8503 15.4347 21.0903 15.6747 21.3836 15.6747C21.677 15.6747 21.9169 15.4347 21.9169 15.1414C21.9169 12.1494 19.4849 9.71736 16.4929 9.71736C16.1996 9.71736 15.9596 9.95737 15.9596 10.2507C15.9596 10.5494 16.1996 10.784 16.4929 10.784C18.8983 10.784 20.8503 12.7414 20.8503 15.1414ZM16.4929 3.20001C16.1996 3.20001 15.9596 3.44002 15.9596 3.73335C15.9596 4.0267 16.1996 4.26668 16.4929 4.26668C22.4929 4.26668 27.373 9.14669 27.373 15.1414C27.373 15.4347 27.6076 15.6747 27.9063 15.6747C28.1996 15.6747 28.4396 15.4347 28.4396 15.1414C28.4396 8.5547 23.0796 3.20001 16.4929 3.20001ZM21.7036 20.7627L21.005 21.1414C19.8263 21.7867 18.333 21.568 17.3783 20.6134L11.7463 14.9814C10.7916 14.0267 10.573 12.5333 11.2183 11.3494L11.5969 10.656C12.0236 9.86668 12.1783 8.98136 12.0503 8.09601C11.9276 7.21069 11.5276 6.40535 10.8876 5.76534C10.109 4.9867 9.07429 4.56004 7.97029 4.56004C6.86628 4.56004 5.82628 4.9867 5.0476 5.76534L4.77563 6.04269C3.33562 7.48269 3.17029 9.96268 4.30629 13.0347C5.37826 15.968 7.53829 19.1467 10.3756 21.984C14.701 26.3094 19.5169 28.8 22.973 28.8C24.3383 28.8 25.4956 28.4107 26.3169 27.5894L26.5943 27.312C27.3676 26.5387 27.7996 25.504 27.805 24.3894C27.7996 23.3013 27.3569 22.2347 26.5943 21.472C25.309 20.1867 23.2983 19.8987 21.7036 20.7627Z"
                    fill="white"></path>
            </svg>
        </a>
    </div>

</body>

</html>
