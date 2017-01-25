<?php
$i = 0;
$count = 0;
$active = 'active';
?>

<div class="container">
    <div id="main_area">
        <!-- Slider -->
        <div class="row" style="margin-top:35px">
            <div class="col-xs-12" id="slider">
                <!-- Top part of the slider -->
                <div class="row">
                    <div class="col-sm-8" id="carousel-bounding-box">
                        

                        <div class="carousel slide" id="myCarousel">
                            <!-- Carousel items -->
                            <div class="carousel-inner">
                                @foreach($labs as $lab)
                                <?php
                                if ($i != 0) {
                                    $active = '';
                                }
                                if (status($lab->id)) {
                                    ?>
                                    <div class="item {{$active}}" data-slide-number="{{$i}}">
                                        <img src="{{asset($lab->thumbnail)}}" class="item-img">
                                    </div>
                                    <?php
                                    $i++;
                                }
                                ?>
                                @endforeach
                            </div><!-- Carousel nav -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>                                       
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>                                       
                            </a>                                
                        </div>

                    </div>

                    <div class="col-sm-4" id="carousel-text"></div>

                    <div id="slide-content" style="display: none;">
                        <?php $i = 0; ?>
                        @foreach($labs as $lab)
                        <?php if (status($lab->id)) { ?>
                            <div id="slide-content-{{$i}}">
                                <h3 style="font-size:30px;">{{$lab->$name}}</h3>
                                <p style='line-height: 1.2'><?php echo $lab->$desc; ?></p>
                                <a href="{{url('/labs/'.$lab->id)}}" class="btn btn-primary"  role="button">{{trans('interface.access')}}</a>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                        @endforeach

                    </div>
                </div>
            </div>
        </div><!--/Slider-->
<!--
        <div class="row hidden-xs" id="slider-thumbs">
            <ul class="hide-bullets">
                <?php $i = 0; ?>
                @foreach($labs as $lab)
                <?php if (status($lab->id)) { ?>
                    <li class="col-sm-1">
                        <a class="thumbnail" id="carousel-selector-{{$i}}"><img src="{{asset($lab->thumbnail)}}"></a>
                    </li>
                    <?php
                    $i++;
                }
                ?>
                @endforeach
            </ul>                 
        </div>
    -->
    </div>
</div>

<script>
    $(function () {

        $('#myCarousel').carousel({
            interval: 5000
        });

        $('#carousel-text').html($('#slide-content-0').html());

        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click(function () {
            var id = this.id.substr(this.id.lastIndexOf("-") + 1);
            var id = parseInt(id);
            $('#myCarousel').carousel(id);
        });


        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid.bs.carousel', function (e) {
            var id = $('.item.active').data('slide-number');
            $('#carousel-text').html($('#slide-content-' + id).html());
        });
    });
</script>