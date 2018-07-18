'use strict';

angular.module('newApp').controller('newUserCtrl', function ($scope, userService, generalService) {
	
	
	//  BEGIN - * UI - SCOPES *
	$scope.selectedUser = {};
	//  END	  - * UI - SCOPES *
	
	//  BEGIN - * APPLICATION USER LOGGED-IN * 
	
	userService.currentUser()
	.then(function(data) {
		if (data.id_user === undefined){
			$location.path('/');
		}else{
			$scope.currentUser = data;
		}			
	});
	
	//  END   - * APPLICATION USER LOGGED-IN * 
	
	var params = {
		"idcompany_p" : ""
	}
		
	params.idcompany_p = $scope.currentUser.id_company;
	
	generalService.getUsersCompany(params)
		.then(function(data) {
			$scope.allUsers = data;
			for(var i in $scope.allUsers){
				if($scope.currentUser.id_user === $scope.allUsers[i].id_user){
					$scope.allUsers.splice(i, 1);
				}
			}
	})
	
	$scope.closeAlert = function(){
		$scope.alertUserShow = false;
	}
	
	$scope.selectedUserForDelete = function(user){
		$scope.selectedUser = user;
	}

	$scope.selectedUserForEdit = function(user){
		$scope.e_id				= user.id_user;
		$scope.e_name 			= user.name;
		$scope.e_namenoemail 	= user.namenoemail;
		$scope.e_home_phone 	= user.home_phone;
		$scope.e_mobile_phone 	= user.mobile_phone;
	}

	$scope.saveEditUser = function() {

		var params = {
			"iduser_p"		:  "",
			"name_p"  		:  "",
			"namenoemail_p"	:  "",
			"homephone_p"	:  "",
			"mobilehome_p"	:  ""
		}

		params.iduser_p 		= $scope.e_id;
		params.name_p 			= $scope.e_name;
		params.namenoemail_p 	= $scope.e_namenoemail;
		params.homephone_p 		= $scope.e_home_phone;
		params.mobilehome_p 	= $scope.e_mobile_phone;

		generalService.saveUserGeneralData(params)
		.then(function(data) {
			if(data[0].returnMessage === 'SUCCESS'){
				
				$scope.messageUser 	 = "Datos actualizados exitosamente.";
				$scope.alertUserClass = "alert alert-success";
				$scope.alertUserShow  = true;


				var params = {
					"idcompany_p" : ""
				}
					
				params.idcompany_p = $scope.currentUser.id_company;
				
				generalService.getUsersCompany(params)
					.then(function(data) {
						$scope.allUsers = data;
						for(var i in $scope.allUsers){
							if($scope.currentUser.id_user === $scope.allUsers[i].id_user){
								$scope.allUsers.splice(i, 1);
							}
						}
				})
				

			}else{
				
				$scope.messageUser 	 = "Ocurrió un error en la aplicación, favor de contactar soporte.";
				$scope.alertUserClass = "alert alert-danger";
				$scope.alertUserShow  = true;
				
			}
		})

	}
	
	$scope.newUserStatus = function(userid, status){
		
		var params = {
			"status_p"  :  "",
			"user_p"	:  ""
		}
		
		params.status_p		= status;
		params.user_p		= userid;
		
		generalService.UUserStatus(params)
		.then(function(data) {
			if(data[0].returnMessage === 'SUCCESS'){
				
				$scope.messageUser 	 = "Datos actualizados exitosamente.";
				$scope.alertUserClass = "alert alert-success";
				$scope.alertUserShow  = true;
				
				
			} else if(data[0].returnMessage === 'ERROR: MAX USERS'){
				$("#myonoffswitch" + userid).click();
				$scope.messageUser 	 = "Error: El numero maximo de usuarios para su subscripcion ya ha sido alcanzado, inactive algun otro para activar este.";
				$scope.alertUserClass = "alert alert-danger";
				$scope.alertUserShow  = true;

			}else{
				
				$scope.messageUser 	 = "Ocurrió un error en la aplicación, favor de contactar soporte.";
				$scope.alertUserClass = "alert alert-danger";
				$scope.alertUserShow  = true;
				
			}
		})
	}
	
	$scope.eraseUser = function(){
		
		var params = {
			"user_p"	:  ""
		}
		
		params.user_p		= $scope.selectedUser.id_user;
		
		generalService.DUser(params)
		.then(function(data) {
			if(data[0].returnMessage === 'SUCCESS'){
				
				$scope.messageUser 	 = "Usuario eliminado exitosamente.";
				$scope.alertUserClass = "alert alert-success";
				$scope.alertUserShow  = true;
				
				var params = {
					"idcompany_p" : ""
				}
					
				params.idcompany_p = $scope.currentUser.id_company;
				
				generalService.getUsersCompany(params)
					.then(function(data) {
						$scope.allUsers = data;
				})
							
			}else{
				
				$scope.messageUser 	 = "Ocurrió un error en la aplicación, favor de contactar soporte.";
				$scope.alertUserClass = "alert alert-danger";
				$scope.alertUserShow  = true;
				
			}
		})
	}
	
	$scope.saveUser = function(){
		
		var params = {
			"name_p" : "",
			"password_p" : "",
			"company_p" : "",
			"homephone_p" : "",
			"mobilephone_p" : "",
			"username_p" : ""
		}
		
		var randomstring = Math.random().toString(36).slice(-8);
		
		params.name_p 			= $scope.name_p;
		params.password_p 		= randomstring;
		params.company_p 		= $scope.currentUser.id_company;
		params.homephone_p 		= $scope.homephone_p;
		params.mobilephone_p 	= $scope.mobilephone_p;
		params.username_p		= $scope.username_p;
		 
		generalService.NewUser(params)
		.then(function(data) {
			if(data[0].returnMessage === 'SUCCESS'){
				
				$scope.messageUser 	 = "Datos actualizados exitosamente.";
				$scope.alertUserClass = "alert alert-success";
				$scope.alertUserShow  = true;
				$scope.name_p = "";
				$scope.password_p = "";
				$scope.homephone_p = "";
				$scope.mobilephone_p = "";
				
				
				var params = {
					"idcompany_p" : ""
				}
					
				params.idcompany_p = $scope.currentUser.id_company;
				generalService.getUsersCompany(params)
					.then(function(data) {
						$scope.allUsers = data;
				})
							
			} else if(data[0].returnMessage ==='Ya existe'){
				$scope.messageUser 	 = "Error: El usuario ya existe, intente con otro nombre de usuario.";
				$scope.alertUserClass = "alert alert-danger";
				$scope.alertUserShow  = true;

			} else if(data[0].returnMessage === 'ERROR: MAX USERS'){
				$scope.messageUser 	 = "Error: El numero maximo de usuarios para su subscripcion ya ha sido alcanzado, inactive alguno para dar de alta nuevos.";
				$scope.alertUserClass = "alert alert-danger";
				$scope.alertUserShow  = true;

			} else{
				console.log(data);
				$scope.messageUser 	 = "Ocurrió un error en la aplicación, favor de contactar soporte.";
				$scope.alertUserClass = "alert alert-danger";
				$scope.alertUserShow  = true;
				
			}
		})
	}
	
	
});
