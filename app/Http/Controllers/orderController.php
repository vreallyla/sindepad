<?php

namespace App\Http\Controllers;

use App\DeclaredPDO\Jwt\extraClass;
use App\linkStudentFamily;
use App\Model\general\dataBank;
use App\Model\linkUserStudent;
use App\Model\mstClass;
use App\Model\mstDisability;
use App\Model\mstTransactionList;
use App\Model\order\payingMethod;
use App\Model\order\rsTransPrice;
use App\Model\order\sideTypePrice;
use App\Model\order\voucherRegister;
use App\Model\rsDisability;
use App\Model\sideDaylist;
use App\Model\sideGender;
use App\Model\sideTimeList;
use App\mstHub;
use App\rsStudentFamily;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DeclaredPDO\allNeeded as Selingan;
use App\Model\order\expression;
use Illuminate\Support\Facades\File;

const HOMOTYPE = 'bila tidak transaksi akan dibatalkan secara otomatis.',
types = ['name', 'sex', 'packet', 'course', 'rs', 'needed', 'desc'],
noticeDescrib = [
    'menunggu' => [
        'title' => 'Konfirmasi Transaksi',
        'content' => 'konfirmasi transaksi',
        'status' => 'confirm',
        'desc' => HOMOTYPE
    ], 'konfirmasi' => [
        'title' => 'Menunggu Pembayaran',
        'content' => 'melakukan pembayaran',
        'status' => 'payment',
        'desc' => HOMOTYPE
    ], 'batal' => [
        'title' => 'Transaksi Dibatalkan',
        'content' => 'Transaksi dibatalkan',
        'status' => 'failed',
        'desc' => 'karena melewati batas waktu'

    ], 'berhasil' => [
        'title' => 'Transaksi Berhasil',
        'content' => 'Transaksi berhasil',
        'status' => 'success',
        'desc' => 'Terima kasih atas kepercayaan anda.'
    ], 'administrasi' => [
        'title' => 'Menunggu Konfirmasi',
        'content' => 'Bukti pembayaran berhasil dikirim',
        'status' => 'waiting',
        'desc' => 'Kami akan segera konfirmasi kurang dari 24 jam.'
    ]
];

class orderController extends Controller
{
    use extraClass;

    protected $data_session = array();
    protected $step = 1;

    public function __construct()
    {
        $this->middleware('order');
        $this->middleware('method_permissions')->only('info', 'confirm');
    }

    public function method(Request $r)
    {
        $title = 'Ubah Metode Pembayaran';
        return view('user.order.method_tf.method', compact('title'));
    }

    public function confirm(Request $r)
    {
        $token = $r->token;
        $title = 'Konfirmasi Pembayaran';
        $bank = dataBank::orderBy('created_at', 'asc')->get();
        $data = $this->getDataConfirm($r->q);
        return view('user.order.confirm.order_conf', compact('title', 'bank', 'data', 'token'));
    }


    public function info(Request $r)
    {
        $met = payingMethod::findOrFail($r->met);
        return $met->method === 'Transfer' ? $this->method_tf($met, $r->q) : $this->method_cop($met, $r->q);
    }

    private function method_tf($met, $id)
    {
        $title = 'Info Pembayaran';
        $data = $this->getDataConfirm($id);

        return view('user.order.invoice.order_inv', compact('title', 'data'));
    }

    private function getDataConfirm($id)
    {
        $trans = mstTransactionList::findOrFail($id);

        return $data = self::convertToObject([
            'total' => $this->getTotal($trans),
            'date_end' => $this->dateEnd($trans),
            'bank_detail' => $this->getBank($trans),
            'code' => $id
        ]);
    }

    private function getBank($trans)
    {
        $obj = $trans->getMethod;
        return self::convertToObject([
            'name' => $obj->name,
            'img' => file_exists(public_path() . '/' . $obj->url) ? asset($obj->url) : asset('images/img_unvailable.png'),
            'account_number' => $obj->no_rek,
            'division' => $obj->division,
            'name_owner' => $obj->name_owner,
            'code' => $obj->get_bank->code
        ]);
    }

    private function method_cop($met, $id)
    {
        $trans = mstTransactionList::findOrFail($id);
        $data = self::convertToObject([
            'total' => $this->getTotal($trans),
            'disc' => $this->getVoucher($trans),
            'date_end' => $this->dateEnd($trans)
        ]);

        $title = 'Info Pembayaran';
        return view('user.order.invoice.order_inv_cod', compact('title', 'data'));
    }

    private function getTotal($trans)
    {
        foreach ($trans->getMultiTrans as $row) {
            $sub = 0;
            foreach ($row->getList as $student) {
                $sub += $student->getPrince->amount;
            }
        }
        return $sub;
    }

