'use strict';

/**
 * @ngdoc function
 * @name newappApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the newappApp
 */

angular.module('newApp')
  .controller('myCampaignsCtrl', function ($scope, campaignService, userService, applicationService, pluginsService, $location, objCampaign, generalService) {

      $scope.$on('$viewContentLoaded', function () {

          function fnFormatDetails(oTable, nTr) {
              var aData = oTable.fnGetData(nTr);
              var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
              sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
              sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
              sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
              sOut += '</table>';
              return sOut;
          }

          /*  Insert a 'details' column to the table  */
          var nCloneTh = document.createElement('th');
          var nCloneTd = document.createElement('td');
          nCloneTd.innerHTML = '<i class="fa fa-plus-square-o"></i>';
          nCloneTd.className = "center";

          $('#table2 thead tr').each(function () {
              this.insertBefore(nCloneTh, this.childNodes[0]);
          });

          $('#table2 tbody tr').each(function () {
              this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
          });

          /*  Initialse DataTables, with no sorting on the 'details' column  */
          var oTable = $('#table2').dataTable({
              destroy: true,
              "aoColumnDefs": [{
                  "bSortable": false,
                  "aTargets": [0]
              }],
              "aaSorting": [
                  [1, 'asc']
              ]
          });

          /*  Add event listener for opening and closing details  */
          $(document).on('click', '#table2 tbody td i', function () {
              var nTr = $(this).parents('tr')[0];
              if (oTable.fnIsOpen(nTr)) {
                  /* This row is already open - close it */
                  $(this).removeClass().addClass('fa fa-plus-square-o');
                  oTable.fnClose(nTr);
              } else {
                  /* Open this row */
                  $(this).removeClass().addClass('fa fa-minus-square-o');
                  oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
              }
          });
      });

      $scope.$on('$destroy', function () {
          $('table').each(function () {
              if ($.fn.dataTable.isDataTable($(this))) {
                  $(this).dataTable({
                      "bDestroy": true
                  }).fnDestroy();
              }
          });
      });
		
	setTimeout(function(){
            inputSelect();
            handleiCheck();
            timepicker();
            datepicker();
            bDatepicker();
            multiDatesPicker();
        },200);

	$scope.campaignsVisible = true;
	$scope.descriptionOnModal = "";
	$scope.sortType     = ''; // set the default sort type
	$scope.sortReverse  = false;  // set the default sort order
	$scope.showflag = false;
	$scope.offline_materials= [];
	$scope.online_materials = [];
	$scope.onlineGrouped	= [];
	$scope.offlineGrouped	= [];
	$scope.offlineGrouped2  = [];

	Array.prototype.groupBy = function(prop) {
	  return this.reduce(function(groups, item) {
		const val = item[prop]
		groups[val] = groups[val] || []
		groups[val].push(item)
		return groups
	  }, {})
	}
	
	//ERASING CAMPAIGN
	$scope.selectedCampaignForDelete = function (campaign){
		$scope.selectDeletingCampaign = campaign;
	}
	
	$scope.eraseCampaign = function(){
		
		var params = {
			"campaign_p" : ""
		}
		
		params.campaign_p = $scope.selectDeletingCampaign.id_campaign;
		
		campaignService.DCampaign(params)
		.then(function(data) {
			if(data[0].returnMessage === 'SUCCESS'){
				
				$scope.CreateText 	 = "Campaña eliminada exitosamente.";
				$scope.alertCreateClass = "alert alert-success";
				$scope.alertCreateShow  = true;
				
				var params2 = {
					"idcompany_p" : ""
				}
				
				params2.idcompany_p 		= $scope.currentUser.id_company;
				
				campaignService.myCampaigns(params2)
				.then(function(data) {
					$scope.allCampaigns = data;
				})	
				
							
			}else{
				
				$scope.CreateText 	 = "Ocurrió un error en la aplicación, favor de contactar soporte.";
				$scope.alertCreateClass = "alert alert-danger";
				$scope.alertCreateShow  = true;
				
			}
		})
	}
	
	//ERASING CAMPAIGN
	
	$scope.closeAlert = function(){
		$scope.alertCreateShow = false;
	}
	$scope.viewCampaignsList = function(){
		$scope.campaignsVisible = true;
	}
	$scope.viewNewCampaigns = function(){
		$scope.campaignsVisible = false;
	}
	$scope.showDescription = function(campaign){
		$scope.descriptionOnModal = campaign.description;
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
	
	var accepti = ".png,.jpg";
	var acceptf = ".ttf,.otf";
	
	var myDropzone = new Dropzone("#dropzoneImages", { addRemoveLinks: true , acceptedFiles: accepti });
	var myDropzone2 = new Dropzone("#dropzoneFonts", { addRemoveLinks: true , acceptedFiles: acceptf });

	var dzImagesIdentidad = new Dropzone('#dzImagesIdentidad', { addRemoveLinks: true , acceptedFiles: accepti, dictRemoveFile: 'Agregar a campaña' });
	var dzFontsIdentidad = new Dropzone('#dzFontsIdentidad', { addRemoveLinks: true , acceptedFiles: acceptf, dictRemoveFile: 'Agregar a campaña' });
	
	var urlHostEmpresas = __env.urlHostEmpresas;
		
	//  BEGIN - * UI - SCOPES * 
	
		$scope.selectedMaterials 	= [];
		$scope.newImagesArray		= [];
		$scope.newTextsArray 		= [];
		$scope.newPaletteArray 		= [];
		$scope.paletteArray 		= [];
		$scope.textConfig 			= [];
		$scope.paletteConfig 		= [];
		$scope.filesUploaded		= [];
		$scope.fontsUploaded		= [];
		$scope.description			= "";
		$scope.segment			    = "";
		$scope.title				= "";
		$scope.searchValue			= "";
		$scope.autorization			= true;
		
		$scope.alertCampaignShow  	= false;
		$scope.enableStepTwo 		= false;
		$scope.enableThirdStep 		= false;
		$scope.enableFourthStep  	= false;
		
		$scope.alertCreateClass  	= "";
		$scope.alertCreateShow  	= false;
		$scope.CreateText  			= "";
		$scope.imagesIdentidadArray 	= [];
		$scope.hideDzImagesIdentidad = false;
		$scope.fontsIdentidadArray 		= [];
		$scope.hideDzFontsIdentidad		= [];
		
		
		
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
		
		campaignService.GCities(params)
		.then(function(data) {
			$scope.allCities = data;
		})
		
		campaignService.GAges(params)
		.then(function(data) {
			$scope.allAges = data;
		})


		generalService.getPackCompany({idcompany_p:$scope.currentUser.id_company})
		.then(function(data) {		
			
			$scope.imagesIdentidadArray = data;	
			
			for(var i in $scope.imagesIdentidadArray){
				
				if ($scope.imagesIdentidadArray[i].image != undefined)
				{
					var mockFile = { name: $scope.imagesIdentidadArray[i].image, size: 12345 };
					dzImagesIdentidad.options.addedfile.call(dzImagesIdentidad, mockFile);
					dzImagesIdentidad.options.thumbnail.call(dzImagesIdentidad, mockFile, urlHostEmpresas + "/uploads/" + $scope.imagesIdentidadArray[i].image);
					dzImagesIdentidad.files.push(mockFile);
				}
			}

			console.log(dzImagesIdentidad);
		})

		generalService.getFontsCompany({idcompany_p:$scope.currentUser.id_company})
			.then(function(data) {
				$scope.fontsIdentidadArray = data;	
				for(var i in $scope.fontsIdentidadArray){
					
					if ($scope.fontsIdentidadArray[i].font != undefined)
					{
						var mockFile = { name: $scope.fontsIdentidadArray[i].font, size: 12345 };
						dzFontsIdentidad.options.addedfile.call(dzFontsIdentidad, mockFile);
						dzFontsIdentidad.files.push(mockFile);
					}
				}					
			})


		dzImagesIdentidad.on("removedfile", function(file) {
			
			var newPack 	= { id_pack: 0, pack: '' };
			newPack.id_pack = $scope.filesUploaded.length+1;
			newPack.pack 	= file.name;
			newPack.image 	= file.name;
			
			$scope.filesUploaded.push(newPack);
			
			var mockFile = { name: newPack.image, size: 12345 };
			myDropzone.options.addedfile.call(myDropzone, mockFile);
			myDropzone.options.thumbnail.call(myDropzone, mockFile, urlHostEmpresas + 'uploads/' + newPack.image);
			myDropzone.files.push(mockFile);

			var idx = 0;
			var found = false;
			for(var i = 0; i < $scope.imagesIdentidadArray.length; i++) {
				if($scope.imagesIdentidadArray[i].image == file.name) {
					idx = i;
					found = true;
				}
			}

			if(found) {
				$scope.imagesIdentidadArray.splice(idx, 1);	
			}

			if($scope.imagesIdentidadArray.length == 0) {
				$scope.$apply(function(){
				$scope.hideDzImagesIdentidad = true;	
			})
			}

		});


		dzFontsIdentidad.on("removedfile", function(file) {
						
			

			var newFont 	= { id_font: 0, font: '' };
			newFont.id_font = $scope.fontsUploaded.length+1;
			newFont.font 	= file.name;
			$scope.fontsUploaded.push(newFont);

			var mockFile = { name: newFont.font, size: 12345 };
			myDropzone2.options.addedfile.call(myDropzone2, mockFile);
			myDropzone2.files.push(mockFile);

			var idx = 0;
			var found = false;
			for(var i = 0; i < $scope.fontsIdentidadArray.length; i++) {
				if($scope.fontsIdentidadArray[i].font == file.name) {
					idx = i;
					found = true;
				}
			}

			if(found) {
				$scope.fontsIdentidadArray.splice(idx, 1);	
			}

			if($scope.fontsIdentidadArray.length == 0) {
				$scope.$apply(function(){
				$scope.hideDzFontsIdentidad = true;	
			})
			}

			
		});
		
		

		/*campaignService.GSegments(params)
		.then(function(data) {
			$scope.allSegments = data;
		})*/
		
	//  END - * LOADING DATA *	
		
	//  BEGIN - * NEW CAMPAIGN CODE *
	
		/** 	Variables 	**/
		
		$scope.wizardSteps = 1;
		
		/** 	Functions 	**/
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

		$scope.loadPalette = function(newColor){

			var paramss = {
				"idcompany_p" : ""
			}
			
			paramss.idcompany_p 		= $scope.currentUser.id_company;
			
			generalService.getPaletteCompany(paramss)
			.then(function(data) {

				if(typeof data[0].color != 'undefined'){
					
					for(var i = 0; i < data.length; i++) {
						var newPaletteO = { id_palette: 0, color: '' };
						newPaletteO.id_palette = data[i].id_palette;
						newPaletteO.color = data[i].color;
						$scope.paletteArray.push(newPaletteO);
					}
					
				}
				else
				{
					$scope.messageCampaign	 	= "Ocurrió al descargar el pantone de la empresa, favor de contactar a soporte.";
					$scope.alertCampaignClass 	= "alert alert-danger";
					$scope.alertCampaignShow  	= true;
				}
			})
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

		$scope.segmentChange = function(seg){
			$scope.segment = seg;
		}

		$scope.titleChange = function(title){
			$scope.title = title;
		}
		$scope.searchValueChange = function(searchValue){
			$scope.searchValue = searchValue;
		}
		
		$scope.autorizationChange = function(autorization) {
			$scope.autorization = autorization;
		}
		
		//Images added to campaign
		myDropzone.on("success", function(file) {
			var newPack 	= { id_pack: 0, pack: '' };
			newPack.id_pack = $scope.filesUploaded.length+1;
			newPack.pack 	= file.name;
			$scope.filesUploaded.push(newPack);
		});
		//Fonts added to campaign
		myDropzone2.on("success", function(file) {
			var newFont 	= { id_font: 0, font: '' };
			newFont.id_font = $scope.fontsUploaded.length+1;
			newFont.font 	= file.name;
			$scope.fontsUploaded.push(newFont);
		});
		
		/**		Services	**/
		
		$scope.createCampaign = function(){
			var paramss = {
				"description_c" : "",
				"title_c" : "",
				"autorization_c" : "",
				"company_p" : "",
				"segment_c" : ""
			}
			
			paramss.company_p 		= $scope.currentUser.id_company;
			paramss.title_c 		= $scope.title;
			
			if($scope.autorization){
				paramss.autorization_c 	= 1;
			}else{
				paramss.autorization_c 	= 0;
			}
			paramss.description_c 	= $scope.description;
			paramss.segment_c 	= $scope.segment;
			
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
		
		$scope.xx = function(){
			var x = $( "#selectsegment" ).val();
			var y = $( "#selectcity" ).val();
			var z = $( "#selectage" ).val();
			alert(x);
			alert(y);
			alert(z);
		}
		
		$scope.sendData = function(){
			var paramss = {
				"description_c" : "",
				"title_c" : "",
				"autorization_c" : "",
				"company_p" : "",
				"segment_c" : "",
				"city_c" : "",
				"age_c" : ""
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

			$scope.selectedMaterials	= [];

			for( var i in $scope.onlineGrouped) {
				if(i != 'undefined') {
					for( var j in $scope.onlineGrouped[i]) {
						var mat = $scope.onlineGrouped[i][j];
					
						if(typeof mat.items !== 'undefined' && typeof mat.items.selected !== 'undefined') {
							if(mat.items.selected === "1"){	
							
								$scope.selectedMaterials.push(mat.items);
							}
						}
					}
				}
			}

			for( var i in $scope.offlineGrouped2) {
				if(i != 'undefined') {
					for( var j in $scope.offlineGrouped2[i].items) {
						for(var k1 in $scope.offlineGrouped2[i].items[j]) {
							if ( typeof $scope.offlineGrouped2[i].items[j][k1].selected != 'undefined') {
								if($scope.offlineGrouped2[i].items[j][k1].selected === "1") {
									$scope.selectedMaterials.push($scope.offlineGrouped2[i].items[j][k1].items);
								}
							}
						}
					}
				}
			}
				

			/*for( var i in $scope.allMaterials){

				
				return;
				if(typeof $scope.allMaterials[i].selected !== 'undefined'){

					if($scope.allMaterials[i].selected === true){					
						$scope.selectedMaterials.push($scope.allMaterials[i]);
					}
				}
			}*/
		
			for( var i in $scope.allMaterials){
				if(typeof $scope.allMaterials[i].selected !== 'undefined'){

					if($scope.allMaterials[i].selected === true){					
						$scope.selectedMaterials.push($scope.allMaterials[i]);
					}
				}
			}
			
			if($scope.autorization){
				paramss.autorization_c 	= 1;
			}else{
				paramss.autorization_c 	= 0;
			}
			
			if(typeof $scope.newPaletteArray.length == 'undefined' || $scope.newPaletteArray.length == 0 || $scope.newPaletteArray.length == 1) {
				$scope.CreateText 	 = "Favor de agregar al menos dos colores en la Palette";
				$scope.alertCreateClass = "alert alert-danger";
				$scope.alertCreateShow  = true;
				
				return;
			}

			if(typeof $scope.fontsUploaded.length == 'undefined' || $scope.fontsUploaded.length == 0) {
				$scope.CreateText 	 = "Favor de agregar al menos una fuente";
				$scope.alertCreateClass = "alert alert-danger";
				$scope.alertCreateShow  = true;
				
				return;
			}

			if(typeof $scope.selectedMaterials.length == 'undefined' || $scope.selectedMaterials.length == 0) {
				$scope.CreateText 	 = "Favor de agregar al menos un material";
				$scope.alertCreateClass = "alert alert-danger";
				$scope.alertCreateShow  = true;
				
				return;
			}

			paramss.description_c 	= $scope.description;
			//paramss.segment_c 		= $( "#selectsegment" ).val();
			paramss.segment_c 		= $scope.segment;
			paramss.city_c 			= $( "#selectcity" ).val();
			//paramss.age_c 			= $( "#selectage" ).val();
			paramss.age_c 			= 0;
			
			campaignService.SaveNewCampaign(paramss)
			.then(function(data) {
				if(data[0].returnMessage){
			
					pconfig.campaignid 			= data[0].returnMessage;;
					pconfig.textconfig_p 		= $scope.newTextsArray;
					pconfig.palette_p 			= $scope.newPaletteArray;
					pconfig.pack_p 				= $scope.filesUploaded;
					pconfig.font_p 				= $scope.fontsUploaded;
					pconfig.material_p 			= $scope.selectedMaterials;

					campaignService.SaveCampaignConfig(pconfig)
					.then(function(data) {
						if(data[0].returnMessage === 'SUCCESS'){
							$scope.title 				= "";
							$scope.description			= "";
							$scope.newTextsArray		= [];
							$scope.newPaletteArray		= [];
							$scope.filesUploaded		= [];
							$scope.fontsUploaded		= [];
							
							$scope.campaignsVisible 	= true;
							$scope.wizardSteps			= 1;

							for( var i in $scope.allMaterials){
								$scope.allMaterials[i].selected = false;
							}
							
							var params = {
								"idcompany_p" : ""
							}
							
							params.idcompany_p 		= $scope.currentUser.id_company;
							
							campaignService.myCampaigns(params)
							.then(function(data) {
								$scope.allCampaigns = data;
								$scope.CreateText 	 = "Campaña creada exitosamente.";
								$scope.alertCreateClass = "alert alert-success";
								$scope.alertCreateShow  = true;
							})							
							
						}
						else{
							$scope.CreateText 	 = "Ocurrió un error en la aplicación, intenté de nuevo más tarde.";
							$scope.alertCreateClass = "alert alert-danger";
							$scope.alertCreateShow  = true;
						}
					})
					
				}
				else{
					$scope.CreateText 	 = "Ocurrió un error en la aplicación, intenté de nuevo más tarde.";
						$scope.alertCreateClass = "alert alert-danger";
						$scope.alertCreateShow  = true;
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
		
		$scope.goToEditCampaign = function(campaign){
			objCampaign.setCampaign(campaign);
			$location.path( '/edit-campaign' );
		}
		
	//  END - * NEW CAMPAIGN CODE *
		
  });
