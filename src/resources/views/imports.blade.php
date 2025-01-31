@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 10rem;">
    <div class="row justify-content-center"> 
        <div class="col-md-8"> 
            <div class="card"> 
                <div class="card-header">
                    Adicionar Arquivos
                </div> 

                <div class="card-body"> 
                    <file-upload :input_name="'arquivos[]'" :post_url="'files/upload'"></file-upload>
                 </div> 
            </div>
        </div>  
    </div> 
</div>
@stop