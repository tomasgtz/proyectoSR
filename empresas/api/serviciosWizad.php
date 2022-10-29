<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

cors();
define( 'API_ACCESS_KEY', 'AIzaSyBherwZbWKLAG1ZpIQvo1NbIyZjuoFYJ6o' );

function cors() {
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
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

$dbms = 'mysql';
$host = 'localhost:3307'; 
$db = 'wizadadm_wizad';
$user = 'wizadadm_mrkt';
$pass = 'Decaene09!';

//incluir el archivo principal
//include("Slim/Slim.php");
include("vendor/autoload.php");

//registran la instancia de slim
//\Slim\Slim::registerAutoloader();
//aplicacion 
// $app = new \Slim\Slim();

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, true);

$app->setBasePath("/wizad/empresas/api/serviciosWizad.php");

//routing 
//accediendo VIA URL
//http:///www.google.com/
//localhost/apirest/index.php/ => "Hola mundo ...."

$app->post(
		'/Authentication',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();

			// Get a single POST parameter
			
			$email_p = $allPostVars['email_p'];
			$password_p = $allPostVars['password_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{ 
						$data = $cn->query("call uspGet_LoggedUser('$email_p');")->fetchAll(PDO::FETCH_ASSOC);

						if (true === password_verify($password_p, $data[0]['password'])) {
							
							$response->getBody()->write( json_encode($data) );
   							return $response;
						}
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}
				
				$response->getBody()->write( json_encode(['Error' => 'Wrong credentials']) );
				return $response;
				
			}
);

