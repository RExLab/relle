@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('docs.title_page')])}}
@stop

@section('title_inside')
{{trans('docs.title_page')}}
@stop

<!--{{$name='name_'.App::getLocale()}}
{{$desc='description_'.App::getLocale()}}-->


@section ('inside')
<div class="table-responsive">
    <table class="table">
        <tr>
            <td></td>
            <td>{{trans('docs.title')}}</td>
            <td>{{trans('docs.type')}}</td>
            <td>{{trans('docs.size')}}</td>
            <td>{{trans('docs.modified')}}</td>
            <td></td>
        </tr>
        
        @foreach($docs as $doc)

        <tr>
            <td><img src="{{asset('img/docs/'.formatIcon($doc['format']).'.png')}}" height="35px"></td>
            <td>{{$doc['title']}}</td>
            <td>{{trans('docs.'.$doc['type'])}}</td>
            <td>{{formatSize($doc['size'])}}</td>
            <td>{{ date('d/m/Y H:i', strtotime($doc['created_at']))}}</td>
            <td>
                <a href="{{asset($doc['url'])}}"><img src="{{asset('img/docs/download.png')}}" height="25px"></a>
            </td>
        </tr>
        @endforeach
        
    </table>
</div>
@stop


