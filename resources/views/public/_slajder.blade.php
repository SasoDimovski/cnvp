<section class="master-custom master-widget-slider-home2">
    <div class="">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($records_cover as $record_cover)
                <li data-target="#myCarousel" data-slide-to="{{$loop->iteration}}" class="@if ($loop->first) active @endif"></li>
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @foreach($records_cover as $record_cover)
                    <div class="item @if ($loop->first)
                        active
@endif" style="background-image: url('/upload/records/{{ $record_cover->id }}/{{ $record_cover->picture_file }}'); " onclick="window.open('{{ url($lang.'/record/'.$record_cover->id_menu.'/'.$record_cover->id.'/'.$record_cover->slug) }}','_self');">
                        <div class="carousel-caption">
                            <h3>{{ $record_cover->title }}</h3>
                        </div>
                    </div>

                @endforeach


            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>



</section>

