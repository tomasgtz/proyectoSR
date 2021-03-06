<?php

cors();
define( 'API_ACCESS_KEY', 'AIzaSyBherwZbWKLAG1ZpIQvo1NbIyZjuoFYJ6o' );

function cors() {
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }
}
//incluir el archivo principal
//include("Slim/Slim.php");

include("../../nodejs/vendor/autoload.php");

//registran la instancia de slim
// \Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//aplicacion 
//$app = new \Slim\Slim();

//routing 
//accediendo VIA URL
//http:///www.google.com/
//localhost/apirest/index.php/ => "Hola mundo ...."


$app->post(
		'/Authentication',function() use ($app){

			$allPostVars = $app->request->post();
			$req = $app->request();
			$email_p = $req->post('email_p');
			$password_p = $req->post('password_p');

				//almaceno de el parámetro al servicio
				//conexion con base de datos
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						$data = $cn->query("call uspGet_LoggedUser('$email_p', '$password_p');")->fetchAll(PDO::FETCH_ASSOC);

						echo json_encode($data);
				}
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
			}
);

//////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Campaigns',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$idcompany_p = $req->post('idcompany_p');
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Campaigns('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$name_p = $req->post('name_p');
			$description_p = $req->post('description_p');
			$userup_p = $req->post('userup_p');
			$userupdate_p = $req->post('userupdate_p');
			$dimension_p = $req->post('dimension_p');
			$company_p = $req->post('company_p');
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCampaign('$name_p','$description_p','$userup_p','$userupdate_p','$dimension_p','$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$name_p = $req->post('name_p');
			$description_p = $req->post('description_p');
			$userupdate_p = $req->post('userupdate_p');
			$dimension_p = $req->post('dimension_p');
			$company_p = $req->post('company_p');
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Campaign('$name_p','$description_p','$userupdate_p','$dimension_p','$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('company_p');
			$status_p = $req->post('status_p');
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCampaign('$campaign_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Company',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company();")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/SelectedCompany',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_SelectedCompany('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCompany',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$name_p = $req->post('name_p');
			$address_p = $req->post('address_p');
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCompany('$name_p','$address_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UCompany',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$name_p = $req->post('name_p');
			$address_p = $req->post('address_p');
			$company_p = $req->post('company_p');
			$industry_p = $req->post('industry_p');
			$noemployees_p = $req->post('noemployees_p');
			$webpage_p = $req->post('webpage_p');
			$pc_p = $req->post('pc_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Company('$name_p','$address_p','$company_p', '$industry_p', '$noemployees_p', '$pc_p', '$webpage_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusCompany',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$status_p = $req->post('status_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Company_TextConfig',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_TextConfig('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCompany_TextConfig',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$textconfig_p = $req->post('textconfig_p');
			$array = json_decode( $textconfig_p, true );

			
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['text_config']; 
							$data = $cn->query("call uspIns_NewCompany_TextConfig('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCompany_Palette',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$color_p = $req->post('color_p');
			$array = json_decode( $color_p, true );

			
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['color']; 
							$data = $cn->query("call uspIns_NewCompany_Palette('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UCompany_TextConfig',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$textconfig_p = $req->post('textconfig_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_UCompany_TextConfig('$company_p','$textconfig_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusCompany_TextConfig',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$status_p = $req->post('status_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany_TextConfig('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Company_Pack',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_Pack('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCompany_Pack',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$image_p = $req->post('image_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCompany_Pack('$company_p','$image_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UCompany_Pack',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$image_p = $req->post('image_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Company_Pack('$company_p','$image_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusCompany_Pack',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$status_p = $req->post('status_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany_Pack('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Company_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_Subscription('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCompany_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$subscription_p = $req->post('subscription_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCompany_Subscription('$company_p','$subscription_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UCompany_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Company_Subscription('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusCompany_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$status_p = $req->post('status_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany_Subscription('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Design',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Design('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewDesign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$user_p = $req->post('user_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewDesign('$campaign_p','$user_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UDesign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Design('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusDesign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$status_p = $req->post('status_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusDesign('$campaign_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Ct_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Ct_Subscription();")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/SelectedCt_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$subs_p = $req->post('subs_p');
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_SelectedCt_Subscription('$subs_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCt_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$description_p = $req->post('description_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCt_Subscription('$description_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UCt_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$description_p = $req->post('description_p');
			$subs_p = $req->post('subs_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Ct_Subscription('$description_p'.'$subs_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Ct_Dimensions',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Ct_Dimensions('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCt_Dimensions',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$height_p = $req->post('height_p');
			$width_p = $req->post('width_p');



				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCt_Dimensions('$campaign_p','$height_p','$width_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UCt_Dimensions',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$height_p = $req->post('height_p');
			$width_p = $req->post('width_p');
			$description_p = $req->post('description_p');	



				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Ct_Dimensions('$campaign_p','$height_p','$width_p','$description_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Det_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');



				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Det_Subscription('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewDet_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$subs_p = $req->post('subs_p');
			$price_p = $req->post('price_p');
			$individualusercost_p = $req->post('individualusercost_p');
			$image_p = $req->post('image_p');
			$firstplus_p = $req->post('firstplus_p');
			$secplus_p = $req->post('secplus_p');
			$thirdplus_p = $req->post('thirdplus_p');
			$frthplus_p = $req->post('frthplus_p');
			$fifthplus_p = $req->post('fifthplus_p');
			$sixthplus_p = $req->post('sixthplus_p');
			$sevnplus_p = $req->post('sevnplus_p');



				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewDet_Subscription('$subs_p','$price_p','$individualusercost_p','$image_p','$firstplus_p','$secplus_p','$thirdplus_p','$frthplus_p','$fifthplus_p','$sixthplus_p','$sevnplus_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UDet_Subscription',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$subs_p = $req->post('subs_p');
			$price_p = $req->post('price_p');
			$individualusercost_p = $req->post('individualusercost_p');
			$image_p = $req->post('image_p');
			$firstplus_p = $req->post('firstplus_p');
			$secplus_p = $req->post('secplus_p');
			$thirdplus_p = $req->post('thirdplus_p');
			$frthplus_p = $req->post('frthplus_p');
			$fifthplus_p = $req->post('fifthplus_p');
			$sixthplus_p = $req->post('sixthplus_p');
			$sevnplus_p = $req->post('sevnplus_p');



				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Det_Subscription('$subs_p','$price_p','$individualusercost_p','$image_p','$firstplus_p','$secplus_p','$thirdplus_p','$frthplus_p','$fifthplus_p','$sixthplus_p','$sevnplus_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/Control_Historic',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Control_Historic('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewControl_Historic',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$user_p = $req->post('user_p');
			$description_p = $req->post('description_p');
			


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewControl_Historic('$user_p','$description_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UControl_Historic',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$user_p = $req->post('user_p');
			$description_p = $req->post('description_p');
			$company_p = $req->post('company_p');
			


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Control_Historic('$user_p','$description_p','$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusControl_Historic',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$user_p = $req->post('user_p');
			$description_p = $req->post('description_p');
			$company_p = $req->post('company_p');
			


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusControl_Historic('$user_p','$description_p','$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/General_Messages',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_General_Messages('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UGeneral_Messages',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$idgmessage_p = $req->post('idgmessage_p');
			$userup_p = $req->post('userup_p');
			$usersend_p = $req->post('usersend_p');
			$userreceive_p = $req->post('userreceive_p');
			$focusgroup_p = $req->post('focusgroup_p');
			$message_p = $req->post('message_p');			


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_General_Messages('$company_p','$idgmessage_p','$userup_p','$usersend_p','$userreceive_p','$focusgroup_p','$message_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/StatusGeneral_Messages',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$status_p = $req->post('status_p');			


				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusGeneral_Messages('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UUser',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$name_p = $req->post('name_p');
			$password_p = $req->post('password_p');
			$mobilephone_p = $req->post('mobilephone_p');
			$homephone_p = $req->post('homephone_p');
			$iduser_p = $req->post('iduser_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_User('$name_p','$password_p','$mobilephone_p', '$homephone_p', '$iduser_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GUserCompany',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$idcompany_p = $req->post('idcompany_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_UsersCompany('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GTextsCompany',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$idcompany_p = $req->post('idcompany_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_TextCompany('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GPaletteCompany',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$idcompany_p = $req->post('idcompany_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_PaletteCompany('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GMaterials',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Materials();")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GPaletteCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignPalette('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GTextsCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignTexts('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GMaterialsCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignMaterial('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GPackCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignPack('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/GFontsCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignFonts('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

//Deletes Campaign Features



$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/DPaletteCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignPalette('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/DTextsCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignTexts('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/DMaterialsCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignMaterial('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/DPackCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignPack('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/DFontsCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignFonts('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

// Campaign Insert services features




$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/IPaletteCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$color_p = $req->post('color_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignPalette('$campaign_p','$color_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/IMaterialCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$material_p = $req->post('material_p');
			$download_p = $req->post('download_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignMaterial('$campaign_p','$material_p', '$download_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/ITextCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$text_p = $req->post('text_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignTexts('$campaign_p','$text_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/IFontCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$font_p = $req->post('font_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignFonts('$campaign_p','$font_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/IPackCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$campaign_p = $req->post('campaign_p');
			$pack_p = $req->post('pack_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignPack('$campaign_p','$pack_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewMaterial',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$description_p = $req->post('description_p');
			$width_p = $req->post('width_p');
			$height_p = $req->post('height_p');
			$thumbnail_p = $req->post('thumbnail_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_Material('$description_p','$width_p','$height_p','$thumbnail_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UpdMaterial',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$description_p = $req->post('description_p');
			$width_p = $req->post('width_p');
			$height_p = $req->post('height_p');
			$thumbnail_p = $req->post('thumbnail_p');
			$material_p = $req->post('material_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_Material('$description_p','$width_p','$height_p','$thumbnail_p','$material_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/UpdMaterialStatus',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$status_p = $req->post('status_p');
			$material_p = $req->post('material_p');

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_Material('$status_p','$material_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/AllUsersAdmin',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_AllUsersAdmin();")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/AllCompaniesAdmin',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_AllCompaniesSubs();")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/CountSubscriptions',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS

				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CountSubscriptions();")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewUser',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			//CAMBIAR PARAMETROS
			$company_p = $req->post('company_p');
			$name_p = $req->post('name_p');
			$password_p = $req->post('password_p');
			$homephone_p = $req->post('homephone_p');
			$mobilephone_p = $req->post('mobilephone_p');
			$to   = $name_p;
			$from = 'sistema@wizad.com';
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "CC: alanbarreraf@hotmail.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message =  '<html>
							<head>
								<title>Wizad</title>
							</head>
							<body>
								<h1>Registrate y se parte de nosotros.</h1>
								<table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
									<tr>
										<th>Usuario:</th><td>  '.$name_p.'  </td>
									</tr>
									<tr style="background-color: #e0e0e0;">
										<th>Contrase&ntilde;a:</th><td>  '.$password_p.'   </td>
									</tr>
									<tr>
										<th>Sitio Web:</th><td><a href="http://www.wizadqa.mx">www.wizad.mx</a></td>
									</tr>
								</table>
							</body>
						</html>';
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewUser('$company_p','$name_p','$password_p','$homephone_p','$mobilephone_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						mail($to, "Wizad - Registrate", $message, $headers);
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/SaveNewCampaign',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$description_c = $req->post('description_c');
			$title_c = $req->post('title_c');
			$autorization_c = $req->post('autorization_c');
			$company_p = $req->post('company_p');
			
			// foreach($array as $item) {
				// $textnew = $item['color']; 
				// $data = $cn->query("call uspIns_NewCompany_Palette('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
			// }
			
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCampaign('$title_c','$description_c',0,0,1,'$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/SaveCampaignConfig',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaignid = $req->post('campaignid');
			$textconfig_p = $req->post('textconfig_p');
			$textarray = json_decode($textconfig_p, true );
			$palette_p = $req->post('palette_p');
			$palettearray = json_decode( $palette_p, true );
			$material_p = $req->post('material_p');
			$materialarray = json_decode( $material_p, true );
			
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($textarray as $item) {
							$textnew = $item['text_config']; 
							$data = $cn->query("call uspIns_CampaignTexts('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($palettearray as $item) {
							$textnew = $item['color']; 
							$data = $cn->query("call uspIns_CampaignPalette('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($materialarray as $item) {
							$textnew = $item['id_material']; 
							$data = $cn->query("call uspIns_CampaignMaterial('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCampaign_TextConfig',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaignid = $req->post('campaignid');
			$textconfig_p = $req->post('textconfig_p');
			$array = json_decode( $textconfig_p, true );

			
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['text_config']; 
							$data = $cn->query("call uspIns_CampaignTexts('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		//CAMBIAR NOMBRE DEL SERVICIO
		'/NewCampaign_Palette',function() use ($app){
		
			//NO MOVER
			$allPostVars = $app->request->post();
			$req = $app->request();
			
			
			//CAMBIAR PARAMETROS
			$campaignid = $req->post('campaignid');
			$color_p = $req->post('color_p');
			$array = json_decode( $color_p, true );

			
			
				//NO MOVER
				
				//Replace the below connection parameters to fit your environment
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['color']; 
							$data = $cn->query("call uspIns_CampaignPalette('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						
						echo json_encode($data);
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/NewCampaign_Pack',function() use ($app){
						
				$allPostVars = $app->request->post();
				$req = $app->request();
						
				$dbms = 'mysql';
				$host = 'localhost'; 
				$db = 'mbledteq_wizad';
				$user = 'mbledteq_mrkt';
				$pass = 'Decaene09!';
				$dsn = "$dbms:host=$host;dbname=$db";

				$campaignid 	= $req->post('campaignid');
				$baseimage 		= $req->post('baseimage');
				$imagename 		= 'wizadImages/a.jpg';
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{							
									
					
								list($type, $baseimage) = explode(';', $data);
								list(, $baseimage)      = explode(',', $data);
								$baseimage = base64_decode($baseimage);
								file_put_contents($imagename, $baseimage);
							
							
							
						$callBack  = $cn->query("CALL uspIns_CampaignPack ('$campaignid','$imagename')")->fetchAll(PDO::FETCH_ASSOC);
						echo json_encode($imagename);
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//inicializamos la aplicacion(API)
$app->run();

