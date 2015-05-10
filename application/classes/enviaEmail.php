<?php defined('SYSPATH') or die('No direct script access.');
 
class enviaEmail {

	public static function aviso_usuarioAtivado($user,$password=null)
	{			
		$swift = email::connect();

		$recipients = new Swift_RecipientList;
		$recipients->addTo($user->email);		
		
		$subject = 'MASTERPRED - Sua conta foi ativada'; // assunto
		$message = new View("email/aviso_usuarioativado");
		$message->nome = $user->nome; 
		$message->username = $user->username; 
		$message->password = $password; 
		
		$message = new Swift_Message($subject, $message, "text/html");
		
		return enviaEmail::sendEmail($message,$recipients,null,$swift);		
	}		

	public static function aviso_novaSenha($user,$password)
	{
		$swift = email::connect();
		$recipients = new Swift_RecipientList;
		$recipients->addTo($user->email);		
		
		$subject = 'MASTERPRED - Nova senha do sitema'; // assunto
		$message = new View("email/aviso_novasenha");
		$message->nome = $user->nome; 		
		$message->password = $password; 
		
		$message = new Swift_Message($subject, $message, "text/html");

		return enviaEmail::sendEmail($message,$recipients,null,$swift);
	}	

	public static function aviso_ospFinalizada($id)
	{
		$swift = email::connect();
		$gr = ORM::factory("Gr",$id);

		$recipients = new Swift_RecipientList;
		$recipients->addTo(Kohana::config('config.email_site'));		
		
		$subject = 'MASTERPRED - Finalização da OSP'; // assunto
		$message = new View("email/aviso_ospfinalizada");
		$message->gr = $gr; 	

		$message = new Swift_Message($subject, $message, "text/html");

		return enviaEmail::sendEmail($message,$recipients,null,$swift);

	}

	public static function aviso_limitegr($tipo,$equip)
	{
		$swift = email::connect();
		$recipients = new Swift_RecipientList;
		$recipients->addTo(Kohana::config('config.email_site'));	
		
		$subject = 'MASTERPRED - Novas inspeções'; // assunto
		$message = new View("email/aviso_inspecao");
		$message->nome = $user->nome; 		
		
		$message = new Swift_Message($subject, $message, "text/html");

		return enviaEmail::sendEmail($message,$recipients,null,$swift);

	}

	public static function aviso_inspecao($user)
	{	
		$swift = email::connect();		

		$recipients = new Swift_RecipientList;
		$recipients->addTo(Kohana::config('config.email_site'));		

		$subject = 'MASTERPRED - Novas inspeções'; // assunto
		$message = new View("email/aviso_inspecao");
		$message->nome = $user->nome; 	

		$message = new Swift_Message($subject, $message, "text/html");

		return enviaEmail::sendEmail($message,$recipients,null,$swift);
	}	


	public static function sendEmail( $message,$recipients,$from = null,$swift )
	{

		$from = ($from!=null)?($from):(Kohana::config('config.email_site'));
		
		if($swift->send($message, $recipients, $from))
		{
			$swift->disconnect();
			return 1;
		}
		else
		{
			$swift->disconnect();
			return 0;
		}
	}
}