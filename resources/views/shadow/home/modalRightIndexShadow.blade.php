@section('title-right','Daftar Peserta Didik')
@section('content-right')
    @if(!empty($student))
        @foreach($student as $row)
            <div class="user-list-right col-lg-12 col-md-12 col-sm-12 col-xs-12" data-key="{{$row->id}}">
                <div class="cover-img-right col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <img src="{{$row->img}}"
                         alt="{{$row->name}}">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 content-user-right">
                    <h5>{{$row->name}}</h5>
                    <span>{{$row->ni}}</span>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center">
            Data Belum tersedia
        </div>
    @endif
@endsection
