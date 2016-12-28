<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--BEGIN INCLUDE CSS-->
    {{ Html::style('https://fonts.googleapis.com/css?family=Roboto') }}
    {{ Html::style('css/app.css') }}
    {{ Html::style('css/font-awesome.min.css') }}
    {{ Html::style('css/common.css') }}
    @yield('css')
    <!--END INCLUDE CSS-->
</head>

<body d-url="{{ URL::to('/') }}">
<!--BEGIN HEADER-->
<header id="header" d-l="{{ Auth::check() ? 1 : 0 }}">
    <div class="yb-content-base">
        <div class="yh-container">
            <div class="yh-logo">
                <a class="btn-menu" href="javascript:void(0);"><i class="fa fa-reorder"></i></a>
                <a class="icon" href="{{ url('/') }}" title="YouBook">
                    {{ Html::image('images/icon.png', 'YouBook', ['class' => 'img-icon']) }}
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
                @if (Auth::guest())
                    <a class="yb-btn hl-signin" href="{{ url('login') }}">Sign in</a>
                @else
                    <ul class="yb-nav list-unstyled">
                        <li class="dropdown">
                            <a class="dropdown-toggle yb-u-name yb-u-link" data-toggle="dropdown" 
                               href="#">{{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                        <ul class="dropdown-menu">
                            <li><a class="yb-u-logout yb-u-link" href="{{ url('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                      </li>
                    </ul>
                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @endif
            </div>
        </div>
    </div>
</header>
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
            @foreach($_categories as $category)
                <li><a href="{{ url('category/' . $category->id) }}"><span class="fa fa-photo ybc-icon center"></span> {{ $category->name }}</a></li>
            @endforeach
        </ul>
        <div class="yb-divide"></div>
        @if (Auth::guest())
            <p class="yb-recommend-tt">Hãy đăng nhập ngay bây giờ để xem thông tin của bạn và các đề xuất!</p>

            <div>
                <a class="yb-btn hl-signin" href="{{ url('login') }}">Sign in</a>
            </div>
        @endif
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
{{ Html::script('js/jquery-1.12.4.min.js') }}
{{ Html::script('js/app.js') }}
{{ Html::script('js/common.js') }}
@yield('script')

<script>
    $(document).ready(function(){
        Common.init();
    });
</script>
<!--END INCLUDE SCRIPT-->
</body>
</html>