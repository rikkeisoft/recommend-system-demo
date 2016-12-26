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
                    @foreach($recommendBooks as $book)
                        <div class="yb-cn-book">
                            <a href="{{ url('show/' . $book->id) }}">
                                {{ Html::image($book->cover, null, ['class' => 'img-ybcn-book']) }}
                            </a>

                            <p>
                                <a class="yb-cnb-title bold"
                                   href="{{ url('show/' . $book->id) }}">{{ $book->title }}</a>
                            </p>

                            <p><a class="yb-cnb-author" href="javascript:void(0);">{{ $book->author }}</a></p>

                            <p class="yb-cnb-views">{{ $book->views }} views - 1 month ago</p>
                        </div>
                    @endforeach
                </div>
            </section>
            @foreach($authors as $author)
                <section class="yb-channel">
                    <h4 class="yb-cn-intro">{{ $author->author }}</h4>

                    <div class="yb-cn-container">
                        <div class="yb-cn-row">
                            @foreach($author->listBooks as $book)
                                <div class="yb-cn-book">
                                    <a href="{{ url('show/' . $book->id) }}">
                                        {{ Html::image($book->cover, null, ['class' => 'img-ybcn-book']) }}
                                    </a>

                                    <p><a class="yb-cnb-title bold"
                                          href="{{ url('show/' . $book->id) }}">{{ $book->title }}</a></p>

                                    <p><a class="yb-cnb-author" href="javascript:void(0);">{{ $book->author }}</a></p>

                                    <p class="yb-cnb-views">{{ $book->views }} views - 1 month ago</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    </div>
@endsection
