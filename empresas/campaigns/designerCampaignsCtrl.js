'use strict';

/**
 * @ngdoc function
 * @name newappApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the newappApp
 */

/*
angular.module('newApp')
  .controller('designerCampaignsCtrl', function ($scope, campaignService, userService, applicationService, pluginsService, $location, objCampaign) {
		
		
	setTimeout(function(){
            inputSelect();
            handleiCheck();
            timepicker();
            datepicker();
            bDatepicker();
            multiDatesPicker();
        },200);

	$scope.campaignsVisible = true;
	$scope.viewCampaignsList = function(){
		$scope.campaignsVisible = true;
	}
	$scope.viewNewCampaigns = function(){
		$scope.campaignsVisible = false;
	}

		
	//  BEGIN - * UI - SCOPES * 
	
		$scope.newImagesArray		= [];
		$scope.newTextsArray 		= [];
		$scope.newPaletteArray 		= [];
		$scope.textConfig 			= [];
		$scope.paletteConfig 		= [];
		$scope.filesUploaded		= [];
		$scope.fontsUploaded		= [];
		$scope.description			= "";
		$scope.title				= "";
		$scope.autorization			= false;
		
		$scope.alertCampaignShow  	= false;
		$scope.enableStepTwo 		= false;
		$scope.enableThirdStep 		= false;
		$scope.enableFourthStep  	= false;
		
		
	//  END - * UI - SCOPES * 
		
	//  BEGIN - * APPLICATION USER LOGGED-IN * 
	
		userService.currentUser()
		.then(function(data) {
			if (data.id_user === undefined){
				$location.path('/');
			}else{
				$scope.currentUser = data;
			}			
		});
	
	//  END - * APPLICATION USER LOGGED-IN * 
		
	//  BEGIN - * LOADING DATA *
		
		var params = {
			"idcompany_p" : ""
		}
		
		params.idcompany_p 		= $scope.currentUser.id_company;
		
		campaignService.myCampaigns(params)
		.then(function(data) {
			$scope.allCampaigns = data;
		})
		
		campaignService.GMaterials(params)
		.then(function(data) {
			$scope.allMaterials = data;
		})
		
	//  END - * LOADING DATA *	
		
	//  BEGIN - * NEW CAMPAIGN CODE *
	
		// 	Variables 	
		
		$scope.wizardSteps = 1;
		
		// 	Functions 	
		$scope.firstStep = function(){
			$scope.wizardSteps = 1;
		}
		$scope.secondStep = function(){
			$scope.wizardSteps = 2;
		}
		$scope.thirdStep = function(){
			$scope.wizardSteps = 3;
		}
		$scope.fourthStep = function(){
			$scope.wizardSteps = 4;
		}
		$scope.fifthStep = function(){
			$scope.wizardSteps = 5;
		}
		$scope.sixthStep = function(){
			$scope.wizardSteps = 6;
		}
		
		$scope.newText = function(){
			
			var newTextO    = { id_config: 0, text_config: '' };
			newTextO.id_config = $scope.textConfig.length+1;
			newTextO.text_config = "";
			$scope.textConfig.push(newTextO);
			$scope.newTextsArray.push(newTextO);
		}
		
		$scope.newPalette = function(newColor){
			
			if(typeof newColor != 'undefined') {
			
				var newPaletteO = { id_palette: 0, color: '' };
				newPaletteO.id_palette = $scope.paletteConfig.length+1;
				newPaletteO.color = newColor;
				$scope.paletteConfig.push(newPaletteO);
				$scope.newPaletteArray.push(newPaletteO);
			}
		}
		
		
		$scope.removeText = function (rtext){
			$scope.textConfig.splice( $scope.textConfig.indexOf(rtext), 1 );
			$scope.newTextsArray.splice( $scope.newTextsArray.indexOf(rtext), 1 );
		}
		
		$scope.pantoneToRemove = function (pantone){
			$scope.pantoneDrop = pantone;
		}
		
		$scope.removePantone = function (){
			$scope.paletteConfig.splice( $scope.paletteConfig.indexOf($scope.pantoneDrop), 1 );
			$scope.newPaletteArray.splice( $scope.newPaletteArray.indexOf($scope.pantoneDrop), 1 );
		}
		
		$scope.descriptionChange = function(desc){
			$scope.description = desc;
		}
		$scope.titleChange = function(title){
			$scope.title = title;
		}
		
		$scope.autorizationChange = function(autorization_1) {
			$scope.autorization = autorization_1;
		}
		
		
		//		Services
		
		$scope.createCampaign = function(){
			var paramss = {
				"description_c" : "",
				"title_c" : "",
				"autorization_c" : "",
				"company_p" : ""
			}
			
			paramss.company_p 		= $scope.currentUser.id_company;
			paramss.title_c 		= $scope.title;
			
			if($scope.autorization){
				paramss.autorization_c 	= 1;
			}else{
				paramss.autorization_c 	= 0;
			}
			paramss.description_c 	= $scope.description;
			
			campaignService.SaveNewCampaign(paramss)
			.then(function(data) {
				if(data[0].returnMessage){
					$scope.newcampaignid = data[0].returnMessage;
					$scope.wizardSteps = 2;
				}
				else
				{
					$scope.messageCampaign	 	= "Ocurrió un error en la creación de la campaña, favor de contactar a soporte.";
					$scope.alertCampaignClass 	= "alert alert-danger";
					$scope.alertCampaignShow  	= true;
				}
			})
		}
		
		$scope.uploadTexts = function(){
			var paramss = {
				"campaignid" : "",
				"text_config" : "",
			}
			
			paramss.campaignid 		= $scope.newcampaignid;
			paramss.textconfig_p 	= $scope.newTextsArray;
			
			
			campaignService.saveTextConfigs(paramss)
			.then(function(data) {
				if(data[0].returnMessage === 'SUCCESS'){
					$scope.wizardSteps = 3;
				}	
				else
				{
					$scope.messageText	 	= "Ocurrió un error en el guardado, favor de contactar a soporte.";
					$scope.alertTextClass 	= "alert alert-danger";
					$scope.alertTextShow  	= true;
				}
			})
		}
		
		$scope.uploadImage = function (p){
			var paramss = {
				"campaignid" : "",
				"baseimage" : "",
				"imagename" : ""
			}
			
			paramss.campaignid 		= $scope.newcampaignid;
			
			paramss.baseimage 		= p.preview;
			paramss.imagename 		= "wizadImages/" + p.name;
			
			
			
			
			campaignService.savePack(paramss)
			.then(function(data) {
				if(data[0].returnMessage === 'SUCCESS'){
					$scope.enableFourthStep  = true;
				}	
				else
				{
					$scope.ImageText	 	= "Ocurrió un error en el guardado, favor de contactar a soporte.";
					$scope.alertImageClass 	= "alert alert-danger";
					$scope.alertImageShow  	= true;
				}
			})
		}
		
		$scope.showDescription = function(campaign){
			$scope.descriptionOnModal = campaign.description;
		}
		
		$scope.sendData = function(){
			var paramss = {
				"description_c" : "",
				"title_c" : "",
				"autorization_c" : "",
				"company_p" : ""
			}
			
			var pconfig = {
				"campaignid" : "",
				"textconfig_p" : "",
				"palette_p" : "",
				"material_p" : "",
				"pack_p" : "",
				"font_p" : ""
			}
			
			paramss.company_p 		= $scope.currentUser.id_company;
			paramss.title_c 		= $scope.title;
			if($scope.autorization){
				paramss.autorization_c 	= 1;
			}else{
				paramss.autorization_c 	= 0;
			}
			paramss.description_c 	= $scope.description;
			
			campaignService.SaveNewCampaign(paramss)
			.then(function(data) {
				if(data[0].returnMessage){
					// $scope.fontsUploaded
					// $scope.filesUploaded
					// $scope.newPaletteArray
					// $scope.newTextsArray
					//ok $scope.description
					//ok $scope.title
					//ok $scope.autorization
					// $scope.allMaterials
					pconfig.campaignid 			= data[0].returnMessage;;
					pconfig.textconfig_p 		= $scope.newTextsArray;
					pconfig.palette_p 			= $scope.newPaletteArray;
					pconfig.pack_p 				= $scope.filesUploaded;
					pconfig.font_p 				= $scope.fontsUploaded;
					$scope.selectedMaterials 	= [];
					for( var i in $scope.allMaterials){
						if($scope.allMaterials[i].selected != "0"){
							$scope.selectedMaterials.push($scope.allMaterials[i]);
						}
					}
					pconfig.material_p 			= $scope.selectedMaterials;
					campaignService.SaveCampaignConfig(pconfig)
					.then(function(data) {
						if(data[0].returnMessage === 'SUCCESS'){
							$location.path( '/mycampaigns' );
						}
					})
					// $scope.messageColor	 = "Datos actualizados exitosamente.";
					// $scope.alertColorClass = "alert alert-success";
					// $scope.alertColorShow  = true;
					// $scope.newPaletteArray =[];
				}
				else{
					$scope.messageColor 	 = "Ocurrió un error en la aplicación, intenté de nuevo más tarde.";
					$scope.alertColorClass = "alert alert-danger";
					$scope.alertColorShow  = true;
				}
			})
			
		}
		
		$scope.saveCampaign = function(){
			var test1  = $scope.newImagesArray		;
			var test2  = $scope.newTextsArray 		;
			var test3  = $scope.newPaletteArray 	;
			var test4  = $scope.textConfig 			;
			var test5  = $scope.paletteConfig 		;
			var test6  = $scope.filesUploaded		;
			var test7  = $scope.fontsUploaded		;
			var test8  = $scope.description			;
			var test9  = $scope.title				;
			var test10 = $scope.autorization		;
		}
		
		$scope.goToMaterials = function(campaign){
		
			objCampaign.setCampaign(campaign);	
			$location.path( '/campaign-materials' );
		}
		
		$scope.reload = function(){
			campaignService.myCampaigns(params)
			.then(function(data) {
				$scope.allCampaigns = data;
				$scope.showflag = true;
				setTimeout(function () 
				{
					$scope.$apply(function()
					{
						$scope.showflag = false;
					});
				}, 3000);
			})
		}
	//  END - * NEW CAMPAIGN CODE *
		
  });
*/



