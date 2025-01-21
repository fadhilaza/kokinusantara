<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses Pembayaran</title>
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="YOUR_CLIENT_KEY"></script>
</head>
<body>
    <h3>Proses Pembayaran</h3>
    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('<?= $snapToken; ?>', {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil!');
                    console.log(result);
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran...');
                    console.log(result);
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    console.log(result);
                }
            });
        });
    </script>
</body>
</html>
