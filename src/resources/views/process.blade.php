@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 10rem;">
    <div class="row justify-content-center"> 
        <div class="col-md-8"> 
            <div class="card"> 
                <div class="card-header">
                    Executa o processamento da fila
                </div> 

                <div class="card-body"> 
                    <process-button></process-button>
                </div> 
            </div>
        </div>  
    </div> 
</div>
@stop