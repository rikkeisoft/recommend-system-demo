@extends('layouts.app')

@section('title')
    {{ old('search_query') }} - YouBook
@endsection

@section('content')
    <div class="yb-page-container">
        <div class="yb-search-container">
            <div class="ybs-intro">
                <p class="ybs-result-title right">About {{ count($books) }} results</p>
            </div>
            @if(count($books))
                @foreach($books as $book)
                    <section class="ybs-book">
                        <div class="ybs-content">
                            <div class="ybs-image fl-left">
                                <a href="{{ url('show/' . $book->id) }}">
                                    {{ Html::image($book->cover, null, ['class' => 'img-ybs-book']) }}
                                </a>
                            </div>

                            <div class="ybs-info fl-left">
                                <a class="ybs-title bold" href="{{ url('show/' . $book->id) }}">{{ $book->title }}</a>
                                <a class="yb-cnb-author" href="javascript:void(0);">{{ $book->author }}</a>
                                
                                <?php $rateAvg = $book->rates()->avg('point'); ?>
                                <p class="yb-cnb-views">
                                    <span>{{ $rateAvg ? $rateAvg : 0 }} <i class="fa fa-star icon-rate"></i></span> - {{ $book->views }} views
                                </p>
                            </div>
                        </div>
                    </section>
                @endforeach
            @else
                <h3 class="center">No results found</h3>
            @endif
        </div>
    </div>
@endsection
