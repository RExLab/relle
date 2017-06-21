@extends ('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('book.title_page')])}}
{{$lang = "name_". App::getLocale() }}
{{$user = 'admin'}}
@stop

@section('title_inside')
{{trans('book.title_page')}}
@stop

@section ('inside')

<style>
    #x:hover {
    opacity: 0.8;
    filter: alpha(opacity=80);
}    
</style>

<div class="table-responsive">
    <table class="table">
        <tr>
            <td></td>
            <td id='userName1'><strong>{{trans('book.user')}} </strong></td>
            <td><strong>{{trans('book.date')}} </strong></td>
            <td><strong>{{trans('book.time')}} </strong></td>
            <td><strong>{{trans('book.durac')}}</strong></td>
            <td><strong>{{trans('book.exp')}}  </strong></td>
            <td><strong>{{trans('book.token')}}</strong></td>
            <td></td>
        </tr>
        
        @foreach ($bookings as $booking)
            @if ($booking->username == Auth::user()->username || Auth::user()->username == 'admin' )
            <tr> 
                <td></td>
                <td id='userName2'>{{$booking->username}}</td>
                <td>{{$booking->date}}</td>
                <td>{{$booking->time}}</td>
                <td>{{$booking->duration}} min</td>
                <td>{{$booking->$lang}}</td>
                <td id='x' style="font-size: 15px"><strong>{{$booking->token}}</strong></td>
                <td><a href="#" <span class="fui-cross" value="Reload Page" onclick='bookingDelete({{$booking->id}})'/></a></td>
            </tr>
            @endif
        @endforeach 
    </table>
    @if(Auth::user()->username != 'admin')
    <style>
        #userName1{
            display:none;
        }
        
        #userName2{
            display:none;
        }   
    </style>
    @endif
    
    @if (sizeof($bookings) == 0)
    <style>
       .block {
        height: 151px;
        width: auto;
       }
       #text2{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.5;
        }
        td{
            display:none;
        }
        </style>
        <div class="block"><a href="http://relle.ufsc.br/teste/booking/create"></a></div>
        <h1 id="text2" style="font-size: 15px;">Não existem Agendamentos :(</h1>     
    @endif
</div>

<script>
    function deleteDocs(id) {
        $.ajax({
            method: "DELETE",
            url: "",
            data: {"id": id}
        })
        .done(document.location.reload(true))   
    }

</script>

@stop
