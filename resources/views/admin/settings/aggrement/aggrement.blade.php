@extends('layouts.other_side')
@section('content')
    <div id="aggrement">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form method="post">
            <textarea id="description" name="detail">
{!! $aggrement->detail !!}
            </textarea>
            </form>
            <button class="btn btn-info btn-save-aggrement">Simpan <i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
@endsection

@push('js')

    @endpush

