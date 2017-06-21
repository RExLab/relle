@section('inside-head')
@extends ('layout.default')
@section('head')
<link href="{{ asset('/css/repositorio.css') }}" rel="stylesheet">
<link href="{{ asset('/css/zoom.css') }}" rel="stylesheet">
 <script> src="js/zoom.js"   </script>
 <script> src="js/zoomerang.js"   </script>
@stop
@section ('content')  
 <h1 style="text-align:center"> Repositório de Práticas VISIR  </h1>
 <h2 style="text-align:center"> Práticas Circuitos Elétricos </h2>
 <ul  id="ulItens" style="list-style-type: none" class="collection row">
     <!--{{Form::open(array('url'=>'searchpraticas'))}}
     {{Form::text('terms','',array('placeholder' => 'Digite aqui um termo para filtrar...')) }}
     {{Form::submit('Pesquisar')}}
     {{Form::close() }} -->
     <form method="post"  action="searchpraticas">
        <input type="text" size="50" name='terms' placeholder="Digite aqui um x termo para filtrar..."/>    <button type="submit"> <span class="glyphicon glyphicon-search" aria-hidden="true"> </span> </button>
     <br> <br>
     
 @foreach($praticas as $pratica) 
 <li class="collection-item row">  <a class="col-lg-3 col-md-3 col-sm-3 " href="{{$pratica->img_visir}}"> <img  width="250" src="{{$pratica->img_visir}}"> </a> 
        <p class="col-lg-6 col-md-6 col-sm-6"> <strong name='nome'> {{$pratica->nome}}</strong>   <br>
            <strong name='descri' > Descrição: </strong> {{$pratica->descri}}  <br> 
            <a class=" btn btn-primary" href="{{$pratica->arquivo}}" download> <span class="glyphicon glyphicon-save"></span> Download</a></p>
        <span id="img_diagrama" class="zoom-img"> <a href="{{$pratica->img_diagrama}}" ><img class="exp-img col-lg-3 col-md-3 col-sm-3 "data-action="zoom" width="400" src="{{$pratica->img_diagrama}}"></a> </span>
    </li>
  <br>
  @endforeach 
   </form>
   </ul>
  
<script type="text/javascript">
$(function(){
	$("#txtBusca").keyup(function(){
		var texto = $(this).val();
		
		$("#ulItens li").css("display", "block");
		$("#ulItens li").each(function(){
			if($(this).text().indexOf(texto) < 0)
			   $(this).css("display", "none");
		});
	});
});
</script>
@stop
