<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--BEGIN INCLUDE CSS-->
    {{ Html::style('https://fonts.googleapis.com/css?family=Roboto') }}
    {{ Html::style('public/css/app.css') }}
    {{ Html::style('public/css/font-awesome.min.css') }}
    {{ Html::style('public/css/common.css') }}
    @yield('css')
    <!--END INCLUDE CSS-->
</head>
<body>

<!--BEGIN HEADER-->
<header id="header">
    <div class="yb-content-base">
        <div class="yh-container">
            <div class="yh-logo">
                <a class="btn-menu" href="javascript:void(0);"><i class="fa fa-reorder"></i></a>
                <a class="icon" href="{{ url('/') }}" title="YouBook">
                    {{ Html::image('public/images/icon.png', 'YouBook', ['class' => 'img-icon']) }}
                </a>
            </div>
            <div class="yh-content">
                {{ Form::open(['url' => 'search', 'method' => 'GET', 'class' => 'hf-formsearch', 'enctype' => 'multipart/form-data']) }}
                <div class="hf-group">
                    {{ Form::text('search_query', old('search_query'),
                    ['placeholder' => 'Search', 'class' => 'hi-search-content']) }}
                    {{ Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'hbtn-submit']) }}
                </div>
                {{ Form::close() }}
            </div>
            <div class="yh-signin right">
                <a class="yb-btn hl-signin" href="javascript:void(0);">Sign in</a>
            </div>
        </div>
    </div>
</header>
{{--<div class="yh-clear-offset"></div>--}}
<!--END HEADER-->

<!--BEGIN MAIN CONTENT-->
<div id="main-container">
    {{--BEGIN SIDEBAR--}}
    <div class="yb-sliderbar">
        <ul class="yb-menu list-unstyled">
            <li class="active"><a href="{{ url('/') }}"><span class="fa fa-home ybsb-icon center"></span> Home</a>
            </li>
            <li><a href="javascript:void(0);"><span class="fa fa-thermometer-full ybsb-icon center"></span> Featured</a>
            </li>
        </ul>
        <div class="yb-divide"></div>
        <p class="yb-categories-title">CATEGORIES</p>
        <ul class="yb-categories list-unstyled">
            <li><a href="javascript:void(0);"><span class="fa fa-photo ybc-icon center"></span> Tiểu thuyết</a></li>
            <li><a href="javascript:void(0);"><span class="fa fa-photo ybc-icon center"></span> Thơ</a></li>
            <li><a href="javascript:void(0);"><span class="fa fa-photo ybc-icon center"></span> Ngôn tình</a></li>
            <li><a href="javascript:void(0);"><span class="fa fa-photo ybc-icon center"></span> Truyện</a></li>
        </ul>
        <div class="yb-divide"></div>
        <p class="yb-recommend-tt">Hãy đăng nhập ngay bây giờ để xem thông tin của bạn và các đề xuất!</p>

        <div>
            <a class="yb-btn hl-signin" href="javascript:void(0);">Sign in</a>
        </div>
    </div>
    {{--END SIDEBAR--}}

    {{--BEGIN PAGE CONTANTER--}}
    <div class="yb-page">
        <div class="yb-page-area">
            @yield('content')
        </div>
        <!--</div>-->
    </div>
    {{--END PAGE CONTAINER--}}

</div>
<!--END MAIN CONTENT-->

{{--BEGIN BACKTOTOP--}}
<div class="backtotop">
    <a id="backtotop" class="center" href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>
</div>
{{--END BACKTOTOP--}}

<!--BEGIN FOOTER-->
<footer id="footer"></footer>
<!--END FOOTER-->

<!--BEGIN INCLUDE SCRIPT-->
{{ Html::script('public/js/jquery-1.12.4.min.js') }}
{{ Html::script('public/js/app.js') }}
{{ Html::script('public/js/common.js') }}
@yield('script')

<script>
    $(document).ready(function(){
        Common.init();
    });
</script>
<!--END INCLUDE SCRIPT-->
</body>
</html>