@extends('layouts.side_user')
@section('desc','invoice sanggar abk')
@section('key','abk, disablitas, difabel, slb')
@section('content')
    <div class="col-lg-12 obj-contido">
        <div class="tarxeta-contido">
            @foreach(\App\Model\order\payingMethod::where('method',"Bayar Ditempat")->get() as $row)
                <div class="tarxeta-titulo pagamento-metodo deslizamento cod">
                    <input type="radio" name="metodo" id="metodo">
                    <label class="comprobar" for="metodo"></label>
                    <input type="radio" name="obj_metodo" id="metodo" value="{{$row->id}}">
                    {{$row->method}}
                </div>
                <div class="pagamento-contido">
                    {!!$row->desc!!}
                </div>
            @endforeach
            <div class="tarxeta-titulo pagamento-metodo deslizamento tf">
                <input type="radio" name="metodo" id="metodo1">
                <label class="comprobar" for="metodo1"></label>
                Transfer Bank
            </div>
            <div class="pagamento-contido">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        Pilih Bank
                    </div>
                    @foreach(\App\Model\order\payingMethod::where('method',"Transfer")->get() as $i=>$row)
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagamento-cotenta">
                                    <input type="radio" name="obj_metodo" id="radio{{$i}}" value="{{$row->id}}">
                                    <label for="radio{{$i}}" class="pagamento-radio"></label>
                                    <img class="pagamento-imaxe"
                                         src="{{asset($row->url)}}"
                                         alt="">
                                    <h4 class="pagamento-titulo">{{$row->name}}</h4>
                                    <h6 class="pagamento-aviso">Menerima transfer dari semua bank</h6>
                                    <h6 class="pagamento-aviso-ben">{!! $row->desc!!}</h6>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="btn-submit">
                <button>Ubah Metode</button>
            </div>
        </div>
    </div>
@endsection

@push('style')

    <style>
        .btn-submit button:hover{
            background: #297c87;
        }
        .btn-submit button{
            width: 100%;
            margin: 1.4em 0;
            padding: 11px 0px;
            font-size: 1em;
            color: #fff;
            background: #3abac6;
        }

        .tarxeta-titulo {
            padding: 7px 19px 6px 19px;
            background-color: #fafafa;
            border-bottom: 1px solid #eee;
        }

        .tarxeta-contido {
            margin: 16px 17px 18px 17px;
        }

        input[name="obj_metodo"]:checked + label,
        input[name="obj_metodo"]:not(:checked) + label {
            margin-right: 6px;
        }

        input[name="obj_metodo"]:checked + label:before,
        input[name="obj_metodo"]:not(:checked) + label:before {
            content: '';
            display: inline-block;
            position: relative;
            right: 0px;
            top: 4px;
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 8px;
            -webkit-transition: all 0.8s ease;
            transition: all 0.8s ease;
        }

        input[name="obj_metodo"]:checked + label:after,
        input[name="obj_metodo"]:not(:checked) + label:after {
            content: '\F00C';
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
            display: inline-block;
            color: #00a69c;
            position: absolute;
            left: 16px;
            bottom: 1px;
            font-size: 19px;
            -webkit-transition: all 0.8s ease;
            transition: all 0.8s ease;
            border-radius: 4px;
        }

        input[name="obj_metodo"]:not(:checked) + label:after {
            opacity: 0;
            -webkit-transform: scaleZ(0);
            transform: scaleZ(0);
        }

        input[name="obj_metodo"]:checked + label:before {
            border: 2px solid #00a69c;
        }

        input[name="obj_metodo"] + label:before {
            border: 1px solid #ddd;
        }

        input[name="obj_metodo"]:checked + label:after {
            opacity: 1;
            -webkit-transform: scaleZ(1);
            transform: scaleZ(1);
        }

        .pagamento-metodo {
            cursor: pointer;
        }

        .comprobar {
            margin-left: 5px;
        }

        input[name="metodo"]:checked + .comprobar:after,
        input[name="metodo"]:not(:checked) + .comprobar:after {
            content: '';
            width: 10px;
            display: inline-block;
            height: 10px;
            background: #00a69c;
            position: relative;
            right: 20px;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
            border-radius: 4px;

        }

        input[name="metodo"]:checked + .comprobar:before,
        input[name="metodo"]:not(:checked) + .comprobar:before {
            content: '';
            display: inline-block;
            position: relative;
            right: 5px;
            top: 5px;
            width: 21px;
            height: 21px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 8px;
        }

        input[name="metodo"]:not(:checked) + .comprobar:after {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        input[name="metodo"]:checked + .comprobar:after {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .deslizamento:before {
            content: '\F138';
            font-family: FontAwesome;
            font-weight: normal;
            font-style: normal;
            text-decoration: none;
            position: absolute;
            right: 53px;
            font-size: 22px;
            color: #9ea9a7;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        .pagamento-metodo.deslizamento:before {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        .pagamento-metodo.activo.deslizamento:before {
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .pagamento-contido label,.deslizamento label{
            cursor: pointer;
        }
        .pagamento-contido {
            background: #fff;
            border-bottom: 1px solid #eee;
            border-left: 1px solid #e9e6e6;
            border-right: 1px solid #e9e6e6;
            padding: 15px 25px;
            -webkit-transition: all 1s ease;
            transition: all 1s ease;
        }

        .pagamento-metodo + .pagamento-contido {
            display: none;
            opacity: 0;
            -webkit-transform: scaleY(0);
            transform: scaleY(0);
        }

        .pagamento-metodo.activo + .pagamento-contido {
            display: block;
            opacity: 1;
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
        }

        .pagamento-cotenta {
            margin-bottom: 21px;
            cursor: pointer;
        }

        .pagamento-imaxe {
            width: 70px;
        }

        .pagamento-titulo {
            position: absolute;
            left: 118px;
            top: -12px;
        }

        .pagamento-aviso {
            position: absolute;
            left: 118px;
            top: 11px;
            color: #6c6c6c;
        }

        .pagamento-aviso-ben {
            position: absolute;
            right: 6px;
            bottom: 2px;
            color: #3abac6;
        }

        [type="radio"]:checked,
        [type="radio"]:not(:checked) {
            position: absolute;
            left: -9999px;
        }

        @media (max-width: 483px) {
            .obj-contido{
                padding: 0;
            }
        }
        @media (max-width: 453px) {
            .pagamento-aviso-ben{
            display: none;
            }

        }

    </style>

@endpush

@push('js')
   @include('user.order.method_tf.js_method_tf.method_tf_async')
@endpush