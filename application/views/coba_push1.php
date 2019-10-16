<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Push.js Tutorial</title>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.12/push.min.js"></script> -->
    <script src="<?php echo base_url()?>assets/vendor/push.js-master/bin/push.min.js"></script>
    <script src="<?php echo base_url()?>assets/vendor/push.js-master/bin/serviceWorker.min.js"></script>
</head>
<body>
    <h1>Push.js Tutorial</h1>
    <p>Klik tombol di bawah untuk memunculkan notifikasi.</p>
    <button id="notif">Tampilkan Notifikasi</button>
    <script>
        document.getElementById('notif').addEventListener('click', () => {
            Push.Permission.request(() => {
                Push.create('Kodinger.com', {
                    body: 'Hello, ini adalah notifikasi dari tutorial Kodinger.com.',
                    icon: 'https://kodinger.com/wp-content/uploads/2016/04/kod-1.jpg',
                    requireInteraction: true,
                    timeout: 0,
                    onClick: () => {
                        window.location.href = "<?php echo site_url('dashboard') ?>";
                    }
                });
            });
        });
    </script>
</body>
</html>