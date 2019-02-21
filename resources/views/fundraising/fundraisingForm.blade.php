<div role="tabpanel" class="tab-pane" id="forms">
    <div class="ed_course_tabconetent">
        @if($dataN->data->category==='proccess')
            <div class="col-lg-12 col-md-12 col-sm-12"  style="padding-bottom: 1em">
            <h2>Formulir Penyumbang</h2>
                <span style="color: #5d5454">Harap mengisi formulir jika sudah transfer sumbangan.</span>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0;">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="imgUp">Bukti Transfer</label>
                            <input type="file" id="imgUp" name="imgUp" class="form-control" accept="image/*" required>
                            <span class="help-block"></span>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="name">Atas Nama</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nama sesuikan dengan Bukti Transfer" required>
                            <input type="hidden" name="key_sumb" value="{{$dataN->data->key}}">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="example@example.com" required>
                            <span class="help-block"></span>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="nominal">Jumlah Transfer</label>
                            <input type="text" id="nominal" name="nominal" class="form-control input-rp" placeholder="Rp 1000.000" required>
                            <span class="help-block"></span>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="date_trans">Tanggal Transfer</label>
                            <input type="text" id="date_trans" name="date_trans" class="form-control datepicker" placeholder="yyy-mm-dd" required>
                            <span class="help-block"></span>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info">Daftarkan</button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <h2>Formulir Penyumbang Telah Ditutup, Penggalangan Dana Sudah Mencapai Target</h2>
        @endif

    </div>
</div>

@push('js')
    <script>
        $('.datepicker').datepicker({
            language:'id',
            format:'yyyy-mm-yy'
        });
    </script>
    @endpush