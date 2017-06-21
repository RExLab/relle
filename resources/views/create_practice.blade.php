@section('inside-head')
@extends ('layout.default')
@section('head')
@stop
@section ('content') 
<h2 style="text-align:center"> Criar prática</h2>

  <form class="form-horizontal" method="post"  action="createpratica" enctype="multipart/form-data">
     
    <div class="form-group">
      <label class="control-label col-sm-3">Nome:</label>
      <div class="col-sm-9">
        <input name="nome" type="text" class="form-control" id="nome" placeholder="Insira o nome da prática">
        @if ($errors->has('nome')) <p class="text-danger">{{ $errors->first('nome') }}</p> @endif
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="descri">Descrição:</label>
      <div class="col-sm-9">          
          <textarea name="descri" type="textarea" class="form-control" id="descri" placeholder="Insira a descrição"> </textarea>
          @if ($errors->has('descri')) <p class="text-danger">{{ $errors->first('descri') }}</p> @endif
      </div>
    </div>
    <div class="form-group">  
        <label class="control-label col-sm-3"> Imagem da prática no VISIR </label>
      <div class="col-sm-9">
          <span class="btn btn-default btn-file">
              <span class="fileinput-new">   Selecionar </span>
          <input type='file' value="Selecionar"  name='img_visir'/>
          </span>
           @if ($errors->has('img_visir')) <p class="text-danger">{{ $errors->first('img_visir') }}</p> @endif
      </div>
    </div>
      <div class="form-group">  
        <label class="control-label col-sm-3"> Imagem do diagrama da prática </label>
      <div class="col-sm-9">
          <span class="btn btn-default btn-file">
              <span class="fileinput-new">  Selecionar </span>
            <input type='file' value="Selecionar" name='img_diagrama'/>
              </span>
            @if ($errors->has('img_diagrama')) <p class="text-danger">{{ $errors->first('img_diagrama') }}</p> @endif
      </div>
    </div>
      <div class="form-group"> 
          <label class="control-label col-sm-3"> Arquivo CIR  </label>
      <div class=" col-sm-9">
       <input type='file' name='arquivo' placeholder="Faça o upload do arquivo cdr"/>
       @if ($errors->has('arquivo')) <p class="text-danger">{{ $errors->first('arquivo') }}</p> @endif
       </div>
    </div>
       <div class="form-group"> 
          <label class="control-label col-sm-3"></label>
      <div class=" col-sm-9">
          <input type='submit' class="btn btn-primary"  />
       </div>
    </div>
  </form>
@stop
