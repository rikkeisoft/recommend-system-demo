@extends('layouts.app')

@section('title')
    {{ $category->name }} - YouBook
@endsection

@section('content')
    <div class="yb-page-container">
        <div class="yb-page-content">
            @if(count($authors))
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
            @else
                <h3 class="center" style="padding: 20px 0;">No results found</h3>
            @endif
        </div>
    </div>
@endsection('content')