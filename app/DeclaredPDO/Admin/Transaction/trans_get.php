<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 24/11/2018
 * Time: 23:24
 */

namespace App\DeclaredPDO\Admin\Transaction;


use App\DeclaredPDO\Jwt\jwtClass;
use App\Model\linkUserStudent;
use App\User;

class trans_get
{
    use jwtClass;
    protected $model;

    public function __construct($qlo)
    {
        $this->model = $qlo;
    }

    public static function searchSome($arr, $q)
    {

        $new = [];
        foreach ($arr as $tow) {
            foreach (array_keys($tow) as $row) {
                if ($row !== 'key' || $row !== 'voucher') {
                    if (strpos(strtolower($tow[$row]), strtolower($q)) !== false) {
                        $new[] = $tow;
                        break;
                    }
                }
            }

        }
        return $new;
    }

    public function get_tf()
    {
        $total = $this->totalAll($this->getListStudent());
        $get_voucher = $this->getVoucher($total, [
            'key' => $this->model->id,
            'code' => $this->model->code,
            'date_create' => $this->model->updated_at,
            'ex_create' => $this->model->updated_at->addDays(1),
            'quantity' => $this->countStudent(),
            'student' => $this->shortListStudet(),
            'method' => $this->methodDesc(),
            'total' => $total,
            'status' => now()->subDays(1)->lt($this->model->updated_at) ? 'Menunggu' : 'Gagal']);

        return $get_voucher;
    }

    public function detail_tf()
    {
        $list = $this->getListStudent();
        $total = $this->totalAll($list);
        $get_voucher = $this->getVoucher($total, [
            'key' => $this->model->id,
            'code' => $this->model->code,
            'date_create' => $this->model->updated_at,
            'ex_create' => $this->model->updated_at->addDays(1),
            'quantity' => $this->countStudent(),
            'student' => $this->shortListStudet(),
            'method' => $this->methodDesc(),
            'list' => $list,
            'sub_total' => $total,
            'total' => $total,
            'status' => now()->subDays(1)->lt($this->model->updated_at) ? 'Menunggu Konfirmasi' : 'Transaksi Gagal']);
        return $this->getInvoice($get_voucher);

    }

    private function getInvoice($arr)
    {
        return array_merge($arr, $this->model->getMethod->method === 'Transfer' ?
            ['invoice' => array_merge($this->model->getInvoice->only('name', 'date_send'), [
                'img' => asset($this->model->getInvoice->img),
                'bank' => $this->model->getInvoice->getBank->name
            ])

            ]
            : []);
    }

    private function getVoucher($total, $arr)
    {
        $coucher = $this->model->getVoucher;

        return array_merge($arr, $coucher ? [
            'voucher' => [
                'amount' => $coucher['amount'],
                'type' => $coucher['type']
            ],
            'total' => $coucher['type'] === 'Diskon' ? (100 - $coucher['amount']) * $total / 100 : $total - $coucher['amount']
        ] : []);

    }

    private function totalAll($arr)
    {
        $total = 0;
        foreach ($arr as $row) {
            $total += $row['sub_total'];
        }

        return $total;
    }

    private function getListStudent()
    {
        $arr = [];
        foreach ($this->model->getMultiTrans as $i => $row) {
            $dataStudent = $row->getStudent;
            $deli = strpos($dataStudent->name, ' ');
            $arr [$i] = [
                'name' => $dataStudent->name,
                'shorName' => $deli ? substr($dataStudent->name, 0, $deli) : $dataStudent->name,
                'needed' => $this->getNeeded($dataStudent->getDisablity)
            ];

            $arr[$i] = array_merge($arr[$i], $this->getListRegis($row));
        }

        return $arr;
    }


    private function getListRegis($model)
    {
        $arr = [];
        $detail = [];
        $sub_total = 0;
        foreach ($model->getList as $row) {
            $price = $row->getPrince;
            $detail[] = [
                'name' => $price->name,
                'amount' => $price->amount
            ];
            $sub_total += $price->amount;
        }

        $arr = [
            'detail' => $detail,
            'sub_total' => $sub_total,
            'quantity' => count($model->getList)
        ];

        return $arr;
    }

    private function methodDesc()
    {
        return $this->model->getMethod->name;
    }


    private function countStudent()
    {
        return count($this->model->getMultiTrans) . ' Anak';
    }

    private function shortListStudet()
    {
        $nameGroup = '';
        foreach ($this->model->getMultiTrans as $row) {
            $dataStudent = $row->getStudent->name;
            $posSpac = strpos($dataStudent, ' ');
            $nameGroup .= ($posSpac ?
                    substr($dataStudent, 0, $posSpac) :
                    $dataStudent) . ', ';
        }

        return substr($nameGroup, 0, -2);
    }



    public function confirmTrans()
    {

        foreach ($this->model->getMultiTrans as $row) {
            $row->getStudent->update([
                'status' => 'Active',
                'register' => now()->toDateString(),
                'ni' => $this->niSet(new linkUserStudent(), 4)
            ]);
        }

        if(!$this->model->getUser->ni){
            $this->model->getUser->update([
            'ni'=>$this->niSet(new User(),3)
        ]);
        }
        $this->model->update([
            'status' => 'berhasil',
            'admin_id' => $this->get_id()->id
        ]);

        return response()->json(['msg' => 'Transasi berhasil dikonfirmasi']);
    }

    public function checkConfirm()
    {
        return $this->model->getMethod->method === 'Bayar Ditempat' ? $this->confirmTrans() : $this->notFound();
    }

}