'use strict';


angular.module('newApp').controller('identityCtrl', function ($scope, campaignService, userService, applicationService, pluginsService, $log, objCampaign, generalService) {
		
		//var urlHostEmpresas = 'https://empresas.wizad.mx/';
		var urlHostEmpresas = 'https://localhost/wizad/empresas/';
		
		$scope.imagesArray 		= [];
		$scope.imagesArrayCopy	= [];
		
		$scope.fontArray 		= [];
		$scope.fontArrayCopy	= [];
		
		$scope.paletteArray 	= [];
		$scope.paletteArrayCopy	= [];
		
		$scope.textArray 		= [];
		$scope.textArrayCopy	= [];
		
		$scope.materialArray 		= [];	
		$scope.materialArrayCopy	= [];	
		
		$scope.newTexts			= [];
		$scope.deletedTexts		= [];
		
		$scope.newPalettes		= [];
		$scope.deletedPalettes	= [];
		
		$scope.newImages		= [];
		$scope.deletedImages	= [];
		
		$scope.newFonts			= [];
		$scope.deletedFonts		= [];
		
		$scope.allMaterials 	= [];
		$scope.newMaterials		= [];
		$scope.deletedMaterials	= [];

		$scope.CampaignSelected =  {};
		$scope.liStyle = "1px solid black";

		$scope.newText = function(){
			var newTextO    = { id_config: 0, text_config: '' };			
			newTextO.id_config = $scope.textArray.length+2150;		
			newTextO.text_config = "";			
			$scope.textArray.push(newTextO);			
			$scope.newTexts.push(newTextO);
		};
		
		$scope.eraseText = function(selectedText){	
			var existOnOriginal = $scope.textArrayCopy.indexOf(selectedText);
			if(existOnOriginal>-1){
				$scope.deletedTexts.push(selectedText);		
			}
			var index = $scope.textArray.indexOf(selectedText);
			$scope.textArray.splice(index, 1);
			index = $scope.newTexts.indexOf(selectedText);
			$scope.newTexts.splice(index, 1);			
		};
		
		$scope.newPalette = function(newColor){
			if(typeof newColor != 'undefined') {
			
				var newPaletteO = { id_palette: 0, color: '' };
				newPaletteO.id_palette = $scope.paletteArray.length+2150;
				newPaletteO.color = newColor;
				$scope.newPalettes.push(newPaletteO);
				$scope.paletteArray.push(newPaletteO);
			}
		};
		
		$scope.erasePalette = function(){	
			var existOnOriginal = $scope.paletteArrayCopy.indexOf($scope.pantoneDrop);
		
			if(existOnOriginal>-1){
				$scope.deletedPalettes.push($scope.pantoneDrop);		
			}			
			var index = $scope.paletteArray.indexOf($scope.pantoneDrop);
			$scope.paletteArray.splice(index, 1);
			index = $scope.newPalettes.indexOf($scope.pantoneDrop);
			$scope.newPalettes.splice(index, 1);
		};
		
		$scope.pantoneToRemove = function (pantone){
			$scope.pantoneDrop = pantone;
		};
		
		$scope.materialSelected = function (material){
			
			var addMaterial = { id_material : "", description : "", width : "", height : "", thumbnail : "" };
			
			addMaterial.id_material = material.id_material;
			addMaterial.description	= material.description;
			addMaterial.width		= material.width;
			addMaterial.height		= material.height;
			addMaterial.thumbnail	= material.thumbnail;
			
			
			if(material.selected === "1"){
							
				$scope.materialArray.push(addMaterial);
				$scope.newMaterials.push(addMaterial);
				
			}
			
			if(material.selected === "0"){
				
				for(var i in $scope.materialArrayCopy){
					if($scope.materialArrayCopy[i].id_material === material.id_material){
						$scope.deletedMaterials.push(addMaterial);
					}
				}
				
				for(var i in $scope.materialArray){
					if($scope.materialArray[i].id_material === material.id_material){
						$scope.materialArray.splice(i, 1);
					}
				}
				
				for(var i in $scope.newMaterials){
					if($scope.newMaterials[i].id_material === material.id_material){
						$scope.newMaterials.splice(i, 1);
					}
				}
				
		
				// var index = $scope.materialArray.indexOf(addMaterial);
				// $scope.materialArray.splice(index, 1);
				// index = $scope.newMaterials.indexOf(addMaterial);	
				// $scope.newMaterials.splice(index, 1);
				
			}
			
		}
		
		userService.currentUser()
		.then(function(data) {

			$scope.currentUser = data;			

			var params = {
				"idcompany_p" : ""
			}
			params.idcompany_p = $scope.currentUser.fk_company;
			
			generalService.getPaletteCompany(params)
			.then(function(data) {
				$scope.paletteArray = data;
				for(var i in $scope.paletteArray){
					$scope.paletteArrayCopy.push($scope.paletteArray[i]);
				}
			})

			generalService.getTextsCompany(params)
			.then(function(data) {
				$scope.textArray = data;
				for(var i in $scope.textArray){
					$scope.textArrayCopy.push($scope.textArray[i]);
				}
			})
			
			generalService.getPackCompany(params)
			.then(function(data) {				
				$scope.imagesArray = data;		
				for(var i in $scope.imagesArray){
					$scope.imagesArrayCopy.push($scope.imagesArray[i]);
					var mockFile = { name: $scope.imagesArray[i].image, size: 12345 };
					dzImages.options.addedfile.call(dzImages, mockFile);
					dzImages.options.thumbnail.call(dzImages, mockFile, urlHostEmpresas + "/uploads/" + $scope.imagesArray[i].image);
					dzImages.files.push(mockFile);
				}	
			})

			generalService.getFontsCompany(params)
			.then(function(data) {
				$scope.fontArray = data;	
				for(var i in $scope.fontArray){
					$scope.fontArrayCopy.push($scope.fontArray[i]);
					var mockFile = { name: $scope.fontArray[i].font, size: 12345 };
					dzFonts.options.addedfile.call(dzFonts, mockFile);
					dzFonts.files.push(mockFile);
				}					
			})
		})
		
		$scope.saveChanges = function(){
			
			var params = {
				"company_p" 		: "",
				"newTextArray" 		: "",
				"newPaletteArray" 	: "",
				"newMaterialArray" 	: "",
				"newPackArray" 		: "",
				"newFontArray" 		: "",
				"delTextArray" 		: "",
				"delPaletteArray" 	: "",
				"delMaterialArray" 	: "",
				"delPackArray" 		: "",
				"delFontArray" 		: ""
				
			}
			
			params.company_p		= $scope.currentUser.fk_company;
			params.newTextArray		= $scope.newTexts;
			params.newPaletteArray	= $scope.newPalettes;
			params.newMaterialArray	= $scope.newMaterials;
			params.newPackArray		= $scope.newImages;
			params.newFontArray		= $scope.newFonts;
			params.delTextArray		= $scope.deletedTexts;
			params.delPaletteArray	= $scope.deletedPalettes;
			params.delMaterialArray	= $scope.deletedMaterials;
			params.delPackArray		= $scope.deletedImages;
			params.delFontArray		= $scope.deletedFonts;
			
			generalService.SaveIdentityUpdate(params)
			.then(function(data) {
				console.log("Success");
				if(data[0].returnMessage === "SUCCESS"){
					$scope.message = "Identidad coorporativa guardada exitosamente.";
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
					$scope.optionCity = 0;
				}else{
					$scope.message = "Error al intentar guardar la identidad coorporativa, favor de intentar más tarde.";
					$scope.alertClass = "alert alert-warning";
					$scope.alertShow = true;
				}				
			})
			
		}
		
		/* Dropzone functions */
		var accepti = ".png,.jpg";
		var acceptf = ".otf, .ttf";
		
		var dzImages = new Dropzone('#dzImages', { addRemoveLinks: true , acceptedFiles: accepti });	
		var dzFonts  = new Dropzone('#dzFonts',  { addRemoveLinks: true , acceptedFiles: acceptf });		
		
		if($scope.currentUser.typenum == 1 || $scope.currentUser.typenum == 3) {
			dzImages.removeEventListeners();
			dzFonts.removeEventListeners();
		}
		
		
		dzImages.on("success", function(file) {
						
			var newPack 	= { id_cgpack: 0, image: '' };
			newPack.id_cgpack = $scope.imagesArray.length+2150;
			newPack.image 	= file.name;
			console.log(newPack);
			
			$scope.imagesArray.push(newPack);
			$scope.newImages.push(newPack);
			console.log($scope.newImages);
			
		});
		dzImages.on("removedfile", function(file) {
			console.log(file);
			for(var i in $scope.imagesArrayCopy){
				
				var newPack 	= { id_pack: 0, image: '' };
				newPack.id_pack	= $scope.imagesArrayCopy[i].id_pack;
				newPack.image		= $scope.imagesArrayCopy[i].image;
					
				if(file.name === $scope.imagesArrayCopy[i].image){
										
					$scope.deletedImages.push(newPack);
							
				}
			}				
			
			for(var i in $scope.newImages){
			
				var newPack 	= { id_cgpack: 0, image: '' };
				newPack.id_cgpack	= $scope.newImages[i].id_cgpack;
				newPack.image		= $scope.newImages[i].image;
				
				if(file.name === $scope.newImages[i].image){
					
					var index = $scope.newImages.indexOf(newPack);				
					$scope.newImages.splice(index, 1);
					
				}
			
			}
			
		});
		
		dzFonts.on("success", function(file) {
						
			var newFont 		= { id_cgfont: 0, font: '' };
			newFont.id_cgfont 	= $scope.imagesArray.length+2150;
			newFont.font 		= file.name;
			console.log(newFont);
			
			$scope.fontArray.push(newFont);
			$scope.newFonts.push(newFont);
			console.log($scope.newFonts);
			
		});
		dzFonts.on("removedfile", function(file) {
			
			for(var i in $scope.fontArrayCopy){
				
				var newFont 		= { id_cgfont: 0, font: '' };
				newFont.id_cgfont	= $scope.fontArrayCopy[i].id_cgfont;
				newFont.font		= $scope.fontArrayCopy[i].font;
					
				if(file.name === $scope.fontArrayCopy[i].font){
										
					$scope.deletedFonts.push(newFont);
							
				}
			}				
			
			for(var i in $scope.newFonts){
			
				var newFont 		= { id_cgfont: 0, font: '' };
				newFont.id_cgfont	= $scope.newFonts[i].id_cgfont;
				newFont.font		= $scope.newFonts[i].font;
				
				if(file.name === $scope.newFonts[i].font){
					
					var index = $scope.newFonts.indexOf(newFont);				
					$scope.newFonts.splice(index, 1);
					
				}
			
			}
		
			
		});
		/* Dropzone functions */
});
