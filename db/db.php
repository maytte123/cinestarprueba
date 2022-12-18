<?php 
	header( "Content-Type:text/html;charset=utf-8" );
	header( "Access-Control-Allow-Origin:*" );

	function BaseDatos( $ip, $user, $password, $bd ) {
	
		global $_IP, $_USER, $_PASSWORD, $_BD;
		$_IP = $ip;
		$_USER = $user;
		$_PASSWORD = $password;
		$_BD = $bd;
	}

	function getConexion() {
		global $mysqli;
		global $_IP, $_USER, $_PASSWORD, $_BD;
		$mysqli = new mysqli( $_IP, $_USER, $_PASSWORD, $_BD );
		$mysqli->set_charset('utf8');

		if ( $mysqli->connect_errno) {
    		printf("Connect failed: %s\n", $mysqli->connect_error);
    		exit();
		}
	}

	function ejecutarSQL() {
		getConexion();
		global $mysqli;
		global $_SQL;

		mysqli_query( $mysqli, $_SQL );
	}

	function getRegistros() {
		getConexion();
		global $mysqli;
		global $_SQL;

		if ( $rs = mysqli_query( $mysqli, $_SQL ) ) {
			if ( $rs ->num_rows == 1 )
				$data = $rs->fetch_assoc();
			else {
				$data = array();
				while ( $row = $rs->fetch_assoc() )
					$data[] = $row;
			}			
		}

		echo json_encode( $data, JSON_UNESCAPED_UNICODE );	
	}

?>