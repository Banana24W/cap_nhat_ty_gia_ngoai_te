<html>

<head>
    <title>Danh sách tỷ giá tiền tệ</title>
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/normalize.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/icomoon.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/owl.carousel.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/transitions.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/main.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/color.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/responsive.css">
    <link rel="stylesheet" href="<?= base_url() ?>resources/css/style.css">
    <script src="<?= base_url() ?>resources/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <style>
        #countdown {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            /* Màu chữ */
            background-color: #f0f0f0;
            /* Màu nền */
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            /* Hiệu ứng bóng đổ */
            text-align: center;
        }
    </style>

    <h1>Danh sách tỷ giá tiền tệ</h1>
    <a href="<?= site_url('capnhattiente') ?>" class="btn btn-primary">Cập nhật tỷ giá</a>
    <a href="<?= site_url('capnhattientetuweb') ?>" class="btn btn-primary">Cập nhật tỷ giá WebSite</a>
    <div id="countdown" class="text-center"></div>
    <div class="card">
        <div class="table-responsive">
            <div class="table-content">
                <div class="project-table">
                    <table class="table dt-responsive nowrap">
                        <tr>
                            <th class="text-center">Mã tiền tệ</th>
                            <th class="text-center">Tên Ngoại Tệ</th>
                            <th class="text-center">Tỷ giá mua</th>
                            <th class="text-center">Tỷ giá mua chuyển khoản</th>
                            <th class="text-center">Tỷ giá bán</th>
                            <th class="text-center">Ngày Cập Nhật</th>
                        </tr>
                        <?php foreach ($tiente as $rate) : ?>
                            <tr>
                                <td class="text-center"><?= $rate['mangoaite'] ?></td>
                                <td class="text-center"><?= $rate['TenTienTe'] ?></td>
                                <td class="text-center"><?= number_format($rate['muatienmat'], 2, '.', ',') ?></td>
                                <td class="text-center"><?= number_format($rate['muachuyenkhoan'], 2, '.', ',') ?></td>
                                <td class="text-center"><?= number_format($rate['banra'], 2, '.', ',') ?></td>
                                <td class="text-center"><?= $rate['latest_time'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        const intervalTime = 30000;

        setInterval(function() {
            try {
                fetch("/capnhattiente")
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        // Sau khi thành công, load lại trang
                        window.location.reload();
                    })
                    .catch(error => console.error("Error in capnhattiente:", error));

            } catch (error) {
                console.error("Error in try block:", error);
                fetch("/capnhattientetuweb")
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        // Sau khi thành công, load lại trang
                        window.location.reload();
                    })
                    .catch(error => console.error("Error in capnhattientetuweb:", error));
            }
        }, intervalTime);
    </script>
    <script>
        let countdown = intervalTime / 1000;

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const remainingSeconds = seconds % 60;

            const formattedTime = [hours, minutes, remainingSeconds]
                .map(value => value.toString().padStart(2, '0'))
                .join(':');

            return formattedTime;
        }

        function updateCountdown() {
            const countdownElement = document.getElementById('countdown');
            countdownElement.innerHTML = `Cập nhật lại tỷ giá sau: ${formatTime(countdown)} `;
        }

        updateCountdown();

        function startCountdown() {
            if (countdown > 0) {
                countdown -= 1;
                updateCountdown();
            } else {
                // Sau khi countdown đạt 0, tải lại trang
                window.location.reload();
            }
        }

        // Thiết lập đồng hồ đếm ngược
        setInterval(startCountdown, 1000); // Cập nhật mỗi giây
    </script>

</body>

</html>