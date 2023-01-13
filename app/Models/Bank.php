<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'bank_name',
        'bank_acc',
        'status'
    ];

    public static function bank_name($name_id = null) {
        $all_name = [
            '1' => 'ธนาคารไทยพาณิชย์ （SCB）',
            '2' => 'ธนาคาร กสิกรไทย （KBANK)',
            '3' => 'ธนาคาร กรุงศรีอยุธยา （BAY)',
            '4' => 'ธนาคาร กรุงไทย （KTB)',
            '5' => 'ธนาคาร กรุงเทพ（BBL)',
            '6' => 'ธนาคารเพื่อการเกษตร ธ ก ส（BAAC）',
            '7' => 'ธนาคาร ทหารไทย （TTB)',
            '8' => 'ธนาคาร ซีไอเอ็มบี ไทย(CIMB)',
            '9' => 'ธนาคาร ยูโอบี (UOB)',
            '10' => 'ธนาคาร ออมสิน(GSB)',
            '11' => 'ธนาคารแลนด์ แอนด์ เฮ้าส์',
            '12' => 'ธนาคาร ธนชาติ（TBANK)',
            '13' => 'ธนาคารทิสโก้',
            '14' => 'ธนาคารเกียรตินาคิน',
            '15' => 'ทรูวอลเล็ท',
            '16' => 'ธนาคาร ไอซีบีซี(ICBC)',
        ];

        if(is_null($name_id)) {
            return $all_name;
        }
        $bank_name = 'Unknow';

        if(isset($all_name[$name_id])) {
            $bank_name = $all_name[$name_id];
        }
        return $bank_name;
    }
}
