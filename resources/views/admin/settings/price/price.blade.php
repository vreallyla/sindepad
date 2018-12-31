@extends('layouts.other_side')
@section('content')
    <div id="settings-price">
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 table-register">
            <table class="table">
                <thead>
                <tr>
                    <th>Nama</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td><span class="label label-info" data-toggle="tooltip" data-placement="right"
                              title="Tooltip on right"> Anak</span></td>
                    <td>
                        <span class="add-rp">{{number_format(2000000000,0,',','.')}}
                        </span>
                        <input type="text" class="form-control input-rp" name="amount" style="display: none"></td>

                    <td>
                        <button class="btn btn-info">Rubah</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        @include('admin.general.notice')
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/autonumeric/2.0.0/autoNumeric.min.js"></script>

    @endpush