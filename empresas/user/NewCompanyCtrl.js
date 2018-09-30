'use strict';



/**

 * @ngdoc function

 * @name newappApp.controller:MainCtrl

 * @description

 * # MainCtrl

 * Controller of the newappApp

 */



angular.module('newApp')

  .controller('NewCompanyCtrl', function ($scope, campaignService, userService, applicationService, pluginsService, $log, objCampaign, generalService) {

		$scope.nameusernoemail = "";
		$scope.name 	  = "";
		$scope.desc 	  = "";
		$scope.noemp 	  = 0;
		$scope.industry   = "";
		$scope.webpage 	  = "";
		$scope.pc 		  = "";
		$scope.nameuser   = "";
		$scope.telhome 	  = "";
		$scope.telmobile  = "";
		$scope.optionCity    = 0;
		$scope.optionState   = 0;
		$scope.optionCountry = 0;
		
		$scope.message = "";
		$scope.alertClass = "";
		$scope.alertShow = false;
		
		$scope.nameUserNoEmailChange = function(value){
			$scope.nameusernoemail 	 = value;
			 
		}
		$scope.nameChange = function(value){
			$scope.name 	 = value;
			 
		}
		$scope.descChange = function(value){
			$scope.desc 	 = value;
			 
		}
		$scope.noempChange = function(value){
			$scope.noemp 	 = value;
			 
		}
		$scope.industryChange = function(value){
			$scope.industry  = value;
			 
		}
		$scope.webChange = function(value){
			$scope.webpage 	 = value;
			 
		}
		$scope.pcChange = function(value){
			$scope.pc 		 = value;
			 
		}
		$scope.nameUserChange = function(value){
			$scope.nameuser  = value;
			 
		}
		$scope.telhomeChange = function(value){
			$scope.telhome 	 = value;
			 
		}
		$scope.telmobileChange = function(value){
			$scope.telmobile = value;
			 
		}
		
		var params = "";
		campaignService.GCities(params)
		.then(function(data) {
			$scope.allCities = data;
		})

		campaignService.GStates()
		.then(function(data) {
			$scope.allStates = data;
		})

		campaignService.GCountries()
		.then(function(data) {
			$scope.allCountries = data;
		})
		
		generalService.GetAllSubscriptions(params)
		.then(function(data) {
			$scope.allSubscriptions = data;
		})
		
		
		$scope.test = function(){
			console.log();
		}
		
		$scope.saveData = function(){
			
			if(
				$scope.name 	  === "" ||
				$scope.desc 	  === "" ||
				$scope.industry   === "" ||
				$scope.webpage 	  === "" ||
				$scope.pc 		  === "" ||
				$scope.nameuser   === "" ||
				$scope.telhome 	  === "" ||
				$scope.telmobile  === "" ||
				$scope.optionCity === "" ||
				$scope.optionState === "" ||
				$scope.optionCountry === "" ||
				$scope.optionSubs === "" ||
				$scope.nameusernoemail === ""
				){
					$scope.message = "Favor de capturar todos los campos.";
					$scope.alertClass = "alert alert-warning";
					$scope.alertShow = true;
					return;
			}
			
			var queryParam = {
				"nameusernoemail" : "",
				"name_p" : "",
				"address_p" : "",
				"logo_p" : "",
				"city_p" : "",
				"state_p" : "",
				"country_p" : "",
				"nameuser_p" : "",
				"password_p" : "",
				"homephone_p" : "",
				"mobilephone_p" : "",
				"employees_p" : "",
				"industry_p" : "",
				"webpage_p" : "",
				"pc_p" : "",
				"subs_p" : "",
				"storage" : "",
				"freq" : ""
			}
			
			var randomstring = Math.random().toString(36).slice(-8);
			
			var subsId = $( "#selectsubs" ).val();
			var usersS = 1;
			var storageS = 0;
			for( var i in $scope.allSubscriptions ){
				if($scope.allSubscriptions[i].id_subs === subsId){
					//usersS = $scope.allSubscriptions[i].users;
					storageS = $scope.allSubscriptions[i].storage;
				}
			}
			queryParam.nameusernoemail	= $scope.nameusernoemail;
			queryParam.name_p 			= $scope.name;
			queryParam.address_p 		= $scope.desc;
			queryParam.logo_p 			= "";
			queryParam.city_p 			= $( "#selectcity" ).val();
			queryParam.state_p 			= $( "#selectstate" ).val();
			queryParam.country_p 		= $( "#selectcountry" ).val();
			queryParam.nameuser_p 		= $scope.nameuser;
			queryParam.password_p 		= randomstring;
			queryParam.homephone_p 		= $scope.telhome;
			queryParam.mobilephone_p 	= $scope.telmobile;
			queryParam.employees_p 		= usersS;
			queryParam.industry_p 		= $scope.industry;
			queryParam.webpage_p 		= $scope.webpage;
			queryParam.pc_p 			= $scope.pc;
			queryParam.subs_p 			= $( "#selectsubs" ).val();
			queryParam.storage 			= storageS;
			queryParam.freq 			= $( "#selectcontact" ).val();
			
			generalService.ICompanyNAdminUser(queryParam)
			.then(function(data) {
				
				if(data[0].returnMessage === "SUCCESS"){
					$scope.message = "Nueva compañía y usuario administrador creados.";
					$scope.alertClass = "alert alert-success";
					$scope.alertShow = true;
					$scope.name 	  = "";
					$scope.desc 	  = "";
					$scope.noemp 	  = 0;
					$scope.industry   = "";
					$scope.webpage 	  = "";
					$scope.pc 		  = "";
					$scope.nameuser   = "";
					$scope.telhome 	  = "";
					$scope.telmobile  = "";
					$scope.optionCity    = null;
					$scope.optionState   = null;
					$scope.optionCountry = null;
					$scope.nameusernoemail = "";
				}else{
					$scope.message = "Error al guardar los datos, favor de intentar más tarde.";
					$scope.alertClass = "alert alert-warning";
					$scope.alertShow = true;
				}
			})
		}
});