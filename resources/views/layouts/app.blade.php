<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--BEGIN INCLUDE CSS-->
        {{ Html::style('public/css/app.css') }}
        {{ Html::style('public/css/font-awesome.min.css') }}
        {{ Html::style('public/css/common.css') }}
        @yield('css')
        <!--END INCLUDE CSS-->
    </head>
    <body>
        <!--BEGIN HEADER-->
        <header id="header">
            <div class="rh-left fl-left">
                <a class="btn-menu"><i class="fa fa-reorder"></i></a>
                <a class="icon">{{ Html::image('public/images/icon.png') }}</a>
            </div>
            <div class="rh-right fl-left">
                {{ Form::open(['url' => '/']) }}
                {{ Form::text('search_content', old('search_content'), ['placeholder' => 'Search']) }}
                {{ Form::button('<i class="fa fa-search"></i>', ['type' => 'submit']) }}
                {{ Form::close() }}
            </div>
        </header>
        <!--END HEADER-->

        <!--BEGIN MAIN CONTENT-->
        <div>@yield('content')</div>
        <!--END MAIN CONTENT-->

        <!--BEGIN FOOTER-->
        <footer id="footer"></footer>
        <!--END FOOTER-->

        <!--BEGIN INCLUDE SCRIPT-->
        {{ Html::script('public/js/jquery-1.12.4.min.js') }}
        {{ Html::script('public/js/app.js') }}
        @yield('script')
        <!--END INCLUDE SCRIPT-->
    </body>
</html>