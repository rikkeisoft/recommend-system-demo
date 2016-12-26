@extends('layouts.app')

@section('title')
    {{ $book->title }} - YouBook
@endsection

@section('content')
    <div class="yb-page-container">
        <div class="yb-page-content">
            <div class="yb-dt-container">
                <section class="yb-dt fl-left">
                    <a href="javascript:void(0);">
                        {{ Html::image($book->cover, null, ['class' => 'img-ybdt']) }}
                    </a>

                    <div class="yb-dt-info">
                        <h3 class="yb-dt-title">{{ $book->title }}</h3>

                        <div class="ybdt-if-content">
                            <div class="yb-dt-author fl-left">
                                <a href="javascript:void(0);" class="fl-left">
                                    {{ Html::image('images/head.png', null, ['class' => 'img-ybdt-author']) }}
                                </a>
                                <a href="javascript:void(0);" class="yb-dt-author-name bold fl-left">{{ $book->author }} <i
                                            class="yb-verified center fa fa-check"></i></a>
                            </div>
                            <div class="yb-dt-views fl-right">
                                {{ $book->views }} views
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

                {{--BEGIN RECOMMENDED--}}
                @include('books._recommended')
                {{--END RECOMMENDED--}}
            </div>
        </div>
    </div>
@endsection
