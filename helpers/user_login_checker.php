<?php 

/**
 * Check session hak_akses to determined user is allowed to access specific page or not
 * 
 * @param string|array<string $expected_hak_akses
 * - Array to allow multiple user
 * - String/word to allow one user
 * - Example: array('non_asn', 'pimpinan) and 'admin'
 */
function isAccessAllowed($expected_hak_akses = null): bool {
    include_once '../config/config.php';

    // Start session if not started yet
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $current_hak_akses = $_SESSION['hak_akses'] ?? null;
    $expected_hak_akses = !is_array($expected_hak_akses)
        ? array($expected_hak_akses)
        : $expected_hak_akses;
    
    if (!$current_hak_akses || !in_array($current_hak_akses, $expected_hak_akses)) {
        return false;
    }
    
    return true;
}

/**
 * Check and redirect user to its own page if already logged in
 * 
 * @param string $hak_akses $_SESSION (usually $_SESSION['hak_akses'])
 */
function isAlreadyLoggedIn($hak_akses): bool {
	// alihkan user ke halamannya masing-masing
	switch ($hak_akses) {
		case 'admin':
			header("location:admin");
			break;

		case 'guru':
			header("location:guru/index.php?go=dashboard");
			break;
			
		case 'kepala_sekolah':
			header("location:kepala_sekolah/index.php?go=dashboard");
			break;
		
		default:
			header("location:index.php");
			break;
	}

    return true;
}

?>