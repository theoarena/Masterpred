<?php defined('SYSPATH') or die('No direct script access.');
 
class enviaEmail {

	public static function aviso_usuarioAtivado($user,$password=null)
	{			
		$mail = new PHPMailer;

		$mail->addAddress($user->email);		
		
		$subject = 'MASTERPRED - Sua conta foi ativada'; // assunto
		$message = View::factory("email/aviso_usuarioativado");
		$message->nome = $user->nome; 
		$message->username = $user->username; 
		$message->password = $password; 
		
		return enviaEmail::sendEmail($message,$subject,null,$mail);		
	}		

	public static function aviso_novaSenha($user,$password)
	{
		$mail = new PHPMailer;
		
		$mail->addAddress($user->email);		
		
		$subject = 'MASTERPRED - Nova senha do sitema'; // assunto
		$message = View::factory("email/aviso_novasenha");
		$message->nome = $user->nome; 		
		$message->password = $password; 
		
		return enviaEmail::sendEmail($message,$subject,null,$mail);
	}	

	public static function aviso_ospFinalizada($id)
	{
		$mail = new PHPMailer;
		$gr = ORM::factory("Gr",$id);
		
		$mail->addAddress(Kohana::$config->load('config')->get('email_site'));		
		
		$subject = 'MASTERPRED - Finalização da OSP'; // assunto
		$message = View::factory("email/aviso_ospfinalizada");
		$message->gr = $gr; 	

		return enviaEmail::sendEmail($message,$subject,null,$mail);

	}

	public static function aviso_limitegr($tipo,$equip)
	{
		$mail = new PHPMailer;
		
		$mail->addAddress(Kohana::$config->load('config')->get('email_site'));	
		
		$subject = 'MASTERPRED - Novas inspeções'; // assunto
		$message = View::factory("email/aviso_inspecao");
		$message->nome = $user->nome; 		
		
		return enviaEmail::sendEmail($message,$subject,null,$mail);

	}

	public static function aviso_inspecao($user)
	{	
		$mail = new PHPMailer;		
		
		$mail->addAddress(Kohana::$config->load('config')->get('email_site'));		

		$subject = 'MASTERPRED - Novas inspeções'; // assunto
		$message = View::factory("email/aviso_inspecao");
		$message->nome = $user->nome; 	

		return enviaEmail::sendEmail($message,$subject,null,$mail);
	}	

	public static function teste()
	{	
		$mail = new PHPMailer;		
		
		$mail->addAddress('theoarena@gmail.com');		

		$subject = 'MASTERPRED - Novas inspeções'; // assunto
		$message = 'MASTERPRED - Novas inspeções';
		//$message->nome = $user->nome; 	

		return enviaEmail::sendEmail($message,$subject,null,$mail);
	}	


	public static function sendEmail( $message,$subject,$from = null,$mail,$nome = null )
	{
		$mail_config = Kohana::$config->load('config')->get('mail');
		$mail->isSMTP();                                    
		$mail->SMTPAuth = true;                               
		$mail->Host = $mail_config['hostname'];  
		$mail->Username =  $mail_config['username'];               
		$mail->Password =  $mail_config['password'];   
		$mail->Port = $mail_config['port'];   
		//$mail->SMTPSecure = 'tls';  // Enable TLS encryption, `ssl` also accepted
		//$mail->SMTPDebug = 1; 
		$mail->isHTML(true); 		 
		$mail->From = ($from!=null)?($from):(Kohana::$config->load('config')->get('email_site'));
		$mail->FromName = ($nome!=null)?($nome):(Kohana::$config->load('config')->get('nome_email_site'));
		
		$mail->Subject = utf8_decode($subject);
		$mail->Body    = utf8_decode($message);
			

		if($mail->send())		
			return 1;		
		else		
			return 0;			
	}
}