<section class="yb-recommend-layout">
    <h4 class="yb-cn-intro">Recommended</h4>

    @foreach($recommendBooks as $book)
        <div class="yb-sg-book">
            <div class="yb-sg-image">
                <a href="{{ url('show/' . $book->id) }}">
                    {{ Html::image($book->cover, null, ['class' => 'img-ybsg-book']) }}
                </a>
            </div>

            <div class="yb-sg-info">
                <a class="yb-sgb-title bold" href="{{ url('show/' . $book->id) }}">{{ $book->title }}</a>
                <a class="yb-cnb-author" href="javascript:void(0);">{{ $book->author }}</a>
                
                <?php $rateAvg = $book->rates()->avg('point'); ?>
                <p class="yb-cnb-views">
                    <span>{{ $rateAvg ? $rateAvg : 0 }} <i class="fa fa-star icon-rate"></i></span> - {{ $book->views }} views
                </p>
            </div>
        </div>
    @endforeach
</section>