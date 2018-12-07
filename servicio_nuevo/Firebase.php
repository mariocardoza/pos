<?php 

	/**
	 * 
	 */
	class Firebase  
	{
		
		function __construct($argument)
		{
			# code...
		}

		public static function enviartoken($usuario){
			$token = "cz4MO8M8A6k:APA91bEkVpo29qibQl02zgFX2phLGXXJG5FbIF5JkvNVUntHLza0fog4vn8lWvhZ16gGX4RB2s58z0YY3q1fwRUrc4dZhw_Q6xZCCrHDZEZVK7PTMOs_im5qeZJNYjZl1BdlPNnVfMzY";
			define("GOOGLE_API_KEY", "AIzaSyBYIgp1e4TIXpGv6BUwNnGdFmqkXOhN6YU");
			file_put_contents("nombre3.txt",$token.'\n'.$usuario.'\n'.GOOGLE_API_KEY);

	        $titulo= "Solicitud de Ubicación";
	        $mensaje="Usuario: ".$usuario.', ';
	       	$yidisus=date("Yidisus");

	        $registatoin_ids = array($token);
	        $message = array("price" => $mensaje,"titulo" => $titulo,"email" => $usuario,"solicitud"=>"1");
	        $url = 'https://fcm.googleapis.com/fcm/send';
	        $fields = array(
	                'registration_ids' => $registatoin_ids,
	                'data' => $message,
	        );

	        $headers = array('Authorization:key='.GOOGLE_API_KEY,
	            'Content-Type:application/json'
	        );
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	        // desabilito los ssl
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($fields));

	        $result = curl_exec($ch);
	         
	        if ($result === FALSE) {
	            die('Curl failed: ' . curl_error($ch));
	        }else{
	        	return $yidisus;
	        }
		}
	}


?>