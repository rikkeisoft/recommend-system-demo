@extends('layouts.app')

@section('title')
    {{ $book->title }} - YouBook
@endsection

@section('content')
    <div class="yb-page-container">
        <div class="yb-page-content">
            <div class="yb-dt-container">
                <section class="yb-dt">
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
                            <p class="yb-dt-point fl-left">
                                <?php $rateAvg = $book->rates()->avg('point'); ?>
                                <span class="yb-rate-value">{{ $rateAvg ? round($rateAvg, 2) : 0 }}</span>
                                <i class="fa fa-star icon-rate"></i>
                            </p>
                            <div class="stars fl-right">
                                <?php
                                    $radioClass = [];
                                    for($i = 1; $i <= $rate_avg; $i++){
                                        $radioClass[$i] = 'active';
                                        if($rate_avg == 1){
                                            $radioClass[1] = 'active bad';
                                        }
                                    }
                                ?>
                                <form id="frm-rate" d-book="{{ $book->id }}" action="" class="fl-right">
                                    <input class="star star-5" id="star-5-2" type="radio" name="rate" value="5"/>
                                    <label class="star full {{ isset($radioClass[5]) ? $radioClass[5] : '' }}" for="star-5-2"></label>
                                    <input class="star star-4" id="star-4-2" type="radio" name="rate" value="4"/>
                                    <label class="star full {{ isset($radioClass[4]) ? $radioClass[4] : '' }}" for="star-4-2"></label>
                                    <input class="star star-3" id="star-3-2" type="radio" name="rate" value="3"/>
                                    <label class="star full {{ isset($radioClass[3]) ? $radioClass[3] : '' }}" for="star-3-2"></label>
                                    <input class="star star-2" id="star-2-2" type="radio" name="rate" value="2"/>
                                    <label class="star full {{ isset($radioClass[2]) ? $radioClass[2] : '' }}" for="star-2-2"></label>
                                    <input class="star star-1" id="star-1-2" type="radio" name="rate" value="1"/>
                                    <label class="star full {{ isset($radioClass[1]) ? $radioClass[1] : '' }}" for="star-1-2"></label>
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
