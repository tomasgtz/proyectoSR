'use strict';



/**

 * @ngdoc function

 * @name newappApp.controller:MainCtrl

 * @description

 * # MainCtrl

 * Controller of the newappApp

 */




angular.module('newApp')

  .controller('seeCampaignCtrl', function ($scope, campaignService, userService, applicationService, pluginsService, $log, objCampaign, generalService) {

  		var urlHost = 'https://wizad.mx/';
		var urlHostEmpresas = 'https://empresas.wizad.mx/';

		//var urlHost = 'https://localhost/wizad/';
		//var urlHostEmpresas = 'https://localhost/wizad/empresas/';

		$scope.imagesArray 		= [];
		$scope.imagesArrayCopy	= [];

		$scope.imagesIdentidadArray 	= [];
		$scope.imagesIdentidadArrayCopy	= [];
		
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
		$scope.offline_materials= [];
		$scope.online_materials = [];
		$scope.onlineGrouped	= [];
		$scope.offlineGrouped	= [];
		$scope.offlineGrouped2  = [];

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
			console.log(existOnOriginal);
			console.log($scope.pantoneDrop);
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

		Array.prototype.groupBy = function(prop) {
		  return this.reduce(function(groups, item) {
			const val = item[prop]
			groups[val] = groups[val] || []
			groups[val].push(item)
			return groups
		  }, {})
		}
		
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
				
				// console.log($scope.materialArray);
				// console.log($scope.newMaterials);		
				// var index = $scope.materialArray.indexOf(addMaterial);
				// console.log(index);				
				// $scope.materialArray.splice(index, 1);
				// index = $scope.newMaterials.indexOf(addMaterial);	
				// console.log(index);						
				// $scope.newMaterials.splice(index, 1);
				
			}
			
		}

		/* Dropzone functions */
		var accepti = ".png,.jpg";
		var acceptf = ".ttf,.otf";
		
		var dzImages = new Dropzone('#dzImages_c', { addRemoveLinks: true , acceptedFiles: accepti });	
		var dzFonts  = new Dropzone('#dzFonts_c',  { addRemoveLinks: true , acceptedFiles: acceptf });		
		
		var dzImagesIdentidad = new Dropzone('#dzImagesIdentidadSeeC_c', { addRemoveLinks: true , acceptedFiles: accepti, dictRemoveFile: 'Agregar a campaña' });

		dzImages.on("success", function(file) {
						
			var newPack 	= { id_cgpack: 0, image: '' };
			newPack.id_cgpack = $scope.imagesArray.length+2150;
			newPack.image 	= file.name;
			
			$scope.imagesArray.push(newPack);
			$scope.newImages.push(newPack);
			
		});
		dzImages.on("removedfile", function(file) {
			
			for(var i in $scope.imagesArrayCopy){
				
				var newPack 	= { id_cgpack: 0, image: '' };
				newPack.id_cgpack	= $scope.imagesArrayCopy[i].id_cgpack;
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


		dzImagesIdentidad.on("removedfile", function(file) {
			var newPack 	= { id_cgpack: 0, image: '' };
			newPack.id_cgpack = $scope.imagesArray.length+2150;
			newPack.image 	= file.name;
			
			$scope.imagesArray.push(newPack);
			$scope.newImages.push(newPack);

			$scope.imagesArrayCopy.push(newPack);
			var mockFile = { name: newPack.image, size: 12345 };
			dzImages.options.addedfile.call(dzImages, mockFile);
			dzImages.options.thumbnail.call(dzImages, mockFile, urlHostEmpresas + 'uploads/' + newPack.image);
			dzImages.files.push(mockFile);

			
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
			console.log($scope.deletedFonts);
			console.log($scope.newFonts);
			
		});
		/* Dropzone functions */
		
		objCampaign.getCampaign()
		.then(function(data) {

			$scope.CampaignSelected = data;
			//console.log("asd tom5 [" + data.download + "] loading campaign info");	
			
			if(data.download == '1') {
				$scope.CampaignSelected.download = true;
			} else {
			
				$scope.CampaignSelected.download = false;
			}
			
			var params = {
				"campaign_p" : ""
			}
			params.campaign_p = $scope.CampaignSelected.id_campaign;
			
			campaignService.GPaletteCampaign(params)
			.then(function(data) {
				$scope.paletteArray = data;
				for(var i in $scope.paletteArray){
					$scope.paletteArrayCopy.push($scope.paletteArray[i]);
				}
			})

			campaignService.GTextsCampaign(params)
			.then(function(data) {
				$scope.textArray = data;
				for(var i in $scope.textArray){
					$scope.textArrayCopy.push($scope.textArray[i]);
				}
			})
			
			campaignService.GMaterialsCampaign(params)
			.then(function(data) {
				$scope.materialArray = data;
				for(var i in $scope.materialArray){
					$scope.materialArrayCopy.push($scope.materialArray[i]);
				}
				
				campaignService.GMaterials(params)
				.then(function(data) {
					$scope.allMaterials = data;
					
					for(var i in $scope.allMaterials){
						
						for(var j in $scope.materialArray){
	
							if($scope.allMaterials[i].id_material === $scope.materialArray[j].id_material){
								$scope.allMaterials[i].selected = "1";
							}
						}

						if( $scope.allMaterials[i].offline == '1' ) {
							
							var Obj = new Object();
							Obj.type = $scope.allMaterials[i].type;
							Obj.items = $scope.allMaterials[i];

							$scope.offline_materials.push(Obj);

						} else {

							var Obj = new Object();
							Obj.type = $scope.allMaterials[i].type;
							Obj.items = $scope.allMaterials[i];

							$scope.online_materials.push(Obj);
						}
					}

					$scope.onlineGrouped  = $scope.online_materials.groupBy('type');
					$scope.offlineGrouped = $scope.offline_materials.groupBy('type');
					
					for (var mat in $scope.offlineGrouped ) {
						
						var Obj = new Object();
							Obj.type = mat;
						
						var tempArray  = [];
						var tempArrayG = [];
							
						for (var k in $scope.offlineGrouped[mat] ) {

							if( $scope.offlineGrouped[mat][k].items != undefined ) {
								var Obj2 = new Object();
								Obj2.name = $scope.offlineGrouped[mat][k].items.type;
								Obj2.thumb = $scope.offlineGrouped[mat][k].items.thumbnail;
								Obj.thumb = $scope.offlineGrouped[mat][k].items.thumbnail;
								Obj2.items = $scope.offlineGrouped[mat][k].items;
							
								tempArray.push(Obj2);
							}
						}
						
						tempArrayG = tempArray.groupBy('thumb');
						Obj.items = tempArrayG;
						$scope.offlineGrouped2.push(Obj);
					}

				})
			})	
			
			campaignService.GPackCampaign(params)
			.then(function(data) {				
				$scope.imagesArray = data;
			
				for(var i in $scope.imagesArray){
					
					if(typeof $scope.imagesArray[i].image != 'undefined') {
						$scope.imagesArrayCopy.push($scope.imagesArray[i]);
						var mockFile = { name: $scope.imagesArray[i].image, size: 12345 };
						dzImages.options.addedfile.call(dzImages, mockFile);
						
						dzImages.options.thumbnail.call(dzImages, mockFile, urlHostEmpresas + 'uploads/' + $scope.imagesArray[i].image);
						dzImages.files.push(mockFile);
					}
				}	
			})

			generalService.getPackCompany({idcompany_p:$scope.CampaignSelected.fk_company})
			.then(function(data) {				
				$scope.imagesIdentidadArray = data;	
				
				for(var i in $scope.imagesIdentidadArray){
					if(typeof $scope.imagesIdentidadArray[i].image != 'undefined') {
						$scope.imagesIdentidadArrayCopy.push($scope.imagesIdentidadArray[i]);
						var mockFile = { name: $scope.imagesIdentidadArray[i].image, size: 12345 };
						dzImagesIdentidad.options.addedfile.call(dzImagesIdentidad, mockFile);
						dzImagesIdentidad.options.thumbnail.call(dzImagesIdentidad, mockFile, urlHostEmpresas + "/uploads/" + $scope.imagesIdentidadArray[i].image);
						dzImagesIdentidad.files.push(mockFile);
					}
				}	
			})
			
			campaignService.GFontsCampaign(params)
			.then(function(data) {
				$scope.fontArray = data;
				
				for(var i in $scope.fontArray){
					if(typeof $scope.fontArray[i].font != 'undefined') {
						$scope.fontArrayCopy.push($scope.fontArray[i]);
						var mockFile = { name: $scope.fontArray[i].font, size: 12345 };
						dzFonts.options.addedfile.call(dzFonts, mockFile);
						dzFonts.files.push(mockFile);
					}
				}					
			})
		})
		
		$scope.saveChanges = function(){
			
			var params = {
				"campaign_p" 		: "",
				"newTextArray" 		: "",
				"newPaletteArray" 	: "",
				"newMaterialArray" 	: "",
				"newPackArray" 		: "",
				"newFontArray" 		: "",
				"delTextArray" 		: "",
				"delPaletteArray" 	: "",
				"delMaterialArray" 	: "",
				"delPackArray" 		: "",
				"delFontArray" 		: "",
				"autorization"		: "",
				"description"		: "",
				"name"				: ""
			}

			params.campaign_p		= $scope.CampaignSelected.id_campaign;
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
			params.name				= $scope.CampaignSelected.campaign_name;
			params.description		= $scope.CampaignSelected.description;
			params.userupdate		= $scope.currentUser.id_user
			
			if( $scope.CampaignSelected.download	) {
				params.autorization = 1;
			} else {
				params.autorization = 0;
			}


			for(var i in $scope.allMaterials){
				for(var j in $scope.materialArray){
					if($scope.allMaterials[i].id_material === $scope.materialArray[j].id_material){
						$scope.allMaterials[i].selected = "1";
					}
				}
			}


			if($scope.paletteArray.length == 0 && (typeof $scope.newPalettes.length == 'undefined' || $scope.newPalettes.length == 0 || $scope.newPalettes.length == 1)) {
				$scope.message 	  = "Favor de agregar al menos dos colores en la Palette";
				$scope.alertClass = "alert alert-danger";
				$scope.alertShow  = true;
				
				return;
			}

			if(dzFonts.files.length == 0 && (typeof $scope.newFonts.length == 'undefined' || $scope.newFonts.length == 0)) {
				$scope.message 	  = "Favor de agregar al menos una fuente";
				$scope.alertClass = "alert alert-danger";
				$scope.alertShow  = true;
				
				return;
			}

			if($scope.materialArray.length == 0 && (typeof $scope.newMaterials.length == 'undefined' || $scope.newMaterials.length == 0)) {
				$scope.message 	  = "Favor de agregar al menos un material";
				$scope.alertClass = "alert alert-danger";
				$scope.alertShow  = true;
				
				return;
			}
			
			campaignService.SaveCampaignUpdate(params)
			.then(function(data) {
				console.log("Success");
				if(data[0].returnMessage === "SUCCESS"){
					$scope.message = "Se guardo la campaña exitosamente.";
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
					$scope.message = "Error al guardar la campaña, favor de intentar más tarde.";
					$scope.alertClass = "alert alert-warning";
					$scope.alertShow = true;
				}				
			})
			
		}
		
		
  });