//////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		
		'/Campaigns',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$idcompany_p = $allPostVars['idcompany_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Campaigns('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/NewCampaign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$name_p = $allPostVars['name_p'];
			$description_p = $allPostVars['description_p'];
			$userup_p = $allPostVars['userup_p'];
			$userupdate_p = $allPostVars['userupdate_p'];
			$dimension_p = $allPostVars['dimension_p'];
			$company_p = $allPostVars['company_p'];
            $download_p = $allPostVars['download_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCampaign('$name_p','$description_p','$userup_p','$userupdate_p','$dimension_p','$company_p', '$download_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		
		'/UCampaign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			
			$name_p = $allPostVars['name_p'];
			$description_p = $allPostVars['description_p'];
			$userupdate_p = $allPostVars['userupdate_p'];
			$dimension_p = $allPostVars['dimension_p'];
			$company_p = $allPostVars['company_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Campaign('$name_p','$description_p','$userupdate_p','$dimension_p','$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/UUserPhoto',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$userid = $allPostVars['userid'];
			$photo = $allPostVars['photo'];
			
				
				
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_UserPhoto('$userid','$photo');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/UUserLogo',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			
			
			
			$userid = $allPostVars['userid'];
			$photo = $allPostVars['photo'];
			
				
				
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_UserLogo('$userid','$photo');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/ISaveImageOnBank',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();

			$image = $allPostVars['image'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_SaveImageOnBank('$image');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/GImageBank',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_ImageBank();")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusCampaign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['company_p'];
			$status_p = $allPostVars['status_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCampaign('$campaign_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		
		'/Company',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company();")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/SelectedCompany',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_SelectedCompany('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewCompany',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$name_p = $allPostVars['name_p'];
			$address_p = $allPostVars['address_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCompany('$name_p','$address_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UCompany',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$name_p = $allPostVars['name_p'];
			$address_p = $allPostVars['address_p'];
			$company_p = $allPostVars['company_p'];
			$industry_p = $allPostVars['industry_p'];
			$noemployees_p = $allPostVars['noemployees_p'];
			$webpage_p = $allPostVars['webpage_p'];
			$pc_p = $allPostVars['pc_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Company('$name_p','$address_p','$company_p', '$industry_p', '$noemployees_p', '$pc_p', '$webpage_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusCompany',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$status_p = $allPostVars['status_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Company_TextConfig',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_TextConfig('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewCompany_TextConfig',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$textconfig_p = $allPostVars['textconfig_p'];
			$array = json_decode( $textconfig_p, true );

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['text_config']; 
							$data = $cn->query("call uspIns_NewCompany_TextConfig('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/NewCompany_Palette',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$color_p = $allPostVars['color_p'];
			$array = json_decode( $color_p, true );

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['color']; 
							$data = $cn->query("call uspIns_NewCompany_Palette('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UCompany_TextConfig',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$textconfig_p = $allPostVars['textconfig_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_UCompany_TextConfig('$company_p','$textconfig_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusCompany_TextConfig',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$status_p = $allPostVars['status_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany_TextConfig('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Company_Pack',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_Pack('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewCompany_Pack',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$image_p = $allPostVars['image_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCompany_Pack('$company_p','$image_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UCompany_Pack',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$image_p = $allPostVars['image_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Company_Pack('$company_p','$image_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusCompany_Pack',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$status_p = $allPostVars['status_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany_Pack('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Company_Subscription',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
		
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_Subscription('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewCompany_Subscription',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$subscription_p = $allPostVars['subscription_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCompany_Subscription('$company_p','$subscription_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UCompany_Subscription',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();

			$company_p = $allPostVars['company_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Company_Subscription('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusCompany_Subscription',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$company_p = $allPostVars['company_p'];
			$status_p = $allPostVars['status_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusCompany_Subscription('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Design',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Design('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewDesign',function (Request $request, Response $response, array $args) {
					
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];
			$user_p = $allPostVars['user_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewDesign('$campaign_p','$user_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UDesign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Design('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusDesign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
			$status_p = $allPostVars['status_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusDesign('$campaign_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Ct_Subscription',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Ct_Subscription();")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/SelectedCt_Subscription',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
			$subs_p = $allPostVars['subs_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_SelectedCt_Subscription('$subs_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewCt_Subscription',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$description_p = $allPostVars['description_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCt_Subscription('$description_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UCt_Subscription',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
			$description_p = $allPostVars['description_p'];
			$subs_p = $allPostVars['subs_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Ct_Subscription('$description_p'.'$subs_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Ct_Dimensions',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Ct_Dimensions('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewCt_Dimensions',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];
			$height_p = $allPostVars['height_p'];
			$width_p = $allPostVars['width_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCt_Dimensions('$campaign_p','$height_p','$width_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$app->post(
		
		'/UCt_Dimensions',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];
			$height_p = $allPostVars['height_p'];
			$width_p = $allPostVars['width_p'];
			$description_p = $allPostVars['description_p'];	

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Ct_Dimensions('$campaign_p','$height_p','$width_p','$description_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Det_Subscription',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Det_Subscription('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewDet_Subscription',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$subs_p = $allPostVars['subs_p'];
			$price_p = $allPostVars['price_p'];
			$individualusercost_p = $allPostVars['individualusercost_p'];
			$image_p = $allPostVars['image_p'];
			$firstplus_p = $allPostVars['firstplus_p'];
			$secplus_p = $allPostVars['secplus_p'];
			$thirdplus_p = $allPostVars['thirdplus_p'];
			$frthplus_p = $allPostVars['frthplus_p'];
			$fifthplus_p = $allPostVars['fifthplus_p'];
			$sixthplus_p = $allPostVars['sixthplus_p'];
			$sevnplus_p = $allPostVars['sevnplus_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewDet_Subscription('$subs_p','$price_p','$individualusercost_p','$image_p','$firstplus_p','$secplus_p','$thirdplus_p','$frthplus_p','$fifthplus_p','$sixthplus_p','$sevnplus_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UDet_Subscription',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$subs_p = $allPostVars['subs_p'];
			$price_p = $allPostVars['price_p'];
			$individualusercost_p = $allPostVars['individualusercost_p'];
			$image_p = $allPostVars['image_p'];
			$firstplus_p = $allPostVars['firstplus_p'];
			$secplus_p = $allPostVars['secplus_p'];
			$thirdplus_p = $allPostVars['thirdplus_p'];
			$frthplus_p = $allPostVars['frthplus_p'];
			$fifthplus_p = $allPostVars['fifthplus_p'];
			$sixthplus_p = $allPostVars['sixthplus_p'];
			$sevnplus_p = $allPostVars['sevnplus_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Det_Subscription('$subs_p','$price_p','$individualusercost_p','$image_p','$firstplus_p','$secplus_p','$thirdplus_p','$frthplus_p','$fifthplus_p','$sixthplus_p','$sevnplus_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/Control_Historic',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Control_Historic('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/NewControl_Historic',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$user_p = $allPostVars['user_p'];
			$description_p = $allPostVars['description_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewControl_Historic('$user_p','$description_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UControl_Historic',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$user_p = $allPostVars['user_p'];
			$description_p = $allPostVars['description_p'];
			$company_p = $allPostVars['company_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Control_Historic('$user_p','$description_p','$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusControl_Historic',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$user_p = $allPostVars['user_p'];
			$description_p = $allPostVars['description_p'];
			$company_p = $allPostVars['company_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusControl_Historic('$user_p','$description_p','$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/General_Messages',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_General_Messages('$company_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/UGeneral_Messages',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$idgmessage_p = $allPostVars['idgmessage_p'];
			$userup_p = $allPostVars['userup_p'];
			$usersend_p = $allPostVars['usersend_p'];
			$userreceive_p = $allPostVars['userreceive_p'];
			$focusgroup_p = $allPostVars['focusgroup_p'];
			$message_p =$allPostVars['message_p'];

				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_General_Messages('$company_p','$idgmessage_p','$userup_p','$usersend_p','$userreceive_p','$focusgroup_p','$message_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post(
		
		'/StatusGeneral_Messages',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$company_p = $allPostVars['company_p'];
			$status_p = $allPostVars['status_p'];			

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_StatusGeneral_Messages('$company_p','$status_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/UUser',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();

			$name_p = $allPostVars['name_p'];
			$password_p = password_hash($allPostVars['password_p'], PASSWORD_DEFAULT);
			$mobilephone_p = $allPostVars['mobilephone_p'];
			$homephone_p = $allPostVars['homephone_p'];
			$iduser_p = $allPostVars['iduser_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_User('$name_p','$password_p','$mobilephone_p', '$homephone_p', '$iduser_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/UUserGeneralData',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$name_p = $allPostVars['name_p'];
			$namenoemail_p = $allPostVars['namenoemail_p'];
			$mobilephone_p = $allPostVars['mobilephone_p'];
			$homephone_p = $allPostVars['homephone_p'];
			$iduser_p = $allPostVars['iduser_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_UserGeneralData('$iduser_p', '$name_p','$namenoemail_p', '$homephone_p', '$mobilephone_p' );")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/GUserCompany',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();

			$idcompany_p = $allPostVars['idcompany_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_UsersCompany('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/UUserFreeCampaign',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$userArray = $allPostVars['user'];
			$userArray = json_decode($userArray, true );

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						foreach($userArray as $item) {
							$textnew = $item['id_user']; 
							$value 	 = $item['free_campaign']; 
							$data = $cn->query("call uspUpd_UserFreeCampaign('$value', '$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/GTextsCompany',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
		
			$idcompany_p = $allPostVars['idcompany_p'];
		
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_TextCompany('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/GPaletteCompany',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$idcompany_p = $allPostVars['idcompany_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_PaletteCompany('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/GFontsCompany',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$idcompany_p = $allPostVars['idcompany_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_Fonts('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/GPackCompany',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$idcompany_p = $allPostVars['idcompany_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Company_Pack('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/GMaterials',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_Materials();")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/GPaletteCampaign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignPalette('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		
		'/GTextsCampaign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignTexts('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		
		'/GMaterialsCampaign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignMaterial('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);
$app->post(
		
		'/GPackCampaign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];
			$category_p = $allPostVars['category_p'];
				
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignPack('$campaign_p', '$category_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/GPackIdentity',function (Request $request, Response $response, array $args) {
				
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
		
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_IdentityImages('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/GFontsCampaign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaign_p = $allPostVars['campaign_p'];
			$host_p = $allPostVars['host_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CampaignFonts('$campaign_p','$host_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

//Deletes Campaign Features

$app->post(
		
		'/DPaletteCampaign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignPalette('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/DTextsCampaign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignTexts('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/DMaterialsCampaign',function (Request $request, Response $response, array $args) {
				
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignMaterial('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/DPackCampaign',function (Request $request, Response $response, array $args) {
				
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignPack('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/DFontsCampaign',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspDel_CampaignFonts('$campaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

// Campaign Insert services features

$app->post(
		
		'/IPaletteCampaign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
			$color_p = $allPostVars['color_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignPalette('$campaign_p','$color_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/IMaterialCampaign',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
			$material_p = $allPostVars['material_p'];
			$download_p = $allPostVars['download_p'];

	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignMaterial('$campaign_p','$material_p', '$download_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/ITextCampaign',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
			$text_p = $allPostVars['text_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignTexts('$campaign_p','$text_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/IFontCampaign',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
			$font_p = $allPostVars['font_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignFonts('$campaign_p','$font_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/IPackCampaign',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();

			$campaign_p = $allPostVars['campaign_p'];
			$pack_p = $allPostVars['pack_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_CampaignPack('$campaign_p','$pack_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/NewMaterial',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$description_p = $allPostVars['description_p'];
			$width_p = $allPostVars['width_p'];
			$height_p = $allPostVars['height_p'];
			$thumbnail_p = $allPostVars['thumbnail_p'];
	
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_Material('$description_p','$width_p','$height_p','$thumbnail_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/UpdMaterial',function (Request $request, Response $response, array $args) {
			
			$allPostVars = (array)$request->getParsedBody();

			$description_p = $allPostVars['description_p'];
			$width_p = $allPostVars['width_p'];
			$height_p = $allPostVars['height_p'];
			$thumbnail_p = $allPostVars['thumbnail_p'];
			$material_p = $allPostVars['material_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_Material('$description_p','$width_p','$height_p','$thumbnail_p','$material_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/UpdMaterialStatus',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();

			$status_p = $allPostVars['status_p'];
			$material_p = $allPostVars['material_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_Material('$status_p','$material_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/AllUsersAdmin',function (Request $request, Response $response, array $args) {
				
			$allPostVars = (array)$request->getParsedBody();

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_AllUsersAdmin();")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/AllCompaniesAdmin',function (Request $request, Response $response, array $args) {
				
			$allPostVars = (array)$request->getParsedBody();

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_AllCompaniesSubs();")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/CountSubscriptions',function (Request $request, Response $response, array $args) {
					
			$allPostVars = (array)$request->getParsedBody();

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspGet_CountSubscriptions();")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/NewUser',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();

			$username_p = $allPostVars['username_p'];
			$company_p = $allPostVars['company_p'];
			$name_p = $allPostVars['name_p'];
			$password_p = $allPostVars['password_p'];
			$password_encrypted = password_hash($allPostVars['password_p'], PASSWORD_DEFAULT);
			$homephone_p = $allPostVars['homephone_p'];
			$mobilephone_p = $allPostVars['mobilephone_p'];
			$fromPublic = $allPostVars['fp'];
			$grecaptcharesponse = $allPostVars['grecaptcharesponse'];

			if($fromPublic == '1') {

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
				curl_setopt($ch, CURLOPT_POST, 1);

				curl_setopt($ch, CURLOPT_POSTFIELDS, 
				http_build_query(array('secret' => '6Lcc_VwUAAAAAGx1OaVcT9Uwg-TBCclJH7ChwhEG',
					'response' => $grecaptcharesponse)));

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
				curl_close ($ch);
				$response = json_decode($server_output);

				if(!isset($response) || !isset($response->success) || $response->success === false) {
					$data[0]["returnMessage"] = "ERROR: NO CAPTCHA";
					$response->getBody()->write( json_encode($data) ); 
				        return $response;
					return ;
				}
				
			}


			$to   = $name_p;
			$from = 'notificaciones@wizad.mx';
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "CC: notificaciones@wizad.mx, \r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message =  '<html>
							<head>
								<title>Wizad</title>
							</head>
							<body>
								<h1>Ya eres parte de WIZAD, tus datos son los siguientes:</h1>
								<table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
									<tr>
										<th>Usuario:</th><td>  '.$name_p.'  </td>
									</tr>
									<tr style="background-color: #e0e0e0;">
										<th>Contrase&ntilde;a:</th><td>  '.$password_p.'   </td>
									</tr>
									<tr>
										<th>Sitio Web:</th><td><a href="http://empresas.wizad.mx">WIZAD</a></td>
									</tr>
								</table>
							</body>
						</html>';
				
				
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						$data = $cn->query("call uspGet_UserExist('$name_p');")->fetchAll(PDO::FETCH_ASSOC);
						$jsonresult = json_encode($data[0]);
						$jsond = json_decode($jsonresult, true);
						$name = $jsond['name'];
						$test = 0;
						
						if ( $name == null ){


							$data = $cn->query("call uspIns_NewUser('$company_p','$name_p','$password_encrypted','$homephone_p','$mobilephone_p', '$username_p');")->fetchAll(PDO::FETCH_ASSOC);

							if($data[0]["returnMessage"] == "ERROR: MAX USERS") {
								$response->getBody()->write( json_encode($data) ); 
								return $response;
								return;
							}
							
							mail($to, "Wizad - Registrate", $message, $headers);
							$response->getBody()->write( json_encode($data) ); 
							return $response;
						
						}else{
							$data[0]["returnMessage"] = "Ya existe";
							$response->getBody()->write( json_encode($data) ); 
							return $response;
						}
						
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/Comentario',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			
			$nombrec = $allPostVars['nombrec'];
			$correoc = $allPostVars['correoc'];
			$companiac = $allPostVars['companiac'];
			$telc = $allPostVars['telc'];
			$comentariosc = $allPostVars['comentariosc'];
			$wizademail = "contacto@wizad.mx";
			
			$to   = $wizademail;
			$from = 'notificaciones@wizad.mx';
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "CC: notificaciones@wizad.mx, contacto@wizad.mx\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message =  '<html>
							<head>
								<title>Wizad</title>
							</head>
							<body>
								<h1>Recibiste un comentario de:</h1>
								<h3>'.$nombrec.'<h3><br/>
								<h3>Correo: '.$correoc.'<h3><br/>
								<h3>Negocio: '.$companiac.'<h3><br/>
								<h3>Telefono: '.$telc.'<h3><br/>
								<h3>Comentarios: '.$comentariosc.'<h3><br/>
							</body>
						</html>';
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						$data = $cn->query("call uspGet_UserExist('$name_p');")->fetchAll(PDO::FETCH_ASSOC);
						$jsonresult = json_encode($data[0]);
						$jsond = json_decode($jsonresult, true);
						$name = $jsond['name'];
						$test = 0;
						
						if ( $name == null ){
							$data = $cn->query("call uspIns_NewUser('$company_p','$name_p','$password_p','$homephone_p','$mobilephone_p', '$username_p');")->fetchAll(PDO::FETCH_ASSOC);
						
							mail($to, "Wizad - Comentario", $message, $headers);
							$response->getBody()->write( json_encode($data) ); 
							return $response;
						}else{
							$data = "Ya existe";
							$response->getBody()->write( json_encode($data) ); 
							return $response;
						}
						
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/NewUserLanding',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			
			$company_p = $allPostVars['company_p'];
			$name_p = $allPostVars['name_p'];
			$password_p = $allPostVars['password_p'];
			$password_encrypted = password_hash($allPostVars['password_p'], PASSWORD_DEFAULT);
			$homephone_p = $allPostVars['homephone_p'];
			$mobilephone_p = $allPostVars['mobilephone_p'];
			 			
			
			$to   = $name_p;
			$from = 'sistema@wizad.com';
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "CC: sonia@wizad.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message =  '<html>
							<head>
								<title>Wizad</title>
							</head>
							<body>
								<h1>Ya eres parte de WIZAD, tus datos son los siguientes:</h1>
								<table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
									<tr>
										<th>Usuario:</th><td>  '.$name_p.'  </td>
									</tr>
									<tr style="background-color: #e0e0e0;">
										<th>Contrase&ntilde;a:</th><td>  '.$password_p.'   </td>
									</tr>
									<tr>
										<th>Sitio Web:</th><td><a href="http://empresas.wizad.mx">http://empresas.wizad.mx</a></td>
									</tr>
								</table>
							</body>
						</html>';
				
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						$data = $cn->query("call uspGet_UserExist('$name_p');")->fetchAll(PDO::FETCH_ASSOC);
						$jsonresult = json_encode($data[0]);
						$jsond = json_decode($jsonresult, true);
						$name = $jsond['name'];
						$test = 0;
						
						if ( $name == null ){
							$data = $cn->query("call uspIns_NewUser('$company_p','$name_p','$password_encrypted','$homephone_p','$mobilephone_p');")->fetchAll(PDO::FETCH_ASSOC);
						
							mail($to, "Wizad - Registrate", $message, $headers);

							$data = "Usuario registrado exitosamente, se envi� tu contrase�a por correo. �Ya puedes iniciar en nuestra plataforma!";
							$response->getBody()->write( json_encode($data) ); 
							return $response;
						
						}else{
							$data = "Este usuario ya se encuentra registrado.";
							$response->getBody()->write( json_encode($data) ); 
							return $response;
						}
						
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/RecoverPassword',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$password_p = $allPostVars['password_p'];
			$password_encrypted = password_hash($allPostVars['password_p'], PASSWORD_DEFAULT);
			$email_p = $allPostVars['email_p'];
			
			$to   = $email_p;
			$from = 'sistema@wizad.com';
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "CC: sonia@wizad.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message =  '<html>
							<head>
								<title>Wizad</title>
							</head>
							<body>
								<h1>Nueva contrase&ntilde;a para acceder:</h1>
								<table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
									<tr>
										<th>Usuario:</th><td>  '.$email_p.'  </td>
									</tr>
									<tr style="background-color: #e0e0e0;">
										<th>Contrase&ntilde;a:</th><td>  '.$password_p.'   </td>
									</tr>
									<tr>
										<th>Sitio Web:</th><td><a href="https://empresas.wizad.mx/">WIZAD</a></td>
									</tr>
								</table>
							</body>
						</html>';
				
				
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_UserPassword('$password_encrypted','$email_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						mail($to, "Wizad - Nueva clave", $message, $headers);
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/SaveNewCampaign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$description_c = $allPostVars['description_c'];
			$title_c = $allPostVars['title_c'];
			$autorization_c = $allPostVars['autorization_c'];
			$company_p = $allPostVars['company_p'];
			$segment_c = $allPostVars['segment_c'];
			$city_c = $allPostVars['city_c'];
			$age_c = $allPostVars['age_c'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspIns_NewCampaign('$title_c','$description_c',0,0,1,'$company_p','$segment_c','$city_c','$age_c', '$autorization_c');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/SaveCampaignConfig',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaignid = $allPostVars['campaignid'];
			$textconfig_p = $allPostVars['textconfig_p'];
			$textarray = json_decode($textconfig_p, true );
			$palette_p = $allPostVars['palette_p'];
			$palettearray = json_decode( $palette_p, true );
			$material_p = $allPostVars['material_p'];
			$materialarray = json_decode( $material_p, true );
			$image_p = $allPostVars['image_p'];
			$imagearray = json_decode( $image_p, true );
			$font_p = $allPostVars['font_p'];
			$fontarray = json_decode( $font_p, true );
			
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


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
						foreach($imagearray as $item) {
							$textnew = $item['pack']; 
							$data = $cn->query("call uspIns_CampaignPack('$campaignid','$textnew', 'identidad');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($fontarray as $item) {
							$textnew = $item['font']; 
							$data = $cn->query("call uspIns_CampaignFonts('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/SaveCampaignUpdate',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$campaignid = $allPostVars['campaignid'];
			$newTextArray = $allPostVars['newTextArray'];
			$newTextArray = json_decode($newTextArray, true );
			$newPaletteArray = $allPostVars['newPaletteArray'];
			$newPaletteArray = json_decode( $newPaletteArray, true );
			$newMaterialArray = $allPostVars['newMaterialArray'];
			$newMaterialArray = json_decode( $newMaterialArray, true );
			$newPackArray = $allPostVars['newPackArray'];
			$newPackArray = json_decode( $newPackArray, true );
			$newFontArray = $allPostVars['newFontArray'];
			$newFontArray = json_decode( $newFontArray, true );
			$delTextArray = $allPostVars['delTextArray'];
			$delTextArray = json_decode($delTextArray, true );
			$delPaletteArray = $allPostVars['delPaletteArray'];
			$delPaletteArray = json_decode( $delPaletteArray, true );
			$delMaterialArray = $allPostVars['delMaterialArray'];
			$delMaterialArray = json_decode( $delMaterialArray, true );
			$delPackArray = $allPostVars['delPackArray'];
			$delPackArray = json_decode( $delPackArray, true );
			$delFontArray = $allPostVars['delFontArray'];
			$delFontArray = json_decode( $delFontArray, true );
			$autorization = $allPostVars['autorization'];
			$name         = $allPostVars['name'];
			$description  = $allPostVars['description'];
			$userupdate   = $allPostVars['userupdate'];
                       		
			
			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			try
			{

				$data = $cn->query("call uspUpd_Campaign('$name', '$description', '$userupdate', '$campaignid', '$autorization' );");

				//New items to campaign update
				if(is_array($newTextArray) && count($newTextArray) > 0) {
					foreach($newTextArray as $item) {
						$textnew = $item['text']; 
						$data = $cn->query("call uspIns_CampaignTexts('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}

				if(is_array($newPaletteArray) && count($newPaletteArray) > 0) {
					foreach($newPaletteArray as $item) {
						$textnew = $item['color']; 
						$data = $cn->query("call uspIns_CampaignPalette('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}

				if(is_array($newMaterialArray) && count($newMaterialArray) > 0) {
					foreach($newMaterialArray as $item) {
						$textnew = $item['id_material']; 
						$data = $cn->query("call uspIns_CampaignMaterial('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}

				if(is_array($newPackArray) && count($newPackArray) > 0) {
					foreach($newPackArray as $item) {
						$textnew = $item['image']; 
						$category = $item['category']; 
						$data = $cn->query("call uspIns_CampaignPack('$campaignid','$textnew', '$category');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}

				if(is_array($newFontArray) && count($newFontArray) > 0) {
					foreach($newFontArray as $item) {
						$textnew = $item['font']; 
						$data = $cn->query("call uspIns_CampaignFonts('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}						
				//Drop items to campaign update	


				if(is_array($delTextArray) && count($delTextArray) > 0) {
					foreach($delTextArray as $item) {
						$textnew = $item['id_cgtext']; 
						$data = $cn->query("call uspDel_CampaignTexts('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}

				if(is_array($delPaletteArray) && count($delPaletteArray) > 0) {
					foreach($delPaletteArray as $item) {
						$textnew = $item['id_cgpalette']; 
						$data = $cn->query("call uspDel_CampaignPalette('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}

				if(is_array($delMaterialArray) && count($delMaterialArray) > 0) {
					foreach($delMaterialArray as $item) {
						$textnew = $item['id_material']; 
						$data = $cn->query("call uspDel_CampaignMaterial('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}

				}

				if(is_array($delPackArray) && count($delPackArray) > 0) {
					foreach($delPackArray as $item) {
						$textnew = $item['id_cgpack']; 
						$data = $cn->query("call uspDel_CampaignPack('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}
				}

				if(is_array($delFontArray) && count($delFontArray) > 0) {
					foreach($delFontArray as $item) {
						$textnew = $item['id_cgfont']; 
						$data = $cn->query("call uspDel_CampaignFonts('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
					}

				}
				$data = null;
				$data[] = array('returnMessage' => "SUCCESS");	
				$response->getBody()->write( json_encode($data) ); 
				return $response;
			}
			
			catch(PDOException $e) {
					echo "Error: ".$e->getMessage();
			}			
				
					
		}
);

$app->post(
		
		'/SaveCompanyUpdate',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$company_p = $allPostVars['company_p'];
			$newTextArray = $allPostVars['newTextArray'];
			$newTextArray = json_decode($newTextArray, true );
			$newPaletteArray = $allPostVars['newPaletteArray'];
			$newPaletteArray = json_decode( $newPaletteArray, true );
			$newMaterialArray = $allPostVars['newMaterialArray'];
			$newMaterialArray = json_decode( $newMaterialArray, true );
			$newPackArray = $allPostVars['newPackArray'];
			$newPackArray = json_decode( $newPackArray, true );
			$newFontArray = $allPostVars['newFontArray'];
			$newFontArray = json_decode( $newFontArray, true );
			$delTextArray = $allPostVars['delTextArray'];
			$delTextArray = json_decode($delTextArray, true );
			$delPaletteArray = $allPostVars['delPaletteArray'];
			$delPaletteArray = json_decode( $delPaletteArray, true );
			$delMaterialArray = $allPostVars['delMaterialArray'];
			$delMaterialArray = json_decode( $delMaterialArray, true );
			$delPackArray = $allPostVars['delPackArray'];
			$delPackArray = json_decode( $delPackArray, true );
			$delFontArray = $allPostVars['delFontArray'];
			$delFontArray = json_decode( $delFontArray, true );
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
					//New items to campaign update
						foreach($newTextArray as $item) {
							$textnew = $item['text']; 
							$data = $cn->query("call uspIns_NewCompany_TextConfig('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($newPaletteArray as $item) {
							$textnew = $item['color']; 
							$data = $cn->query("call uspIns_NewCompany_Palette('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($newPackArray as $item) {
							$textnew = $item['image']; 
							$data = $cn->query("call uspIns_NewCompany_Pack('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($newFontArray as $item) {
							$textnew = $item['font']; 
							$data = $cn->query("call uspIns_NewCompany_Font('$company_p','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
					//Drop items to campaign update	
						foreach($delTextArray as $item) {
							$textnew = $item['id_config']; 
							$data = $cn->query("call uspDel_Company_Text('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($delPaletteArray as $item) {
							$textnew = $item['id_palette']; 
							$data = $cn->query("call uspDel_Company_Palette('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($delPackArray as $item) {
							$textnew = $item['id_pack']; 
							$data = $cn->query("call uspDel_Company_Pack('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						foreach($delFontArray as $item) {
							$textnew = $item['id_font']; 
							$data = $cn->query("call uspDel_Company_Font('$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/NewCampaign_TextConfig',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaignid = $allPostVars['campaignid'];
			$textconfig_p = $allPostVars['textconfig_p'];
			$array = json_decode( $textconfig_p, true );

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['text_config']; 
							$data = $cn->query("call uspIns_CampaignTexts('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/NewCampaign_Palette',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$campaignid = $allPostVars['campaignid'];
			$color_p = $allPostVars['color_p'];
			$array = json_decode( $color_p, true );

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						foreach($array as $item) {
							$textnew = $item['color']; 
							$data = $cn->query("call uspIns_CampaignPalette('$campaignid','$textnew');")->fetchAll(PDO::FETCH_ASSOC);
						}
						
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/NewCampaign_Pack',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
						
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db";

				$campaignid = $allPostVars['campaignid'];
				$baseimage = $allPostVars['baseimage'];
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
						
						$response->getBody()->write( json_encode($imagename) ); 
				        return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GCities',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{						
						$callBack  = $cn->query("CALL uspGet_Cities ()")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($callBack) ); 
				        return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GStates',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
							
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{						
						$callBack  = $cn->query("CALL uspGet_States()")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GCountries',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
					
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{						
						$callBack  = $cn->query("CALL uspGet_Countries()")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GAges',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{							
								
						$callBack  = $cn->query("CALL uspGet_Ages ()")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GSegments',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_Segments ()")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/IAdminInbox',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$name_c = $allPostVars['name_c'];
				$message_c = $allPostVars['message_c'];
				$company_c = $allPostVars['company_c'];
				$email_c = $allPostVars['email_c'];
				$phone_c = $allPostVars['phone_c'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspIns_Inbox ('$name_c', '$message_c', '$company_c', '$email_c', '$phone_c' )")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GAdmin_Inbox',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_Inbox()")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/UInbox',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
			
				$idinbox_c = $allPostVars['idinbox_c'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspUpd_Inbox ('$idinbox_c')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/AddHistory',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$user_p = $allPostVars['user_p'];
				$message_p = $allPostVars['message_p'];
				$campaign_p = $allPostVars['campaign_p'];

				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspIns_AddHistory ('$user_p','$message_p','$campaign_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/DUser',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$user_p = $allPostVars['user_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspDel_User ('$user_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/UUserStatus',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();

				$user_p = $allPostVars['user_p'];
				$status_p = $allPostVars['status_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspUpd_UserStatus ('$status_p','$user_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/UCompanyStatus',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();

				$company_p = $allPostVars['company_p'];
				$status_p = $allPostVars['status_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspUpd_CompanyStatus ('$status_p','$company_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/UMaterialStatus',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();

				$idmaterial_p = $allPostVars['idmaterial_p'];
				$status_p = $allPostVars['status_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspUpd_MaterialStatus ('$idmaterial_p','$status_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/IMaterial',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$type_c = $allPostVars['type_p'];
				$size_description_p = $allPostVars['size_description_p'];
				$description_p = $allPostVars['description_p'];
				$width_p = $allPostVars['width_p'];
				$height_p = $allPostVars['height_p'];
				$multipage_p = $allPostVars['multipage_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspIns_NewMaterial ('$type_p','$size_description_p','$description_p','$width_p','$height_p', $multipage_p)")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/UFreeMaterial',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$idmaterial_p = $allPostVars['idmaterial_p'];
				$free_p = $allPostVars['free_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspUpd_FreeMaterial ('$idmaterial_p','$free_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/UMaterialMultipage',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();

				$idmaterial_p = $allPostVars['idmaterial_p'];
				$multipage_p = $allPostVars['multipage_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspUpd_MultipageMaterial ('$idmaterial_p','$multipage_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/DCampaign',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
						
				$campaign_p = $allPostVars['campaign_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspDel_Campaign ('$campaign_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GFonts',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_Fonts ()")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/NewVisit',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspIns_NewVisit ()")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/DashboardCount',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$array = array();
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_UserCounts ()")->fetchAll(PDO::FETCH_ASSOC);
						array_push($array, $callBack);
						$callBack  = $cn->query("CALL uspGet_VisitCount ()")->fetchAll(PDO::FETCH_ASSOC);
						array_push($array, $callBack);
						$callBack  = $cn->query("CALL uspGet_CampaignCount ()")->fetchAll(PDO::FETCH_ASSOC);
						array_push($array, $callBack);
						$callBack  = $cn->query("CALL uspGet_FreeUsers ()")->fetchAll(PDO::FETCH_ASSOC);
						array_push($array, $callBack);

						$response->getBody()->write( json_encode($array) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GetHistory',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$array = array();
				$idcompany_p = $allPostVars['idcompany_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_HistoryGeneral ('$idcompany_p')")->fetchAll(PDO::FETCH_ASSOC);
						array_push($array, $callBack);
						$callBack  = $cn->query("CALL uspGet_HistoryCampaign ('$idcompany_p')")->fetchAll(PDO::FETCH_ASSOC);
						array_push($array, $callBack);
						
						$response->getBody()->write( json_encode($array) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GetAllSubscriptions',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$array = array();
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_AllSubscriptions ()")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/GHistoryCompany',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$idcompany_p = $allPostVars['idcompany_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_HistoryCompany ('$idcompany_p')")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/ICompanyNAdminUser',function (Request $request, Response $response, array $args) {
						
			$allPostVars = (array)$request->getParsedBody();
			
			$nameusernoemail 		= $allPostVars['nameusernoemail'];
			$name_p 		= $allPostVars['name_p'];
			$address_p 		= $allPostVars['address_p'];
			$logo_p 		= $allPostVars['logo_p'];
			$city_p 		= $allPostVars['city_p'];
			$state_p 		= $allPostVars['state_p'];
			$country_p 		= $allPostVars['country_p'];
			$nameuser_p 	= $allPostVars['nameuser_p'];
			$password_p 	= $allPostVars['password_p'];
			$password_encrypted 	= password_hash($allPostVars['password_p'], PASSWORD_DEFAULT);
			$homephone_p 	= $allPostVars['homephone_p'];
			$mobilephone_p 	= $allPostVars['mobilephone_p'];
			$employees_p 	= $allPostVars['employees_p'];
			$industry_p 	= $allPostVars['industry_p'];
			$webpage_p 		= $allPostVars['webpage_p'];
			$pc_p	 		= $allPostVars['pc_p'];
			$subs_p	 		= $allPostVars['subs_p'];
			$storage_p	 	= $allPostVars['storage_p'];
			$freq_p			= $allPostVars['freq_p'];
			
			$to   = $nameuser_p;
			$from = 'sistema@wizad.com';
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "CC: sonia@wizad.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message =  '<html>
							<head>
								<title>Wizad</title>
							</head>
							<body>
								<h1>Nueva contrase&ntilde;a para acceder:</h1>
								<table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
									<tr>
										<th>Usuario:</th><td>  '.$nameuser_p.'  </td>
									</tr>
									<tr style="background-color: #e0e0e0;">
										<th>Contrase&ntilde;a:</th><td>  '.$password_p.'   </td>
									</tr>
									<tr>
										<th>Sitio Web:</th><td><a href="https://empresas.wizad.mx/">WIZAD</a></td>
									</tr>
								</table>
							</body>
						</html>';
			
			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
			
			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			try
			{					
					$callBack  = $cn->query("CALL uspIns_NewCompany ('$name_p','$address_p','$logo_p','$city_p','$employees_p','$industry_p','$webpage_p', '$pc_p', '$storage_p', '$state_p','$country_p')")->fetchAll(PDO::FETCH_ASSOC);
					$callBack  = $cn->query("CALL uspGet_NewCompanyID ()")->fetchAll(PDO::FETCH_ASSOC);
					$jsonresult = json_encode($callBack[0]);
					$jsond = json_decode($jsonresult, true);
					$id_company = $jsond['id_company'];
					
					if ( $id_company > 0 ){
						$data = $cn->query("call uspIns_CompanySubscription('$id_company','$subs_p', '$freq_p');")->fetchAll(PDO::FETCH_ASSOC);
						$data = $cn->query("call uspIns_NewAdminUser('$id_company','$nameuser_p','$password_encrypted','$homephone_p','$mobilephone_p', '$nameusernoemail');")->fetchAll(PDO::FETCH_ASSOC);
					
						mail($to, "Wizad - Inicia", $message, $headers);
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
					}else{

						$response->getBody()->write( json_encode($id_company) ); 
				        return $response;
					}
					
			}
			
			catch(Exception $e) {
					echo $e->getMessage();
			}			
			
				
		}
);

$app->post(
		'/NotifyAdministratorFreeCampaign',function (Request $request, Response $response, array $args) {
						
			$allPostVars = (array)$request->getParsedBody();
			

			$idcompany_p = $allPostVars['idcompany_p'];
			$user_p = $allPostVars['user_p'];
			
			$from = 'sistema@wizad.com';
			$headers = "From: " . strip_tags($from) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			$headers .= "CC: sonia@wizad.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			
			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
			
			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			try
			{					
					$callBack  = $cn->query("CALL uspGet_CompanyAdministrator ('$idcompany_p')")->fetchAll(PDO::FETCH_ASSOC);
					$jsonresult = json_encode($callBack[0]);
					$jsond = json_decode($jsonresult, true);
					$to = $jsond['name'];
					
					$message =  '<html>
							<head>
								<title>Wizad</title>
							</head>
							<body>
								<h1>Campa&ntilde;a Libre</h1>
								<table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
									<tr>
										<th>El usuario empez&oacute; una campa&ntilde;a libre:</th><td>  '.$user_p.'  </td>
									</tr>
									<tr>
										<th>Sitio Web:</th><td><a href="https://empresas.wizad.mx/">WIZAD</a></td>
									</tr>
								</table>
							</body>
						</html>';
					
					mail($to, "Wizad - NOTIFICACION", $message, $headers);
					$response->getBody()->write( json_encode($callBack) );  
					return $response;
					
			}
			
			catch(Exception $e) {
					echo $e->getMessage();
			}			
			
				
		}
);


$app->post(
		'/GetDownloadPermission',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$array = array();

				$idcampaign_p = $allPostVars['idcampaign_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspGet_CampaignDownloadPermission ('$idcampaign_p')")->fetchAll(PDO::FETCH_ASSOC);
						array_push($array, $callBack);
						
						$response->getBody()->write( json_encode($array) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		'/DTemplate',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
			
				$idtemplate_p = $allPostVars['idtemplate_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspDel_Template('$idtemplate_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		'/DDesign',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
				$idudesign_p = $allPostVars['idudesign_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
						$callBack  = $cn->query("CALL uspDel_Design('$idudesign_p')")->fetchAll(PDO::FETCH_ASSOC);
						$response->getBody()->write( json_encode($callBack) );  
						return $response;
				}
				
				catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		'/GTemplates',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$idcompany_p = $allPostVars['idcompany_p'];
			$idmaterial_p = $allPostVars['idmaterial_p'];
			$idcampaign_p = $allPostVars['idcampaign_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{ 
						$data = $cn->query("call uspGet_Templates('$idcompany_p', '$idmaterial_p', '$idcampaign_p');")->fetchAll(PDO::FETCH_ASSOC);
					
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
			}
);

$app->post(
		'/GDesigns',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$idcompany_p = $allPostVars['idcompany_p'];
			$iduser_p = $allPostVars['iduser_p'];
			$idcampaign_p = $allPostVars['idcampaign_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{ 
						$data = $cn->query("call uspGet_UDesigns('$idcompany_p', '$iduser_p', '$idcampaign_p');")->fetchAll(PDO::FETCH_ASSOC);
					
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
			}
);


$app->post(
		'/GTemplatesThumbs',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$iduser_p = $allPostVars['iduser_p'];
			$page_p = $allPostVars['page_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			try
			{ 
					$data = $cn->query("call uspGet_TemplatesThumbsList('$iduser_p', '$page_p');")->fetchAll(PDO::FETCH_ASSOC);
				
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
			}
			catch(PDOException $e) {
					echo $e->getMessage();
			}			
			
		}
);

$app->post(
		'/GDesignsThumbs',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$iduser_p = $allPostVars['iduser_p'];
			$page_p = $allPostVars['page_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			try
			{ 
					$data = $cn->query("call uspGet_DesignsThumbsList('$iduser_p', '$page_p');")->fetchAll(PDO::FETCH_ASSOC);
				
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
			}
			catch(PDOException $e) {
					echo $e->getMessage();
			}			
			
		}
);

$app->post(
		'/GTemplatesThumbsCount',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$iduser_p = $allPostVars['iduser_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			try
			{ 
					$data = $cn->query("call uspGet_TemplatesThumbsListCOUNT('$iduser_p');")->fetchAll(PDO::FETCH_ASSOC);
				
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
			}
			catch(PDOException $e) {
					echo $e->getMessage();
			}			
			
		}
);

$app->post(
		'/GDesignsThumbsCount',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$iduser_p = $allPostVars['iduser_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			try
			{ 
					$data = $cn->query("call uspGet_DesignsThumbsListCOUNT('$iduser_p');")->fetchAll(PDO::FETCH_ASSOC);
				
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
			}
			catch(PDOException $e) {
					echo $e->getMessage();
			}			
			
		}
);



$app->post(
		'/GTemplate',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$idtemplate_p = $allPostVars['idtemplate_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{ 
						$data = $cn->query("call uspGet_Template('$idtemplate_p');")->fetchAll(PDO::FETCH_ASSOC);
					
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
			}
);


$app->post(
		'/GDesign',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			
			$idudesign_p = $allPostVars['idudesign_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{ 
						$data = $cn->query("call uspGet_UDesign('$idudesign_p');")->fetchAll(PDO::FETCH_ASSOC);
					
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
			}
);


$app->post(
		
		'/NewTemplate',function (Request $request, Response $response, array $args) {
		
			$allPostVars = (array)$request->getParsedBody();
			
			$name_p = $allPostVars['name_p'];
			$idmaterial_p = $allPostVars['idmaterial_p'];
			$contents_p = $allPostVars['contents_p'];
			$iduser_p = $allPostVars['iduser_p'];
			$idcampaign_p = $allPostVars['idcampaign_p'];
			$idtemplategroup_p = $allPostVars['idtemplategroup_p'];
			$group_id = 0;
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						$data = $cn->query("call uspGet_Material ('$idmaterial_p');")->fetchAll(PDO::FETCH_ASSOC);
						$is_multipage = $data[0]['multipage'];
				
						if ($is_multipage == '1') {

							if($idtemplategroup_p == '0') {
								$data = $cn->query("call uspIns_NewTemplateGroup ('$name_p','$iduser_p');")->fetchAll(PDO::FETCH_ASSOC);
								$group_id = $data[0]['id'];
							} else {
								$group_id = $idtemplategroup_p;
							}
							
						}

						$dataT = $cn->query("call uspIns_NewTemplate ('$name_p','$idmaterial_p','$contents_p','$iduser_p','$idcampaign_p');")->fetchAll(PDO::FETCH_ASSOC);
						$template_id = $dataT[0]['id'];

						if ($is_multipage == '1') {
							$data = $cn->query("call uspIns_NewTemplateTemplateGroup ($group_id, $template_id);")->fetchAll(PDO::FETCH_ASSOC);
						}

						$dataT[0]['template_group_id'] = $group_id;
						
						$response->getBody()->write( json_encode($dataT) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/NewUDesign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$name_p = $allPostVars['name_p'];
			$idmaterial_p = $allPostVars['idmaterial_p'];
			$contents_p = $allPostVars['contents_p'];
			$iduser_p = $allPostVars['iduser_p'];
			$idcampaign_p = $allPostVars['idcampaign_p'];
			$idtemplategroup_p = $allPostVars['idtemplategroup_p'];
			$idtemplate_p = $allPostVars['idtemplate_p'];
			$group_id = 0;
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";

				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						$data = $cn->query("call uspGet_Material ('$idmaterial_p');")->fetchAll(PDO::FETCH_ASSOC);
						$is_multipage = $data[0]['multipage'];
				
						if ($is_multipage == '1') {

							if($idtemplategroup_p == '0') {
								$data = $cn->query("call uspIns_NewDesignGroup ('$name_p','$iduser_p');")->fetchAll(PDO::FETCH_ASSOC);
								$group_id = $data[0]['id'];
							} else {
								$group_id = $idtemplategroup_p;
							}
							
						}

						$dataT = $cn->query("call uspIns_NewUDesign ('$name_p','$idmaterial_p','$contents_p','$iduser_p','$idcampaign_p', '$idtemplate_p');")->fetchAll(PDO::FETCH_ASSOC);
						$design_id = $dataT[0]['id'];

						if ($is_multipage == '1') {
							$data = $cn->query("call uspIns_NewDesignDesignGroup ($group_id, $design_id);")->fetchAll(PDO::FETCH_ASSOC);
						}

						$dataT[0]['design_group_id'] = $group_id;
						
						$response->getBody()->write( json_encode($dataT) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);


$app->post(
		
		'/UTemplate',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$idtemplate_p = $allPostVars['idtemplate_p'];
			$name_p = $allPostVars['name_p'];
			$contents_p = $allPostVars['contents_p'];
			
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_Template('$idtemplate_p','$name_p','$contents_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/UUDesign',function (Request $request, Response $response, array $args) {
		
			
			$allPostVars = (array)$request->getParsedBody();
			
			$idudesign_p = $allPostVars['idudesign_p'];
			$name_p = $allPostVars['name_p'];
			$contents_p = $allPostVars['contents_p'];
			
			
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				try
				{
						//CAMBIAR PROCEDIMIENTO
						$data = $cn->query("call uspUpd_UDesign('$idudesign_p','$name_p','$contents_p');")->fetchAll(PDO::FETCH_ASSOC);
						
						$response->getBody()->write( json_encode($data) ); 
				        return $response;
				}
				
				catch(PDOException $e) {
						echo $e->getMessage();
				}			
				
					
			}
);

$app->post(
		
		'/SaveNewThumbnail',function(Request $request, Response $response, array $args) {

			$path = '../images/thumbnails/';

			$allPostVars = (array)$request->getParsedBody();
			

			$idtemplate_p = $allPostVars['idtemplate_p'];
			
			$filename = $idtemplate_p . '_' . rand(1, 10000) . '.png';
			
			try {
				
				$img_base64 = str_replace(' ', '+', urldecode($allPostVars['img_data']));
				$data = explode(',', $img_base64);
				$img_bin = base64_decode($data[1]);

				$P = fopen($path.$filename, "wb");
				fwrite($P, $img_bin);
				fclose($P);


				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

				try
				{
					$data = $cn->query("call uspUpd_Thumbnail('$idtemplate_p','$filename');")->fetchAll(PDO::FETCH_ASSOC);
					
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(PDOException $e) {
					$errmsg = $e->getMessage();
				}	

			} catch(Exception $e) {
				$errmsg = $e->getMessage();
			}
			
			$data['error'] = $errmsg;
			$response->getBody()->write( json_encode($data) ); 
			return $response;
		}
);


$app->post(
		
		'/DesignSaveNewThumbnail',function (Request $request, Response $response, array $args) {

			$path = '../images/thumbnails/';

			$allPostVars = (array)$request->getParsedBody();
			

			$idudesign_p = $allPostVars['idudesign_p'];
			
			$filename = $idudesign_p . 'D_' . rand(1, 10000) . '.png';
			
			try {
				
				$img_base64 = str_replace(' ', '+', urldecode($allPostVars['img_data']));
				$data = explode(',', $img_base64);
				$img_bin = base64_decode($data[1]);

				$P = fopen($path.$filename, "wb");
				fwrite($P, $img_bin);
				fclose($P);


				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

				try
				{
					$data = $cn->query("call uspUpd_DesignThumbnail('$idudesign_p','$filename');")->fetchAll(PDO::FETCH_ASSOC);
					
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(PDOException $e) {
						echo $e->getMessage();
				}	

			} catch(Exception $e) {
				echo $e->getMessage();
			}
		
		}
);



$app->post(
		
		'/getSlidesThumbnails',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			

			$idtemplategroup_p = $allPostVars['idtemplategroup_p'];
			
			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			try {
				
				$data = $cn->query("call uspGet_Thumbnails($idtemplategroup_p);")->fetchAll(PDO::FETCH_ASSOC);
				$response->getBody()->write( json_encode($data) ); 
				return $response;
			
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
	
	}
);

$app->post(
		
		'/getDesignSlidesThumbnails',function (Request $request, Response $response, array $args) {

			$allPostVars = (array)$request->getParsedBody();
			

			$idudesigngroup_p = $allPostVars['idudesigngroup_p'];
			
			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			try {
				
				$data = $cn->query("call uspGet_DesignThumbnails($idudesigngroup_p);")->fetchAll(PDO::FETCH_ASSOC);
				$response->getBody()->write( json_encode($data) ); 
				return $response;
			
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
	
	}
);

$app->post(
		'/DSlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idtemplate_p 		= $allPostVars['idtemplate_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_TemplateGroup('$idtemplate_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspDel_Slide('$idtemplate_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$data = $cn->query("CALL uspUpd_FixSlidesOrder('$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);

$app->post(
		'/DDesignSlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idudesign_p 		= $allPostVars['idudesign_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_DesignGroup('$idudesign_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspDel_DesignSlide('$idudesign_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$data = $cn->query("CALL uspUpd_FixDesignSlidesOrder('$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);


$app->post(
		'/GSlides',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idtemplategroup_p 		= $allPostVars['idtemplategroup_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_TemplatesOfGroup('$idtemplategroup_p')")->fetchAll(PDO::FETCH_ASSOC);
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(Exception $e) {
					echo $e->getMessage();
				}			
		
			}

);


$app->post(
		'/GDesignSlides',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idudesigngroup_p 		= $allPostVars['idudesigngroup_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_DesignsOfGroup('$idudesigngroup_p')")->fetchAll(PDO::FETCH_ASSOC);
					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(Exception $e) {
					echo $e->getMessage();
				}			
		
			}

);

$app->post(
		'/DuplicateSlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idtemplate_p 		= $allPostVars['idtemplate_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_TemplateGroup('$idtemplate_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspDuplicate_Slide('$idtemplate_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$data = $cn->query("CALL uspUpd_FixSlidesOrderAfterDuplicate('$idtemplate_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				        return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);

$app->post(
		'/DuplicateDesignSlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idudesign_p 		= $allPostVars['idudesign_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_DesignGroup('$idudesign_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspDuplicate_DesignSlide('$idudesign_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$data = $cn->query("CALL uspUpd_FixDesignSlidesOrderAfterDuplicate('$idudesign_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				        return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);


$app->post(
		'/ISlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idtemplate_p 		= $allPostVars['idtemplate_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_TemplateGroup('$idtemplate_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspIns_Slide('$idtemplate_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$data = $cn->query("CALL uspUpd_FixSlidesOrderAfterDuplicate('$idtemplate_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				        return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);

$app->post(
		'/IDesignSlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idudesign_p 		= $allPostVars['idudesign_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_DesignGroup('$idudesign_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspIns_DesignSlide('$idudesign_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$data = $cn->query("CALL uspUpd_FixSlidesOrderAfterDuplicate('$idudesign_p', '$group_id')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				        return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);


$app->post(
		'/MSlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				
						
				$idtemplate_p 		= $allPostVars['idtemplate_p'];
				$direction_p 		= $allPostVars['direction_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_TemplateGroup('$idtemplate_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspUpd_SlideOrder('$idtemplate_p', '$group_id', '$direction_p')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);

$app->post(
		'/MDesignSlide',function (Request $request, Response $response, array $args) {
						
				$allPostVars = (array)$request->getParsedBody();
				

				$idudesign_p = $allPostVars['idudesign_p'];
				$direction_p = $allPostVars['direction_p'];
				
				global $dbms;
				global $host; 
				global $db;
				global $user;
				global $pass;
				$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";
				
				$cn=new PDO($dsn, $user, $pass);
				$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				try
				{					
					$data = $cn->query("CALL uspGet_DesignGroup('$idudesign_p')")->fetchAll(PDO::FETCH_ASSOC);
					$group_id = $data[0]['id'];

					$data = $cn->query("CALL uspUpd_DesignSlideOrder('$idudesign_p', '$group_id', '$direction_p')")->fetchAll(PDO::FETCH_ASSOC);

					$response->getBody()->write( json_encode($data) ); 
				    return $response;
				
				} catch(Exception $e) {
						echo $e->getMessage();
				}			
				
					
			}

);


$app->post(
	'/SaveImageToDisk',function (Request $request, Response $response, array $args) {
					
		$allPostVars = (array)$request->getParsedBody();

		$data = $allPostVars['img_data'];
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

		$name = rand(1000,100000) . '-' . rand(1000, 100000) . '.png';

		file_put_contents('../tmp/' . $name, $data);

		try {
			$response->getBody()->write( $name ); 
			return $response;
		
		} catch(Exception $e) {
				echo $e->getMessage();
		}			
			
	}

);


$app->post(
	'/ShareByEmail',function (Request $request, Response $response, array $args) {

		$allPostVars = (array)$request->getParsedBody();

		if ($allPostVars['x'] != 'enviaEmailWizad')
			die;

		$to = $allPostVars['to_p'];
		$link = $allPostVars['link_p'];

		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'From: Wizad <info@wizad.mx>';
		$headers[] = 'X-Mailer: PHP/' . phpversion();
		$headers[] = 'Reply-To: Wizad <info@wizad.mx>';

		$subject = 'Te comparto este diseno Wizad';

		$message = "Hola!, <br><br> 
		aqui te comparto este diseño que hice usando Wizad <br>
		para verlo solo tienes que abrir este enlace <a href='".$link."'>Diseño</a>"; 
		
		$success = mail($to, $subject, $message, implode("\r\n", $headers));
		$responseText = 'OK';

		if (!$success) {
			$responseText = error_get_last()['message'];
		}

		$response->getBody()->write( json_encode($responseText) ); 
		return $response;
	}
);


$app->post(
		
	'/GPermissionsCompany',function (Request $request, Response $response, array $args) {
	
		
		$allPostVars = (array)$request->getParsedBody();
		
		$idcompany_p = $allPostVars['idcompany_p'];

			global $dbms;
			global $host; 
			global $db;
			global $user;
			global $pass;
			$dsn = "$dbms:host=$host;dbname=$db;charset=utf8";


			$cn=new PDO($dsn, $user, $pass);
			$cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			try
			{
					//CAMBIAR PROCEDIMIENTO
					$data = $cn->query("call uspGet_Company_Permissions('$idcompany_p');")->fetchAll(PDO::FETCH_ASSOC);
					
					$response->getBody()->write( json_encode($data) ); 
					return $response;
			}
			
			catch(PDOException $e) {
					echo $e->getMessage();
			}			
			
				
		}
);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//inicializamos la aplicacion(API)
$app->run();