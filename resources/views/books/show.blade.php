@extends('layouts.app')

@section('title')
    Something i need
@endsection

@section('content')
    <div class="yb-page-container">
        <div class="yb-page-content">
            <div class="yb-dt-container">
                <section class="yb-dt fl-left">
                    <a href="javascript:void(0);">
                        {{ Html::image('images/demo1.jpg', null, ['class' => 'img-ybdt']) }}
                    </a>

                    <div class="yb-dt-info">
                        <h3 class="yb-dt-title">Something i need</h3>

                        <div class="ybdt-if-content">
                            <div class="yb-dt-author fl-left">
                                <a href="javascript:void(0);" class="fl-left">
                                    {{ Html::image('images/head.png', null, ['class' => 'img-ybdt-author']) }}
                                </a>
                                <a href="javascript:void(0);" class="yb-dt-author-name bold fl-left">Aiflytomydr <i
                                            class="yb-verified center fa fa-check"></i></a>
                            </div>
                            <div class="yb-dt-views fl-right">
                                69.699 views
                            </div>
                        </div>

                        <div class="yb-dt-rates">
                            <div class="stars fl-right">
                                <form action="">
                                    <input class="star star-5" id="star-5-2" type="radio" name="rate"/>
                                    <label class="star star-5" for="star-5-2"></label>
                                    <input class="star star-4" id="star-4-2" type="radio" name="rate"/>
                                    <label class="star star-4" for="star-4-2"></label>
                                    <input class="star star-3" id="star-3-2" type="radio" name="rate"/>
                                    <label class="star star-3" for="star-3-2"></label>
                                    <input class="star star-2" id="star-2-2" type="radio" name="rate"/>
                                    <label class="star star-2" for="star-2-2"></label>
                                    <input class="star star-1" id="star-1-2" type="radio" name="rate"/>
                                    <label class="star star-1" for="star-1-2"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="yb-recommend-layout fl-right">
                    <h4 class="yb-cn-intro">Recommended</h4>

                    @for($i = 0; $i < 10; $i++)
                        <div class="yb-sg-book">
                            <div class="yb-sg-image fl-left">
                                <a href="{{ url('show') }}">
                                    {{ Html::image('images/demo1.jpg', null, ['class' => 'img-ybsg-book']) }}
                                </a>
                            </div>

                            <div class="yb-sg-info fl-left">
                                <a class="yb-sgb-title bold" href="{{ url('show') }}">Something i need</a>
                                <a class="yb-cnb-author" href="javascript:void(0);">Aiflytomydr</a>
                                <p class="yb-cnb-views">69.699 views</p>
                            </div>
                        </div>
                    @endfor
                </section>
            </div>
        </div>
    </div>
@endsection
