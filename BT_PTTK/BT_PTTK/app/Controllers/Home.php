<?php

namespace App\Controllers;
use App\Models\LoaiTienTeModel;
use App\Models\TienTeModel;

class Home extends BaseController
{
    public function index()
    {
        $tienTeModel = new TienTeModel();
        $loaiTienTeModel = new LoaiTienTeModel();
        // Truy vấn dữ liệu từ bảng tiente
        $tienTe = $tienTeModel->select('mangoaite, muatienmat, muachuyenkhoan, banra, MAX(thoigiancapnhat) as latest_time')
            ->groupBy('mangoaite, muatienmat, muachuyenkhoan, banra')
            ->findAll();
        // Duyệt qua kết quả và lấy tên ngoại tệ từ bảng loaitiente
        foreach ($tienTe as $key => $tienTeRow) {
            $mangoaite = $tienTeRow['mangoaite'];
            // Truy vấn tên ngoại tệ từ bảng loaitiente dựa vào mã ngoại tệ
            $loaiTienTe = $loaiTienTeModel->where('mangoaite', $mangoaite)->first();
            // Gán tên ngoại tệ vào kết quả
            $tienTe[$key]['TenTienTe'] = $loaiTienTe ? $loaiTienTe['tenngoaite'] : 'Không có tên ngoại tệ';
        }
        $data = [
            'tiente' => $tienTe,
        ];
        return view('hienthi', $data);
    }
}
