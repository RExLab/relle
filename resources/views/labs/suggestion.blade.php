        
            <!--Suggestions -->
            <h5 style="font-weight:normal; padding-top:50px">{{trans('labs.similar')}}</h5>
            <div class="row">
                @foreach($suggestions as $lab)
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="panel panel-default" style="background: #ECF0F1; ">
                        <div class="panel-body sug">
                            <div class="row">
                                <div class='col-lg-5 col-md-5 col-sm-2'>
                                    <img src="{{asset($lab->thumbnail)}}" width="100%">
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-10">
                                    <b style="line-height: 1.50">{{$lab->$name}}</b>
                                    <p style="font-size:11pt; line-height: 1.2; padding-top:5px;"><?php echo $lab->$desc; ?></p>
                                    <a href="{{url('/labs/'.$lab->id)}}" class="btn btn-xs btn-primary" role="button">{{trans('interface.access')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Facebook Comments -->
            <h5 style="font-weight:normal; padding-top:50px">{{trans('interface.comments')}}</h5>
            <div class="fb-comments" data-href="{{Request::url()}}" data-width="100%" data-numposts="10"></div>

