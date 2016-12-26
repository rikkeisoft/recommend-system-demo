@extends('layouts.app')

@section('title')
    {{ old('search_query') }} - YouBook
@endsection

@section('content')
    <div class="yb-page-container">
        <div class="yb-search-container">
            <div class="ybs-intro">
                <p class="ybs-result-title right">About 69.999 results</p>
            </div>
            @for($i = 0; $i < 10; $i++)
                <section class="ybs-book">
                    <div class="ybs-content">
                        <div class="ybs-image fl-left">
                            <a href="{{ url('detail') }}">
                                {{ Html::image('public/images/demo1.jpg', null, ['class' => 'img-ybs-book']) }}
                            </a>
                        </div>

                        <div class="ybs-info fl-left">
                            <a class="ybs-title bold" href="{{ url('detail') }}">Something i need</a>
                            <a class="yb-cnb-author" href="javascript:void(0);">Aiflytomydr</a>

                            <p class="yb-cnb-views">69.699 views</p>
                        </div>
                    </div>
                </section>
            @endfor
        </div>
    </div>
@endsection
