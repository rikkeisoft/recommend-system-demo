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
            <!--BEGIN RECOMMENDED-->
            @if(count($recommendBooks))
                <section class="yb-channel">
                    <h4 class="yb-cn-intro">Recommended</h4>

                    <div class="yb-cn-container">
                        @foreach($recommendBooks as $book)
                            <div class="yb-cn-book">
                                <a href="{{ url('show/' . $book->id) }}">
                                    {{ Html::image($book->cover, null, ['class' => 'img-ybcn-book']) }}
                                </a>

                                <a class="yb-cnb-title block bold"
                                   href="{{ url('show/' . $book->id) }}">{{ $book->title }}</a>

                                <p><a class="yb-cnb-author" href="javascript:void(0);">{{ $book->author }}</a></p>

                                <?php $rateAvg = $book->rates()->avg('point'); ?>
                                <p class="yb-cnb-views">
                                    <span>{{ $rateAvg ? $rateAvg : 0 }} <i class="fa fa-star icon-rate"></i></span>
                                    - {{ $book->views }} views
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @else
                <h3 class="yb-empty-content center">Empty!</h3>
            @endif
        <!--END RECOMMENDED-->

            <!--BEGIN CHANNEL-->
            @foreach($authors as $author)
                <section class="yb-channel">
                    <h4 class="yb-cn-intro">{{ $author->author }}</h4>

                    <div class="yb-cn-container">
                        @foreach($author->listBooks as $book)
                            <div class="yb-cn-book">
                                <a href="{{ url('show/' . $book->id) }}">
                                    {{ Html::image($book->cover, null, ['class' => 'img-ybcn-book']) }}
                                </a>

                                <a class="yb-cnb-title block bold"
                                   href="{{ url('show/' . $book->id) }}">{{ $book->title }}</a>

                                <p><a class="yb-cnb-author" href="javascript:void(0);">{{ $book->author }}</a></p>

                                <?php $rateAvg = $book->rates()->avg('point'); ?>
                                <p class="yb-cnb-views">
                                    <span>{{ $rateAvg ? $rateAvg : 0 }} <i class="fa fa-star icon-rate"></i></span>
                                    - {{ $book->views }} views
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
        @endforeach
        <!--END CHANNEL-->
        </div>
    </div>
@endsection
