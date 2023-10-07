<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TienTeModel;
use DOMDocument;
use DOMXPath;
use Sunra\PhpSimple\HtmlDomParser;




class LuuTienTe extends BaseController
{
    public function index()
    {
    }
    public function updateExchangRatesToWebsite()
    {
        $exchangeRateModel = new TienTeModel();
        $url = "https://www.vietcombank.com.vn/KHCN/Cong-cu-tien-ich/Ty-gia";
        // Lấy nội dung từ URL
        $htmlString = file_get_contents($url);
        // Tạo một đối tượng DOM
        $dom = new DOMDocument();
        // Tắt thông báo lỗi không cần thiết
        libxml_use_internal_errors(true);
        // Load chuỗi HTML vào đối tượng DOM
        $dom->loadHTML($htmlString);
        // Bật lại thông báo lỗi
        libxml_use_internal_errors(false);
        // Tạo một đối tượng DOMXPath để truy vấn dữ liệu
        $xpath = new DOMXPath($dom);
        // Truy xuất tất cả các thẻ li có class là "dropdown-options__item"
        $liElements = $xpath->query('//li[@class="dropdown-options__item "]');

        // Lặp qua danh sách các thẻ li và lấy thông tin
        foreach ($liElements as $li) {
            $dataCode = $li->getAttribute('data-code');
            $sellRate = $li->getAttribute('data-sell-rate');
            $cashRate = $li->getAttribute('data-cash-rate');
            $transferRate = $li->getAttribute('data-transfer-rate');
             

            $datas=[
                        'mangoaite' => $dataCode,
                        'muachuyenkhoan' => $transferRate,
                        'muatienmat' => $cashRate,
                        'banra' => $sellRate,
            ];
            $exchangeRateModel->save($datas);
        }
        return redirect()->to('/');
    }
    public function updateExchangeRates()
    {
        // Gọi API Vietcombank
        $apiUrl = 'https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx?b=10';
        $exchangeRatesData = file_get_contents($apiUrl);

        if ($exchangeRatesData) {
            // Parse dữ liệu XML thành mảng
            $xml = simplexml_load_string($exchangeRatesData);
            $json = json_encode($xml);

            $exchangeRatesData = json_decode($json, true);

            if (isset($exchangeRatesData['Exrate'])) { // Truy cập mảng Exrate
                $exchangeRateModel = new TienTeModel();

                // Xóa dữ liệu hiện có trong bảng tỷ giá tiền tệ (tuỳ chọn)
                // $exchangeRateModel->truncate();

                foreach ($exchangeRatesData['Exrate'] as $rate) {
                    // Lưu từng bản ghi vào cơ sở dữ liệu
                    $maTienTe = $rate['@attributes']['CurrencyCode'];
                    // $tenTienTe = $rate['@attributes']['CurrencyName'];
                    $giaMua = str_replace(',', '', $rate['@attributes']['Buy']); // Loại bỏ dấu phẩy
                    $giaMuaTK = str_replace(',', '', $rate['@attributes']['Transfer']); // Loại bỏ dấu phẩy
                    $giaBan = str_replace(',', '', $rate['@attributes']['Sell']); // Loại bỏ dấu phẩy

                    $data = [
                        'mangoaite' => $maTienTe,
                        // 'tenngoaite' => $tenTienTe,
                        'muachuyenkhoan' => $giaMuaTK,
                        'muatienmat' => $giaMua,
                        'banra' => $giaBan,
                    ];
                    $exchangeRateModel->save($data);
                }

                return redirect()->to('/');
            } else {
                echo 'Không có dữ liệu tỷ giá tiền tệ để cập nhật.';
            }
        } else {
            echo 'Không thể kết nối đến API.';
        }
    }
}
