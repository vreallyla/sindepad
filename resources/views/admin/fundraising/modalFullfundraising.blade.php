<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 modal-full">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-modal">
        <span class="btn-back"><i class="fa fa-arrow-left"></i></span>
        <h4>Form Informasi</h4>
    </div>
    <form>
        <div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10 col-xs-12 body-modal for-input">
            <div class="header-card-profil col-lg-12 col-md-12 col-sm-12 col-xs-12 radius-bottom-modif padding-modif">
                <div class="header-card-profi-bg modif-img-activity" style="border: 3px solid #b9b9b9;">
                    <img src="https://res.cloudinary.com/anewmodern/image/upload/v1505521193/blurry-city-light-wallpaper-1_fswgtt.jpg"
                         alt="" class="remove-effect" style="display: none">
                    <div class="add-img-modal">
                        <i class="fa fa-plus-square"></i>
                        <h3>Tambah Gambar</h3>
                    </div>
                    <input type="file" name="imgUp" onchange="readURL(this);"
                           accept="image/*">
                </div>
                <label class="help-block"></label>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 card-notice img-conf radius-top-modif remove-margin-top border-left-right"
                 style="margin-bottom: 4em">
                <div class="title-tf-info center-hp">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 for-input">
                        <input type="text" class="form-control" name="name"
                               placeholder="Judul">
                        <label class="help-block"></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 for-input">
                        <input type="text" class="form-control input-rp" name="target"
                               placeholder="Target Sumbangan">
                        <label class="help-block"></label>
                    </div>
                </div>
                <div class="act-fill-sub">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 for-input" style="padding-top: 10px">
                        <textarea id="description" name="detail"></textarea>
                        <label class="help-block"></label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fill-pers-info btn-add-sub">
                        Tambah Sub Kegiatan
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>