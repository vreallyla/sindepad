@section('title-right','Form Kegiatan')
@section('content-right')
    <form class="sche-show">
        <div class="form-group"><label class="control-label">Nama Jadwal :</label> <input type="text"
                                                                                            class="form-control"
                                                                                            name="name"
                                                                                            placeholder="">
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Detail :</label>
            <textarea name="desc" id="" cols="30" rows="4" class="form-control"></textarea>
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Daftarkan</button>
        </div>
    </form>
    <form style="display: none;">
        <div class="form-group"><label class="control-label">Kegiatan :</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                <select class="selectpicker anu" name="sel_act" data-live-search="true" data-container="body">
                    <option data-tokens="" value="" selected disabled="true"></option>
                    @foreach($sche as $row)
                        <option data-tokens="{{$row->name}}" value="{{$row->id}}" data-time="{{$row->time}}">{{$row->code.' - '.$row->name.' - '.$row->time.' menit'}}</option>
                    @endforeach

                </select>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">

            <input type="text"
                   class="form-control"
                   name="act_other"
                   placeholder="">
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
                <label>
                    <input type="checkbox"
                           name="con"
                           placeholder=""> Kegiatan Lain
                </label>
            </div>
            <span class="help-block"></span>
        </div>
        <div class="form-group"><label class="control-label">Waktu :</label>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <input type="time"
                           class="form-control"
                           name="time_start">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <input type="time"
                           class="form-control"
                           name="time_end">
                </div>
            </div>
            <span class="help-block"></span>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-info">Daftarkan</button>
        </div>
    </form>

@endsection