    private function getVoucher($trans)
    {
        return $trans->voucher_id ?
            self::convertToObject($trans->getVoucher->only('amount', 'type'))
            : null;
    }

    private function dateEnd($trans)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $trans->updated_at);
        return $date->formatLocalized('%a, %d %b %Y') . ' ' . $date->format('H:i') . ' WIB';
    }

    public function describe(Request $r)
    {
        $code = $r->q;
        $title = 'Detail Transaksi';
        $array = [];
        $re = $r->only('q');
        $rules = [
            'q' => 'required|exists:mst_transaction_lists,id'
        ];
        $msg = [
            'required' => 'harap memilih kolom diatas',
            'exists' => 'harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rules, $msg)) {
            return abort('404');
        }
        $total = 0;
        $obj = mstTransactionList::findOrFail($r->q);
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $obj->updated_at);

        if ($obj->method_id) {
            $array['method'] = $method = $obj->getMethod->only('name', 'url', 'method', 'desc');
            $array['method']['url'] = url($array['method']['url']);
        }

        if ($obj->status === 'menunggu' || $obj->status === 'konfirmasi') {
            if ($date->addDays(1)->greaterThan(now())) {
                $array2 = $this->getDetailCont($obj->code, $obj->created_at, $obj->status, $date->addDays(1), ($obj->status === 'konfirmasi' ? 'melalui ' . $method['name'] : ''), false);
            } else {
                $array2 = $this->getDetailCont($obj->code, $obj->created_at, 'batal', $date->addDays(1), $method['name'], true);
            }
        } elseif ($obj->status === 'berhasil' || $obj->status === 'administrasi') {
            $array2 = $this->getDetailCont($obj->code, $obj->created_at, $obj->status, $date, $method['name'], false);

        } else {
            $array2 = $this->getDetailCont($obj->code, $obj->created_at, $obj->status, $date, $method['name'], false);
        }
        $array = array_merge($array, $array2);


        foreach ($obj->getMultiTrans as $z => $detail) {
            $name = $detail->getStudent->name;
            $array['list'][$z] = [
                'FullName' => $name,
                'shortName' => expression::shortName($name),
                'bills' => [],
                'entity' => 0,
                'total' => 0
            ];
            $fullNeeded = '';
            foreach ($detail->getStudent->getDisablity as $v => $needed) {
                count($detail->getStudent->getDisablity) === ($v + 1) && $v !== 0 ?
                    $fullNeeded .= 'dan ' . $needed->getDetailDis->name . ', ' :
                    $fullNeeded .= $needed->getDetailDis->name . ', ';

            }
            $array['list'][$z]['needed'] = substr($fullNeeded, 0, -2);
            foreach ($detail->getList as $x => $item) {
                $price = $item->getPrince;
                array_push($array['list'][$z]['bills'], $price->only('name', 'amount'));
                $array['list'][$z]['entity'] += 1;
                $array['list'][$z]['total'] += $price->amount;
                $total += $price->amount;
            }
        }


        if ($obj->voucher_id) {
            $contentVoucher = $obj->getVoucher;
            $array['voucher'] = [
                'amount' => $contentVoucher->amount,
                'type' => $contentVoucher->type
            ];
        }

        $array['total'] = $total;
