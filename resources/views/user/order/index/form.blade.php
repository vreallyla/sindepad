<div class="row">
    <div class="col-lg-12 order-adding">
        <div class="row">
            <h4 class="title-tab">formulir pendaftaran</h4>
            <div class="pull-right">
                <div class="col-lg-12 add-min"><label
                            style="font-size: 17px;color: #7f7f7f;font-weight: normal">
                        Pendaftar(<span class="entity-order">{{$entity}}</span>)
                        :</label>
                    <button type="button" class="btn min-order"
                            style="height:34px; background: #dddddd;color: #535353"><i
                                class="fa fa-minus"></i></button>
                    <button type="button" class="btn add-order" style="height:34px;">
                        <i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="accordion" id="step1">
            <dl>
                @for($i=0;$i<$entity;$i++)
                    <dt>
                        <a href="#accordion{{$i+1}}" aria-expanded="false"
                           aria-controls="accordion{{$i+1}}"
                           class="accordion-title accordionTitle js-accordionTrigger">
                            <span class="content-accord">Pendaftar #{{$i+1}}{{' '.session('reg')['name']}}</span>
                            <span class="pull-right remove-accordion"
                                  data-toggle="tooltip"
                                  data-placement="right" title="Tutup"
                                  style="display: none">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                        </a>
                    </dt>
                    <dd class="accordion-content accordionItem is-collapsed"
                        id="accordion{{$i+1}}"
                        aria-hidden="true">
                        <div class="row">
                            <div class="col-lg-6 add-margin-bottom-sm">
                                <label for="name">Nama :</label>
                                <input type="text" name="fullName[]"
                                       placeholder="Nama siswa yang mendaftar"
                                       class="form-control modify-input change-tittle fullName"
                                       value="{{session('reg')['name']}}"

                                       data-index="0">
                                <span class="help-block"
                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                            </div>
                            <div class="col-lg-6 add-margin-bottom-sm">
                                <label for="sex">Jenis Kelamin :</label>
                                <select name="sex[]" id="sex"
                                        class="form-control modify-input sex">
                                    <option value="" selected disabled>------ pilih
                                        jenis
                                        kelamin ------
                                    </option>
                                    @foreach($gender as $row)
                                        <option value="{{$row->id}}"
                                                {{session('reg')['sex']===$row->id?'selected':''}}>{{$row->ind}}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"
                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                            </div>
                            <div class="col-lg-6 add-margin-bottom-sm">
                                <label for="rs">Hubungan dengan Anak :</label>
                                <select name="rs[]" id="" class="form-control rs">
                                    <option value="" disabled selected>------ pilih
                                        hubungan
                                        ------
                                    </option>
                                    @foreach($rs as $row)
                                        <option value="{{$row->id}}"
                                                {{session('reg')['rel']===$row->id?'selected':''}}>{{$row->ind}}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"
                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                            </div>
                            <div class="col-lg-6 add-margin-bottom-sm">
                                <label for="needed">Kebutuhan :</label>
                                <select name="needed[{{$i}}][]" id=""
                                        class="form-control selectpicker needed"
                                        data-container="body" multiple>
                                    @foreach($dis as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"
                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                            </div>
                            <div class="col-lg-12">
                                <label for="desc">Catatan :</label>
                                <textarea name="desc[]"
                                          placeholder="Jika ada tambahan tulis disini."
                                          class="form-control modify-input desc">{{session('order')&&array_key_exists('desc',session('order')['data'][$i])?session('order')['data'][$i]['desc']:''}}</textarea>
                                <span class="help-block"
                                      style="display: none">
                                                                <strong></strong>
                                                            </span>
                            </div>
                        </div>
                    </dd>
                @endfor
            </dl>
        </div>
    </div>
</div>
