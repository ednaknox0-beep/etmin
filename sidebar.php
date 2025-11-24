<?php
$current_page = basename($_SERVER['REQUEST_URI']);
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$url .= "://" . $_SERVER['HTTP_HOST'];
$config = json_decode(file_get_contents('../helper/config.json'), true);
?>
<div id="sidebar" class="app-sidebar">

<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">

<div class="menu">
<div class="menu-header">Navigation</div>
<div class="menu-item <?= ($current_page == 'index' || $current_page == 'index.php') ? 'active' : '' ?>">
<a href="index" class="menu-link">
<span class="menu-icon"><i class="bi bi-cpu"></i></span>
<span class="menu-text">Dashboard</span>
</a>
</div>
<div class="menu-item <?= ($current_page == 'settings' || $current_page == 'settings.php') ? 'active' : '' ?>">
<a href="settings" class="menu-link">
<span class="menu-icon"><i class="bi bi-gear"></i></span>
<span class="menu-text">Settings</span>
</a>
</div>
</div>

<div class="p-3 px-4 mt-auto">
<a href="<?= $url ?>?<?= $config['parameter'] ?>" target="_blank" class="btn d-block btn-outline-theme">
<i class="fa fa-code-branch me-2 ms-n2 opacity-5"></i> Go to site
</a>
</div>
</div>

</div>