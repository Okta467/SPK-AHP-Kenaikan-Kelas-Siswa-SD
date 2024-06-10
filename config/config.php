<?php 
	function base_url($path = 'index.php') {
		echo "/spk_ahp/" . $path;
	}

	function base_url_return($path = 'index.php') {
		return "/spk_ahp/" . $path;
	}

    date_default_timezone_set("Asia/Bangkok");
	
	DEFINE("SITE_NAME", "SPK AHP - Kenaikan Kelas di SDN 14 Lawang Kidul Muara Enim");
	DEFINE("SITE_NAME_SHORT", "SPK AHP");
?>