'use strict';


angular.module('newApp')
  .controller('designerCampaignsCtrl', function ($scope, campaignService, userService, applicationService, pluginsService, $location, objCampaign, generalService) {
	
	var urlHostEmpresas = __env.urlHostEmpresas;

	$scope.images = [];
	$scope.showCaption = true;
	$scope.header = "Image Gallery";
	$scope.current = 0;
	$scope.page = 0;
	$scope.total = 0;
	$scope.item_per_page = 10;
	$scope.allCampaigns = [];

	$scope.addImage = function() {
      var image = {"src":$scope.imageSrc};
      $scope.images.push(image);
      $scope.imageSrc ="";
	}

	$scope.getIndex = function(img) {
		$scope.current = $scope.images.indexOf(img);
		
		for (var i in $scope.allCampaigns) {
			if($scope.allCampaigns[i].id_campaign == img.id_campaign) {
				objCampaign.setCampaign($scope.allCampaigns[i]);
				generalService.openTemplate({idtemplate_p: img.id_template, idmaterial_p: img.id_material });
				return;
			}
		}

	}
	
	$scope.nextImage = function() {
		$scope.current += 1; 
		if ($scope.current===$scope.images.length)
			$scope.current = 0;
	}

	$scope.prev = function() {
		
		if($scope.page >= 1) {
			$scope.page--;
			$scope.images = [];
			$scope.getThumbs();
			$scope.getThumbsCount();
		}
	}

	$scope.next = function() {
		$scope.page++;
		$scope.images = [];
		$scope.getThumbs();
		$scope.getThumbsCount();
	}

	

	$scope.getThumbs = function() {
		return generalService.GTemplatesThumbs({iduser_p: $scope.currentUser.id_user, page_p: $scope.page})
			.then(function(data) {				
				$scope.designsList = data;	
				
				for(var i in $scope.designsList){

					if(typeof $scope.designsList[i].id != 'undefined') {

						var pic = { 
							id_template: $scope.designsList[i].id,
							id_campaign: $scope.designsList[i].campaign_id,
							id_material: $scope.designsList[i].fk_material_id,
							src: urlHostEmpresas + "images/thumbnails/" + $scope.designsList[i].thumbnail,
							caption: $scope.designsList[i].name,
							caption2: $scope.designsList[i].campaign,
							material_description: $scope.designsList[i].material_description
							
						};

						$scope.images.push(pic);
					}

				}	
			});
	
	}
	
	$scope.getThumbsCount = function() {
		generalService.GTemplatesThumbsCount({iduser_p: $scope.currentUser.id_user})
			.then(function(data) {		
				$scope.total = data[0].c;
				
			});
	
	}

	setTimeout( function() { $scope.getThumbs(); }, 1000);
	
	$scope.getThumbsCount();

	var params = {
			"idcompany_p" : ""
		}
		
	params.idcompany_p 		= $scope.currentUser.id_company;

	campaignService.myCampaigns(params)
		.then(function(data) {
			$scope.allCampaigns = data;
			
		})
	
	$scope.deleteTemplate = function(template_id) {
		
		let text = "Deseas borrar esta plantilla\nPresiona OK para confirmar";
		if (confirm(text) == true) {
			
			generalService.DTemplate({idtemplate_p: template_id})
			.then(function(data) {
				$scope.images = [];

				$scope.getThumbs();
				$scope.getThumbsCount();
			});

		} 
	}

	$scope.copyTemplate = function(template_id) {

		generalService.CopyTemplate({idtemplate_p: template_id})
			.then(function(data) {
				$scope.images = [];

				$scope.getThumbs();
				$scope.getThumbsCount();
			});

	}

  });
