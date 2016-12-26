@extends('layouts.app')

@section('title')
    YouBook
@endsection

@section('content')

    <ul class="yb-page-menu list-unstyled center">
        <li><a class="active" href="javascript:void(0);">Home</a></li>
        <li><a href="javascript:void(0);">Featured</a></li>
    </ul>

    <div class="yb-page-container">
        <div class="yb-page-content">
            <section class="yb-channel">
                <h4 class="yb-cn-intro">Recommended</h4>

                <div class="yb-cn-container">
                    <div class="yb-cn-row">
                        @for($j = 0; $j < 5; $j++)
                            <div class="yb-cn-book">
                                <a href="{{ url('show') }}">
                                    {{ Html::image('images/demo1.jpg', null, ['class' => 'img-ybcn-book']) }}
                                </a>

                                <p>
                                    <a class="yb-cnb-title bold" href="{{ url('show') }}">Something i need</a>
                                </p>

                                <p><a class="yb-cnb-author" href="javascript:void(0);">Aiflytomydr</a></p>

                                <p class="yb-cnb-views">69.699 views - 1 month ago</p>
                            </div>
                        @endfor
                    </div>
                    <div class="yb-cn-row">
                        @for($j = 0; $j < 5; $j++)
                            <div class="yb-cn-book">
                                <a href="{{ url('show') }}">
                                    {{ Html::image('images/demo1.jpg', null, ['class' => 'img-ybcn-book']) }}
                                </a>

                                <p>
                                    <a class="yb-cnb-title bold" href="{{ url('show') }}">Something i need</a>
                                </p>

                                <p><a class="yb-cnb-author" href="javascript:void(0);">Aiflytomydr</a></p>

                                <p class="yb-cnb-views">69.699 views - 1 month ago</p>
                            </div>
                        @endfor
                    </div>
                </div>
            </section>
            @for($i = 0; $i < 5; $i++)
                <section class="yb-channel">
                    <h4 class="yb-cn-intro">Nam Cao</h4>

                    <div class="yb-cn-container">
                        <div class="yb-cn-row">
                            @for($j = 0; $j < 5; $j++)
                                <div class="yb-cn-book">
                                    <a href="{{ url('show') }}">
                                        {{ Html::image('images/demo1.jpg', null, ['class' => 'img-ybcn-book']) }}
                                    </a>

                                    <p><a class="yb-cnb-title bold" href="{{ url('show') }}">Something i
                                            need</a></p>

                                    <p><a class="yb-cnb-author" href="javascript:void(0);">Aiflytomydr</a></p>

                                    <p class="yb-cnb-views">69.699 views - 1 month ago</p>
                                </div>
                            @endfor
                        </div>
                    </div>
                </section>
            @endfor
        </div>
    </div>
@endsection