//        return $array;
        return view('user.order.describ.describ', compact('title', 'array', 'code'));
    }

    private function getDetailCont($code, $creat, $obj, $date_end, $method, $aggre)
    {
        $array = [];
        $array['notice'] = noticeDescrib[$obj];
        $array['date']['created_at'] = [
            'data' => $creat,
            'date_str' => $creat->formatLocalized('%A, %d %B %Y ') . $creat->format('H:i') . ' WIB'

        ];
        $array['code'] = $code;
        $array['date']['date_limit'] = $date = [
            'data' => $date_end,
            'date_str' => $date_end->formatLocalized('%A, %d %B %Y ') . $date_end->format('H:i') . ' WIB'
        ];
        $array['notice']['content'] = ($obj === 'menunggu' || $obj === 'konfirmasi') ?
            $this->noticeDetailOp1($date['date_str'], $method, $array['notice']['content'], HOMOTYPE) :
            (($obj === 'berhasil' || $obj === 'administrasi') ?
                $this->noticeDetailOp2($date['date_str'], $method, $array['notice']['content'], $array['notice']['desc']) :
                $this->noticeDetailOp3($date['date_str'], $method, $array['notice']['content'], ' ' . ($aggre ? $array['notice']['desc'] : '.')));

        unset($array['notice']['desc']);
        return $array;
    }

    private function noticeDetailOp1($date, $method, $notice, $desc)
    {
        return 'harap ' . $notice . ' sebelum tanggal ' . $date . ' ' . $method . '. ' . $desc;
    }

    private function noticeDetailOp2($date, $method, $notice, $desc)
    {
        return $notice . ' pada tanggal ' . $date . ' 
        melalui ' . $method . '. ' . $desc;
    }

    private function noticeDetailOp3($date, $method, $notice, $desc)
    {
        return $notice . ' pada tanggal ' . $date . $desc;
    }

    public function order(Request $r)
    {
        $token = $r->token;
        $default = Selingan::index('Program');
        $gender = sideGender::orderBy('created_at', 'asc')->get();
        $rs = mstHub::all();
        $dis = mstDisability::orderBy('name', 'asc')->get();
        $title = 'Pendaftaran Siswa Baru';
        $day = sideDaylist::orderBy('created_at', 'asc')->get();
        $user_cookie = $r->data;
        $method = payingMethod::orderBy('created_at', 'asc')->get();
        $entity = session()->has('order') ? count(session('order')['data']) : 1;
        $step = session()->has('order') ? session('order')['step'] : 1;
        $time = sideTimeList::orderBy('created_at', 'asc')->get();
        $sub_total = array_sum(sideTypePrice::where('name', 'Wajib')->first()->getrsTransPrice()->pluck('amount')->toArray());

        return view('user.order.index.order', compact(
            'token', 'default', 'gender',
            'rs', 'dis', 'title', 'day', 'sub_total',
            'user_cookie', 'method', 'entity', 'step', 'time'
        ));
    }

    /**set first impression for register new student
     * route
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function first(Request $r)
    {
        $this->validate($r, [
            'name' => 'required',
            'sex' => 'required|exists:side_genders,id',
            'course' => 'required|exists:mst_classes,id',
            'packet' => 'required|exists:mst_data_pakets,id'
        ], [
            'required' => 'Harap pilih kolom diatas',
            'name.required' => 'Harap isi kolom diatas',
            'exists' => 'harap tidak merubah data',
        ]);

        $this->data_session = [$r->only('name', 'sex', 'course', 'packet')];
        $this->make_session();

        return redirect()->route('order.step');
    }

    public function checkDay(Request $r)
    {
        $re = $r->only('day', 'course');
        $rules = [
            'day' => 'required|exists:side_daylists,id',
            'course' => 'required|exists:mst_classes,id'
        ];
        $msg = [
            'required' => 'harap memilih kolom diatas',
            'exists' => 'harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rules, $msg)) {
            return $error;
        }


        return $this->spesificDay($r->day, $r->course);

    }


    public function checkProgram(Request $r)
    {
        $re = $r->only('course', 'day');
        $rules = [
            'day' => 'exists:side_daylists,id',
            'course' => 'required|exists:mst_classes,id'
        ];
        $msg = [
            'required' => 'harap memilih kolom diatas',
            'exists' => 'harap tidak merubah data'
        ];

        if ($error = self::validates($re, $rules, $msg)) {
            return $error;
        }

        if (!$courseRule = $data = mstClass::findOrFail($r->course)->getRule) {
            return response()->json([]);
        }
        if ($r->has('day')) {
            $data = $this->spesificDay($r->day, $r->course);
        }

        return response()->json($data);
    }

    public function checkout(Request $r)
    {
        $title = 'Detail Transaksi';
        $token = $r->token;
        $default = Selingan::index('Transaksi');
        $user_cookie = $r->data;
        $menu = 'transaksi';
        $tab = $r->has('tab') ? $r->tab : '';

        return view('user.order.checkout.checkout', compact('tab',
            'title', 'token', 'default', 'user_cookie', 'menu'));
    }

    private function spesificDay($day, $course)
    {
        foreach (sideDaylist::findOrFail($day)->getTimeOptions()->orderBy('created_at', 'asc')->get() as $i => $row) {
            $time = $row->getTime;
            $data[] = [
                'datras' => [
                    'code' => $time->id,
                    'content' => $time->start . ' - ' . $time->end . ' WIB'
                ],
                'status' => $row->quota > $row->getList->count()
            ];

            $data = $this->checkCourse($course, 'add', $row->id, $i, $data, 1, 0);
            $data = $this->checkCourse($course, 'except', $row->id, $i, $data, 0, 1);

        }

        return $data;
    }

    private function checkCourse($id, $todo, $option_id, $i, $data, $true, $false)
    {
        $objCourse = mstClass::findOrFail($id);

        if ($objCourse->getRule()->where('todo', $todo)->exists()) {
            $check = $objCourse->getRule()->where([['todo', $todo], ['time_id', $option_id]])->exists();
            $data[$i]['status'] = $check ? $true : $false;
        }

        return $data;
    }

    private function make_session()
    {
        session()->put('order', ['data' => $this->data_session, 'step' => $this->step]);
    }

}
