/**
 * @ngdoc function
 * @name newappApp.controller:campaignMaterialsCtrl
 * @description
 * # campaignMaterialsCtrl
 * Controller of the newappApp
 */

angular.module('newApp')
  .controller('campaignMaterialsCtrl', function ($scope,  ngDialog, $rootScope, $timeout, ngDragDrop, ImagesFactory, UtilsFactory, AppSettings, campaignService, objCampaign , $location, generalService, $modal
) {
	
  	var urlHost = 'https://wizad.mx/';
	var urlHostEmpresas = 'https://empresas.wizad.mx/';
	//var urlHost = 'https://localhost/wizad/';
	//var urlHostEmpresas = 'https://localhost/wizad/empresas/';

	$scope.templates		 = [];
	$scope.template_name	 = "";
	$scope.template_saved_id = 0;
	$scope.template_group_id = 0;

	$scope.designs			= [];
	$scope.design_name		= "";
	$scope.design_saved_id	= 0;
	$scope.design_group_id	= 0;

	$scope.icon_folder = 'Opcion4';
	$scope.CampaignSelected =  {

				"id_campaign" 	: "",
				"description" 	: "",
				"name" 			: "",
				"date_up" 		: "",
				"date_update" 	: "",
				"status" 		: "",
				"autorization"  : ""
		}
	$scope.currentFont = "";
	$scope.currentFontSize = "";
	$scope.currentFontAlign = "";

	$scope.activeObject = null;
	
	$scope.objectsC = [];
	$scope.factory = {};
	$scope.canvas = {};
	$scope.factory.stickersCount = 0;
	$scope.factory.photosCount = 0;
	$scope.factory.canvas = new fabric.Canvas("play_board");
	$scope.factory.canvas.preserveObjectStacking = true;
	$scope.formSelected = false;
	$scope.imageSelected = false;
	$scope.canvasTarget = false;
	$scope.showFonts = false;
	$scope.paletteArray = [];
	$scope.fontArray = [];
	$scope.paletteArrayCopy = [];
	$scope.liStyle = "1px solid black";
	$scope.showImages = 0;
	$scope.showImagesIdentity = 0;
	$scope.showImagesCampaign = 0;
	$scope.showFontsCampaign = 0;
	$scope.canvasWidth = "700";
	$scope.canvasHeight = "500";
	// $scope.adminNotified = false;
	$scope.alertExpiredShow  = false;
	$scope.randomNumberArray = [];
	$scope.zoomActivated = false;
	$scope.myFontStack = "";
	$scope.cropStarted = false;
	$scope.fontsSizeDropdown = [8,9,10,11,12,14,16,18,20,22,24,26,28,36,48,72];
	$scope.gridElements = [];
	$scope.printingLinesElements = [];
	$scope.clipToFunctions = [];
	$scope.clipToFunctionsValues = [];
	$scope.clipToFunctionsFcs = [];
	
	$scope.showGrid = false;
	$scope.oldshowGrid = true;
	$scope.showPrintingLines = false;
	$scope.oldshowPrintingLines = false;
	
	// crop
	$scope.el = {};
	$scope.object = {};
	$scope.lastActive = {};
	$scope.selection_object_left=0;
	$scope.selection_object_top=0;
	$scope.cntObj=0;

	$scope.object1 = {};
	$scope.object2 = {};
	
	$scope.uploadFileWiz = "";
	
	$scope.topRuler = new fabric.Canvas('top-ruler');
	$scope.leftRuler = new fabric.Canvas('left-ruler');
	
	$scope.loading = false;
	$scope.waitingMessage = "";
	
	/* vars for PPTs */
	$scope.thumbnails = [];
	$scope.pdf = null;
	$scope.imgDataToExportPDF = [];
    /* vars for PPTs */
	
	
	var main = document.getElementById("play_board");
	var ctx = main.getContext("2d")
	
	$scope.$on('openTemplate', function () {

		setTimeout(function() { 
			
			$( "#selectmateriall > option" ).each(function() {
				
				if(this.value == generalService.material_id) {
				
					$( "#selectmateriall").val(this.value).trigger('change');
					$scope.materialChange(this.value);
				}
			});
			
			$scope.loadTemplate({id: generalService.template_id});
			
		}, 1000);
    });


	$scope.$on('openDesign', function () {

		setTimeout(function() { 
			
			$( "#selectmateriall > option" ).each(function() {
				
				if(this.value == generalService.material_id) {
				
					$( "#selectmateriall").val(this.value).trigger('change');
					$scope.materialChange(this.value);
				}
			});
			
			$scope.loadDesign({id: generalService.design_id});
			
		}, 1000);
    });

	$scope.$watch(function() {
		return $scope.myKey; 
	}, function(newValue){

		if(newValue.key === "Delete") {
			$scope.deleteSelectedObject();
		}	
		
	});
		
	$scope.fontsUploaded = [];
	generalService.GFonts()
	.then(function(data) {
		$scope.fontsUploaded = data;

	})

	$scope.getColumnImages = function (array) {
        
        if(array.length % 2 === 0 ) { 
        	return [
            	Math.floor(array.length / 2) + 1,
            	-Math.floor(array.length / 2)
        	];
        } else {

        	return [
            	Math.floor(array.length / 2) + 1,
            	-Math.floor(array.length / 2)
        	];
        }

        
    };

	$scope.deleteTemplate = function(template) {
		
		var params = {
			idtemplate_p : ""
		}

		params.idtemplate_p = template.id;
		
		generalService.DTemplate(params)
			.then(function(data) {
					
				var params = {
					idcompany_p : "",
					idmaterial_p: "",
					idcampaign_p: ""
				}

				params.idcompany_p  = $scope.currentUser.id_company;
				params.idmaterial_p = $scope.newMaterialChange.id_material ;
				params.idcampaign_p	= $scope.CampaignSelected.id_campaign;

				generalService.GTemplates(params)
				.then(function(data) {
					$scope.templates = data;
				});

			}, function(error){
				
				alert('Error al guardar. Mensaje de error: ' + error);
				$scope.loading = false;
			})
	}
	

	$scope.loadTemplate = function(template) {

		var params = {
			idtemplate_p: ""
		}
		params.idtemplate_p = template.id;

		generalService.GTemplate(params)
			.then(function(data) {
				
				$scope.factory.canvas.clear();	

				data[0].contents = data[0].contents.replace(/\n/g, "\\n");
				data[0].contents = data[0].contents.replace(/\r/g, "\\r");
				$scope.removeClipToFunctions(JSON.parse(data[0].contents));
				$scope.factory.canvas.loadFromJSON(data[0].contents);

				$scope.template_saved_id = data[0].id;
				$scope.template_name = data[0].name;
				$scope.template_group_id = data[0].template_group_id;

				$timeout( function(){
					$scope.restoreClipToFunctions();
					$scope.factory.canvas.renderAll();
					
				}, 2000 );
				$scope.loading = false;

				if ($scope.newMaterialChange.multipage == 1) {
				
					$scope.getThumbnails();
				}


			}, function(error){
				
				alert('Error al guardar. Mensaje de error: ' + error);
				$scope.loading = false;
			})

	}


	$scope.loadDesign = function(design) {

		var params = {
			idudesign_p: ""
		}
		params.idudesign_p = design.id;

		generalService.GDesign(params)
			.then(function(data) {
				
				$scope.factory.canvas.clear();	
				$scope.removeClipToFunctions(JSON.parse(data[0].contents));
				$scope.factory.canvas.loadFromJSON(data[0].contents);

				$scope.design_saved_id = data[0].id;
				$scope.design_name = data[0].name;
				$scope.design_group_id = data[0].udesign_group_id;
				$scope.template_saved_id = data[0].template_id;

				$timeout( function(){
					$scope.restoreClipToFunctions();
					$scope.factory.canvas.renderAll();
					
				}, 2000 );
				$scope.loading = false;

				if ($scope.newMaterialChange.multipage == 1) {
				
					$scope.getDesignThumbnails();
				}


			}, function(error){
				
				alert('Error al guardar. Mensaje de error: ' + error);
				$scope.loading = false;
			})

	}


	$scope.loadSlideFromThumbnail = function(item) {
	
		previous_showgrid = $scope.showGrid;
	 
		if( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = true;
			$scope.togglePrintingLines();
		}

		if( $scope.currentUser.typenum == '3') {
			$scope.savingToDB('design');
			$scope.loadDesign(item);
		} else {
			$scope.savingToDB('template');
			$scope.loadTemplate(item);
		}
		

		if( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = false;
			$scope.togglePrintingLines();
		}
	
	}
	

	var accepti = ".png,.jpg";
	var acceptf = ".ttf,.otf";
	var myDropzone2 = new Dropzone("#dropzoneFrm2", { addRemoveLinks: true , acceptedFiles: acceptf });
	// var myDropzone3 = new Dropzone("#dropzoneFrm3", { addRemoveLinks: true , acceptedFiles: accepti });
	
	myDropzone2.on("success", function(file) {
		var newFont 	= { id_font: 0, font: '' };
		newFont.id_font = $scope.fontsUploaded.length+1;
		newFont.font 	= file.name.substring(0, file.name.length-4);
		$scope.fontsUploaded.push(newFont);
		
		var FormatType = "";
		if(file.name.indexOf("otf") !== -1){
			FormatType = "opentype";
		}
		if(file.name.indexOf("ttf") !== -1){
			FormatType = "truetype";
		}
		$("head").append("<style>@font-face { font-family: "+file.name.substring(0, file.name.length-4)+";    src: url('/uploads/"+file.name+"') format('"+FormatType+"');}</style>");
		$scope.$apply();
		$scope.factory.canvas.renderAll();
		// file._downloadLink = Dropzone.createElement("<button type=\"button\" class=\"btn btn-primary btn-embossed\" ng-click=\"modifyFont()\" style=\"margin-top:3px;\">Aplicar</button>");
		// file.previewElement.appendChild(file._downloadLink);    
		return file.previewElement.classList.add("dz-success");
	});
	
	
  
	$scope.modifyFont = function(){
			
		var activeObject = $scope.factory.canvas.getActiveObject();
		activeObject.fontFamily = $scope.myFontStack;
		$scope.factory.canvas.renderAll();
		
	}
	
	// myDropzone3.on("success", function(file) {
		// // var newFont 	= { id_font: 0, font: '' };
		// // newFont.id_font = $scope.fontsUploaded.length+1;
		// // newFont.font 	= file.name;
		// // $scope.fontsUploaded.push(newFont);
		// file._downloadLink = Dropzone.createElement("<button type=\"button\" class=\"btn btn-primary btn-embossed\" data-dismiss=\"modal\" style=\"margin-top:3px;\">Aplicar</button>");
		// file.previewElement.appendChild(file._downloadLink);    
		// return file.previewElement.classList.add("dz-success");
	// });
	
	if($scope.currentUser.id_company === "4"){
		$scope.adminNotified = true;
	}
	
	/*var newPaletteO = { color: "" };
	newPaletteO.color = "#000000";
	$scope.paletteArray.push(newPaletteO);
	newPaletteO = { color: "" };
	newPaletteO.color = "#FFFFFF";
	$scope.paletteArray.push(newPaletteO);*/
	
	$scope.notifyAdministrador = function(){
		$scope.adminNotified = true;
		
		var params = {
				"company_p" : "",
				"user_p"	: ""
			}
			params.company_p = $scope.currentUser.fk_company;
			params.user_p 	 = $scope.currentUser.name;
			
			generalService.NotifyAdministratorFreeCampaign(params)
			.then(function(data) {
				
			})
		
		var historyUser = {
				"user_p" 		: "",
				"message_p"		: "",
				"campaign_p"	: ""
			}
			
			historyUser.user_p		= $scope.currentUser.id_user;
			historyUser.message_p	= "Inicio campaña libre";
			historyUser.campaign_p 	= 0;
			
			generalService.AddHistory(historyUser)
			.then(function(data) {
				
			})
	}
	
	$scope.clearCanvas = function(){
		$scope.factory.canvas.clear();
	}
	
	$scope.newPalette = function(newColor){
		
		$scope.your_model = "";
		if(typeof newColor == 'undefined' || newColor === ""){
			$scope.alertExpiredClass = "alert alert-warning";
			$scope.alertExpiredShow  = true;
			$scope.alertExpiredMessage = "Seleccione un color..";
			return;
		}
		
		for(var i in $scope.paletteArray){
			
			if($scope.paletteArray[i].color === newColor){
				$scope.alertExpiredClass = "alert alert-warning";
				$scope.alertExpiredShow  = true;
				$scope.alertExpiredMessage = "Color ya agregado anteriormente..";
				return;
			}
		}
				
		var newPaletteR = { color: '' };
		newPaletteR.color = newColor;
		$scope.paletteArray.push(newPaletteR);
		$scope.alertExpiredShow  = false;
	}
	
	$scope.materialChange = function(selectedFromOutside){
		
		$scope.newMaterialChange = {};
		var material = 0;
		if(selectedFromOutside != undefined)
			material = selectedFromOutside;
		else 
			material = $( "#selectmateriall" ).val();
		
		for (var i in $scope.materialArray){
			if($scope.materialArray[i].id_material === material){
				
				$scope.newMaterialChange = $scope.materialArray[i];
				$scope.canvasWidth = $scope.materialArray[i].width;
				$scope.canvasHeight = $scope.materialArray[i].height;
				break;
			}
		}
		
		if(typeof $scope.newMaterialChange.width_small == 'undefined' || $scope.newMaterialChange.width_small == "" || $scope.newMaterialChange.width_small == 0) {
			
			alert("El material ha sido definido incorrectamente\nFavor de contactar al administrador de campaña");
			return false;
		}
		
		if(typeof $scope.newMaterialChange.height_small == 'undefined' || $scope.newMaterialChange.height_small == "" || $scope.newMaterialChange.height_small == 0) {
			
			alert("El material ha sido definido incorrectamente\nFavor de contactar al administrador de campaña");
			return false;
		}
		
		if(typeof $scope.newMaterialChange.width == 'undefined' || $scope.newMaterialChange.width == "" || $scope.newMaterialChange.width == 0) {
			
			alert("El material ha sido definido incorrectamente\nFavor de contactar al administrador de campaña");
			return false;
		}
		
		if(typeof $scope.newMaterialChange.height == 'undefined' || $scope.newMaterialChange.height == "" || $scope.newMaterialChange.height == 0) {
			
			alert("El material ha sido definido incorrectamente\nFavor de contactar al administrador de campaña");
			return false;
		}
		
		$scope.factory.canvas.clear();	
		if($scope.currentUser.id_company === "4" && $scope.newMaterialChange.free == 0){
			
			var myImg = urlHost + 'materiales/'+$scope.newMaterialChange.thumbnail;
			fabric.Image.fromURL(myImg, function(oImg) {
				var l = Math.random() * (500 - 0) + 0;
				var t = Math.random() * (500 - 0) + 0;                
				oImg.scale(0.6);
				oImg.set({'left':0});
				oImg.set({'top':0});
				oImg.set({'opacity':0.85});
				oImg.set({'selectable':false});
				oImg.set({'name':'overlayImage'});
				$scope.factory.canvas.add(oImg);
			});
			
		}
		
		$scope.showCanvasMaterialSelected = true;
		material.style="1px solid black";
		
		
		$scope.widthMultiplier = $scope.canvasWidth / 800;
		$scope.heightMultiplier = $scope.canvasHeight / 500;
		
		
		// se le suman el ancho de las reglas (20px) y 10px mas de tolerancia
		const hc_width = parseInt($scope.newMaterialChange.width_small) + 20 + 10;
		const hc_height = parseInt($scope.newMaterialChange.height_small) + 20 + 10;
		
		
		$("#hero_container").css("width", hc_width +"px");
		$("#hero_container").css("height", hc_height +"px");
		
		
		$scope.factory.canvas.setDimensions({
											width: parseInt($scope.newMaterialChange.width_small), 
											height: parseInt($scope.newMaterialChange.height_small)});
							
		$scope.topRuler.setDimensions({width: $scope.newMaterialChange.width_small, height: 20 });
		
		$scope.leftRuler.setDimensions({width: 20, height: parseInt($scope.newMaterialChange.height_small) });
		
		var gridOptions = {width: parseInt($scope.newMaterialChange.width_small), 
						   height: parseInt($scope.newMaterialChange.height_small), 
						   distance: 10};
		
		if($scope.showGrid)	{
			$scope.addBackgroundGrid(gridOptions);
		}
		
		// print red printing margin lines, uses the same gridOptions
		if($scope.newMaterialChange.offline == 1) {
			$scope.showPrintingLines = true;
			$scope.drawPrintingMargins(gridOptions);	
		}
		

		$scope.factory.canvas.deactivateAll().renderAll();
		$scope.factory.canvas.deactivateAll().renderAll();
		
		$scope.redrawRulers();

		$scope.template_name = "";
		$scope.design_name = "";

		if($scope.currentUser.typenum == '3') {
			
			var params = {
				idcompany_p : "",
				iduser_p: "",
				idcampaign_p: ""
			}

			params.idcompany_p = $scope.currentUser.id_company;
			params.iduser_p = $scope.currentUser.id_user;
			params.idcampaign_p	= $scope.CampaignSelected.id_campaign;

			generalService.GDesigns(params)
			.then(function(data) {
				$scope.designs = data;
			});
		
		} else {
		
			var params = {
				idcompany_p : "",
				idmaterial_p: "",
				idcampaign_p: ""
			}

			params.idcompany_p = $scope.currentUser.id_company;
			params.idmaterial_p = $scope.newMaterialChange.id_material ;
			params.idcampaign_p	= $scope.CampaignSelected.id_campaign;

			generalService.GTemplates(params)
			.then(function(data) {
				$scope.templates = data;
			});
		}
		
	
	}

	$scope.drawPrintingMargins = function(options) {

		lineStyle = {
          stroke: '#ff0000',
          strokeWidth: 1,
          selectable: false
        }

        hTopLineX1 = 36 / $scope.widthMultiplier;
        hTopLineY1 = 36 / $scope.widthMultiplier;
		hTopLineX2 = options.width - hTopLineX1;
		hTopLineY2 = 36 / $scope.widthMultiplier;

		hBtmLineX1 = 36 / $scope.widthMultiplier;
        hBtmLineY1 = options.height - (36 / $scope.widthMultiplier);
		hBtmLineX2 = options.width - (36 / $scope.widthMultiplier);
		hBtmLineY2 = options.height - (36 / $scope.widthMultiplier);
    
		//x1,y1,x2,y2

		hMarginTop = new fabric.Line([ hTopLineX1, hTopLineY1, 
									   hTopLineX2, hTopLineY2], lineStyle);		

		hMarginBtm = new fabric.Line([ hBtmLineX1, hBtmLineY1, 
									   hBtmLineX2, hBtmLineY2], lineStyle);		
        
		$scope.factory.canvas.add(hMarginTop);
		$scope.factory.canvas.add(hMarginBtm);
		$scope.printingLinesElements.push(hMarginTop);
		$scope.printingLinesElements.push(hMarginBtm);

		vLftLineX1 = 36 / $scope.widthMultiplier;
        vLftLineY1 = 36 / $scope.widthMultiplier;
		vLftLineX2 = 36 / $scope.widthMultiplier;
		vLftLineY2 = options.height - (36 / $scope.widthMultiplier);

		vRgtLineX1 = options.width - (36 / $scope.widthMultiplier);
        vRgtLineY1 = 36 / $scope.widthMultiplier;
		vRgtLineX2 = options.width - (36 / $scope.widthMultiplier);
		vRgtLineY2 = options.height - (36 / $scope.widthMultiplier);

		vMarginLft = new fabric.Line([ vLftLineX1, vLftLineY1, 
									   vLftLineX2, vLftLineY2], lineStyle);		

		vMarginRgt = new fabric.Line([ vRgtLineX1, vRgtLineY1, 
									   vRgtLineX2, vRgtLineY2], lineStyle);		
        
		$scope.factory.canvas.add(vMarginLft);
		$scope.factory.canvas.add(vMarginRgt);
		$scope.printingLinesElements.push(vMarginLft);
		$scope.printingLinesElements.push(vMarginRgt);
			
	}
	
	$scope.addBackgroundGrid = function(options) {
		
		gridLen = options.width / options.distance;
		gridHeight = options.height / options.distance;
		
		lineStyle = {
          stroke: '#ebebeb',
          strokeWidth: 1,
          selectable: false
        }
		
		for (var i = 0; i < gridHeight; i++) {
			
			var distance   = i * options.distance;
			horizontal = new fabric.Line([ 0, distance, options.width, distance], lineStyle);
			$scope.gridElements.push(horizontal);
			$scope.factory.canvas.add(horizontal);
			
			if(i%5 === 0){
				horizontal.set({stroke: '#cccccc'});
			}
		}
		
		for (var i = 0; i < gridLen; i++) {
			
			var distance   = i * options.distance;
			vertical = new fabric.Line([ distance, 0, distance, options.height], lineStyle);
			$scope.gridElements.push(vertical);
			$scope.factory.canvas.add(vertical);
			
			if(i%5 === 0){
				vertical.set({stroke: '#cccccc'});
		  }
		}
	}

	$scope.togglePrintingLines = function() {

		if($scope.showPrintingLines == true) {
			
			$scope.showPrintingLines = false;
		
			for (let i = 0; i < $scope.printingLinesElements.length; i++) {
				$scope.factory.canvas.remove($scope.printingLinesElements[i]);
			}
		} else {

			$scope.showPrintingLines = true;

			for (let i = 0; i < $scope.printingLinesElements.length; i++) {
				$scope.factory.canvas.add($scope.printingLinesElements[i]);
			}

		}
		
	}
	
	$scope.toggleGrid = function() {
	
		if($scope.showGrid) {
	  
			for (let i = 0; i < $scope.gridElements.length; i++) {
				$scope.factory.canvas.remove($scope.gridElements[i]);
			}
			
			$scope.showGrid = false;
		
		} else {
		
			for (let i = 0; i < $scope.gridElements.length; i++) {
				$scope.factory.canvas.add($scope.gridElements[i]);
				$scope.factory.canvas.sendToBack($scope.gridElements[i]);
			}
			
			$scope.showGrid = true;
		}
	  
	}
	
	$scope.setTransparent = function(){
		$scope.factory.canvas.setBackgroundColor(null, $scope.factory.canvas.renderAll.bind($scope.factory.canvas));
		// $scope.canvasTarget = false;
	}
	
	$scope.addZoom = function(){
		$scope.factory.canvas.setZoom($scope.factory.canvas.getZoom()+1);
		$scope.factory.canvas.renderAll();
	}
	  
	$scope.lessZoom = function(){
		$scope.factory.canvas.setZoom($scope.factory.canvas.getZoom()-1);
		$scope.factory.canvas.renderAll();
	}
	
	$scope.seeImagesIdentity = function(){
		$scope.showImagesIdentity = 1;
	}
	$scope.seeImages = function(){
		$scope.showImagesCampaign = 1;
	}
	$scope.hideImages = function(){
		$scope.showImagesCampaign = 0;
	}
	$scope.hideImagesIdentity = function(){
		$scope.showImagesIdentity = 0;
	}
	$scope.seeFonts = function(){
		//console.log("onFonts");
		$scope.showFontsCampaign = 1;
	}
	$scope.hideFonts = function(){
		$scope.showFontsCampaign = 0;
	}
	
	objCampaign.getCampaign()
		.then(function(data) {
	
			$scope.CampaignSelected.id_campaign = data.id_campaign;
			$scope.CampaignSelected.description = data.description;
			$scope.CampaignSelected.name 		= data.campaign_name;
			$scope.CampaignSelected.date_up 	= data.date_up;
			$scope.CampaignSelected.date_update = data.date_update;
			$scope.CampaignSelected.status 		= data.status;	
			$scope.CampaignSelected.autorization = data.download;		
					

			var params = {
				"campaign_p" : ""
			}
			
			params.campaign_p = $scope.CampaignSelected.id_campaign;
			$scope.images = [];
			$scope.imagesIdentity = [];
			$scope.phrases = [];
			
			campaignService.GPackCampaign(params)
			.then(function(data) {
				if(data.length>0) {
					$scope.imageArray = data;
					console.log("$scope.imageArray", $scope.imageArray);
					for (var i in $scope.imageArray){
						if(typeof $scope.imageArray[i].image != 'undefined') {
							var newImg   = { title: '', src: '' , isUserUploaded: false};
							newImg.title = $scope.imageArray[i].image;
							newImg.src   = urlHostEmpresas + 'uploads/' + $scope.imageArray[i].image;
							$scope.images.push(newImg);
						}
					}
				}
			})
			
			campaignService.GPackIdentity(params)
			.then(function(data) {
				if(data.length>0){
					$scope.identityImageArray = data;
					console.log("$scope.identityImageArray", $scope.identityImageArray);
					for (var i in $scope.identityImageArray){
						if(typeof $scope.identityImageArray[i].image != 'undefined') {
							var newImg   = { title: '', src: '' , isUserUploaded: false};
							newImg.title = $scope.identityImageArray[i].image;
							newImg.src   = urlHostEmpresas + 'uploads/' + $scope.identityImageArray[i].image;
							$scope.imagesIdentity.push(newImg);
						}
					}
				}
			})
			
			 campaignService.GPaletteCampaign(params)
			 .then(function(data) {
				 $scope.paletteArray = data;
				
				 /*var newPaletteO = { id_palette: 10000, color: '#FFFFFF' };
				 $scope.paletteArray.push(newPaletteO);*/
				
			 })
			
			campaignService.GFontsCampaign(params)
			.then(function(data) {
				$scope.fontArray = data;
				
				$scope.fontsDropdown = [];
		
				for(var a = 0; a < $scope.fontArray.length ; a++){
					
					$scope.fontsDropdown[a] = {name: $scope.fontArray[a].font.slice(0, -4), url: $scope.fontArray[a].url }
										
					var newStyle = document.createElement('style');
					newStyle.appendChild(document.createTextNode("\
					@font-face {\
						font-family: " + $scope.fontsDropdown[a].name + ";\
						src: url('" + $scope.fontsDropdown[a].url + "');\
					}\
					"));

					document.head.appendChild(newStyle);
				}
				
				
			})
			
			$scope.applyFont2 = function(font){
				
				var activeObject = $scope.factory.canvas.getActiveObject();
				var style = { };
				
				$scope.currentFont = activeObject.fontFamily;
				$scope.currentFontSize = activeObject.fontSize;
					
				if (activeObject.setSelectionStyles && activeObject.isEditing) {
					
					style["fontFamily"] = font.name;
					activeObject.setSelectionStyles(style);
				} else {
					activeObject.set({
						fontFamily : font.name
					});

				
				}
				$scope.factory.canvas.renderAll();
		
			}
			

			$scope.applyFontSize22 = function(size) {
				
				var activeObject = $scope.factory.canvas.getActiveObject();
				var style = { };
				
				$scope.currentFontSize = activeObject.fontSize;
				
				if( typeof activeObject.fontFamily == 'undefined' || activeObject.fontFamily == "" || activeObject.fontFamily == "Allerta+Stencil") {
					
					activeObject.fontFamily = $scope.fontsDropdown[0].name;
				}
				
				if (activeObject.setSelectionStyles && activeObject.isEditing) {
					
					style["fontSize"] = size - 4;
					activeObject.setSelectionStyles(style);
				} else {

					activeObject.set({
						fontSize : size - 4
					});

				}
				
				$scope.factory.canvas.renderAll();
				$scope.factory.canvas.renderAll();
			
			}


			$scope.changeTextAlign = function(alignment) {
				var activeObject = $scope.factory.canvas.getActiveObject();
				var style = {};
				
				$scope.currentFontAlign = alignment;

				if( typeof activeObject.fontFamily == 'undefined' || activeObject.fontFamily == "" || activeObject.fontFamily == "Allerta+Stencil") {
					
					activeObject.set({
						fontFamily : $scope.fontsDropdown[0].name
					});
				}
				
				activeObject.textAlign = alignment;
				$scope.factory.canvas.renderAll();
			}

			$scope.changeTextLineHeight = function(line_height) {
				var activeObject = $scope.factory.canvas.getActiveObject();
				var style = {};

				if( typeof activeObject.fontFamily == 'undefined' || activeObject.fontFamily == "" || activeObject.fontFamily == "Allerta+Stencil") {
					
					activeObject.fontFamily = $scope.fontsDropdown[0].name;
				}
				
				activeObject.lineHeight = line_height;
				$scope.factory.canvas.renderAll();
			}

			$scope.convertToArcText = function() {
				var activeObject = $scope.factory.canvas.getActiveObject();
				$scope.activeObject = activeObject;

				if( typeof activeObject.fontFamily == 'undefined' || activeObject.fontFamily == "" || activeObject.fontFamily == "Allerta+Stencil") {
					
					activeObject.fontFamily = $scope.fontsDropdown[0].name;
				}

				if(activeObject.id.substring(0, 7) == 'arctext') {

					activeObject.set({
						diameter : +$('#ttc_diameter').val(),
						kerning  : +$('#ttc_kerning').val(),
						flipped  : $('#ttc_flip').is(':checked')
							});


					$scope.factory.canvas.renderAll();
				} else {
					
					var random = $scope.getRandomSpan();
					random = "arctext" + random;

					var arcText = new fabric.CurvedText(activeObject.text, {
						id: random,
						fontSize: activeObject.fontSize,
						fontFamily: activeObject.fontFamily,
						left: activeObject.left,
						top: activeObject.top,
						diameter: +$('#ttc_diameter').val(),
						kerning: +$('#ttc_kerning').val(),
						flipped: $('#ttc_flip').is(':checked')
					});

					$scope.factory.canvas.remove(activeObject);
					$scope.factory.canvas.add(arcText);
					$scope.factory.canvas.setActiveObject(arcText);
					$scope.factory.canvas.renderAll();
					
				}
				
				
			
			}

			campaignService.GMaterialsCampaign(params)
			.then(function(data) {
				$scope.materialArray = data;
				for (var i in $scope.materialArray){
					$scope.materialArray[i].style="";
				}
			})
			
			campaignService.GTextsCampaign(params)
			.then(function(data) {
				if(data.length>0){
					$scope.phrasesArray = data;
					for (var i in $scope.phrasesArray){
						var newPhrase   = { id_cgtext: '', date_up: '', date_update: '', fk_campaign: '', status: '', text: ''};
						
						newPhrase.id_cgtext = $scope.phrasesArray[i].id_cgtext;
						newPhrase.date_up = $scope.phrasesArray[i].date_up;
						newPhrase.date_update = $scope.phrasesArray[i].date_update;
						newPhrase.status = $scope.phrasesArray[i].status;
						newPhrase.text = $scope.phrasesArray[i].text;
						
						$scope.phrases.push(newPhrase);
					}
				}
			})
		})
		
	$scope.ZoomStatus = function(){
		if ($scope.zoomActivated){
			$scope.zoomActivated = false;
		}else{
			$scope.zoomActivated = true;
		}
	}
	
	
	$scope.factory.canvas.on({
	  'object:moving': function objectMoving(e) {
		$scope.$broadcast('objectMoving', e);
	  },
	  'object:selected': function objectSelected(e) {
		$scope.$broadcast('objectSelected', e);
	  },
	  'selection:cleared': function selectionCleared(e) {
		$scope.$broadcast('objectCleared', e);
	  },
	  'object:modified': function objectModified(e) {
		$scope.$broadcast('objectModified', e);
	  },
	  'object:added': function objectAdded(e) {
		$scope.$broadcast('objectAdded', e);
	  },
	  'object:removed': function objectRemoved(e) {
		$scope.$broadcast('objectRemoved', e);
	  },/*
	  'mouse:move': function MouseMoving(e) {
		// $scope.$broadcast('mouseMoving', e);
		if ($scope.zoomActivated){
			console.log(e);
			zoomCtx.fillStyle = "white";
			//zoomCtx.clearRect(0,0, zoom.width, zoom.height);
			//zoomCtx.fillStyle = "transparent";
			var pointer = $scope.factory.canvas.getPointer(e.e);
			  var posX = pointer.x;
			  var posY = pointer.y;
			zoomCtx.fillRect(0,0, zoom.width, zoom.height);
			zoomCtx.drawImage(main, e.e.offsetX, e.e.offsetY, 200, 100, 0,0, 400, 200);
			console.log(zoom.style);
			zoom.style.top = e.e.offsetY + 10 + "px"
			zoom.style.left = e.e.offsetX + 10 + "px"
			zoom.style.display = "block";
		}else{
			zoom.style.display = "none";
		}
		
	  },*/
	  'path:created': function pathCreated(e) {
		$scope.$broadcast('pathCreated', e);
	  }
	});
	
		//*stickers*//
		
		
	  $scope.images = [];


	  //Restore Stored Stickers
	  var stickersImgs = ImagesFactory.getRestoredStickerImages($scope.images);
	  $scope.images = stickersImgs;

	  $scope.uploaded = false;
	  $scope.title = "";
	  $scope.previewImages = [];

	  //Drag & Drop Styles
	  $scope.styles = {
		draggables: {
		  onDragging: { border: "1px dashed #000", cursor: "move" },
		  onStart: { opacity: 0.5 }
		},
		droppables: {
		  onEnter: { border: "1px dashed #2DA43E" },
		  onLeave: { border: "" }
		}
	  };

	  //Drag Drop Events Callbacks
	  $scope.dragCallback = function (event) {
		//console.log("Dragging", event);
		var rectSecondObj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'name', 'overlayImage');
		$scope.factory.canvas.bringToFront(rectSecondObj);
	  };

	  $scope.dropCallback = function (event) {
		var currDragElem = ngDragDrop.getCurrentDragElement();
		var imgSrc = currDragElem.attr("src");
		var object = {
		  src: imgSrc,
		  drop: true
		};
		$scope.dropImage(object, event);
		//console.log("Dropped", event);
	  };

	  $scope.overCallback = function (event) {
		//console.log("Drag Over", event);
	  };

	  //Delete Sticker
	  $scope.deleteSticker = function (image) {
		var index = $scope.images.indexOf(image);
		$scope.images.splice(index, 1);
		ImagesFactory.deleteStickerImage(image); //delete from persisted localStorage
		UtilsFactory.resetUsedFileStorageSpace(); //Reset the $rootScope file storage for header data update
	  };

	  //callback function once file is uploaded
	  $scope.onFileUpload = function () {
		// var guid = UtilsFactory.guid();
		var imageDimensions = document.createElement('img');
		// imageDimensions.addEventListener('load', function() {
			// // image.width × image.height
			// $scope.widthPrev  = imageDimensions.width; 
			// $scope.heightPrev = imageDimensions.height;
		// });
		
		
		var image = {
			// guid: guid,
			src: $scope.previewImages[0]
		};
		
		imageDimensions.src = image.src;
		image.width = imageDimensions.width; 
		image.height = imageDimensions.height;
		var myDivElement = $( "#mContent" );
		
		$scope.images.push(image);
		// ImagesFactory.savePhotoImage(image);
		//console.log($scope.images);
		//console.log("preview");
		//console.log($scope.previewImages);
		// UtilsFactory.resetUsedFileStorageSpace(); //Reset the $rootScope file storage for header data update
		$scope.previewImages = [];
		var sticker = {
		  src: $scope.previewImages[0],
		  title: "Nueva imagen",
		  isUserUploaded: true
		};
		ImagesFactory.saveStickerImage(sticker);
		
	  };

	  //submit sticker
	  $scope.submitSticker = function (form) {
		var guid = UtilsFactory.guid();
		var sticker = {
		  src: $scope.previewImages[0],
		  title: $scope.title,
		  isUserUploaded: true,
		  guid: guid
		};

		if (form.$valid && $scope.previewImages.length) {
		  //if form is valid perform action
		  form.$setPristine();
		  form.$setUntouched();
		  $scope.uploaded = false;
		  $scope.images.push(sticker);
		  ImagesFactory.saveStickerImage(sticker); //Persist Sticker Image
		  UtilsFactory.resetUsedFileStorageSpace(); //Reset the $rootScope file storage for header data update
		  $scope.previewImages = []; //Reset the images
		  ngDialog.close();
		}
	  };

	  //upload sticker
	  $scope.uploadSticker = function () {
		$timeout(function () {
		  //Notify $digest cycle hack
		  $('#sticker_upload').trigger('click');
		}, 0);
	  };

	  //open upload dialog
	  $scope.openUploadDialog = function () {
		if (0 >= 1) { //AppSettings.maxStorageSpace
		  //if storage exceed max app provided storage space then throw error
		  alert("Exceeded max provided localstorage space. Please empty to save.");
		} else {
		  //open dialog to save
		  ngDialog.open({
			template: 'design/stickerDialog.html',
		  });
		}
	  };

	  //Add Image to Canvas Area
	  $scope.dropImage = function (obj, $event) {
		// var canvas = CanvasFactory.getCanvas();
		// $scope.objectsC = canvas._objects;
		
		var PosX = undefined,
			PosY = undefined;
		if (obj.drop === true) {
		  PosX = $event.clientX - $event.currentTarget.offsetLeft - 50;
		  PosY = $event.clientY - $event.currentTarget.offsetTop - 54; //offset height of header
		}
		fabric.Image.fromURL(obj.src, function (oImg) {
		  
			var random = $scope.getRandomSpan();
			random = "img" + random;
			oImg.set('id', random)
			$scope.factory.canvas.centerObject(oImg);
			oImg.scaleToWidth(250);
			oImg.scaleToHeight(250);
			
			if (obj.drop === true) {
				oImg.set('left', PosX).set('top', PosY);
			} else {
				oImg.set({left: 10, top: 10});
			}
			$scope.factory.canvas.add(oImg);
			var rectSecondObj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'name', 'overlayImage');
			$scope.factory.canvas.bringToFront(rectSecondObj);
			$scope.factory.canvas.renderAll();
			$scope.factory.canvas.renderAll();
		  // canvas.add(oImg);
		});
	  };
	  
	  
	  $scope.dropPhrase = function (obj, $event) {
		
		$scope.addText(obj.text);
		
	  };
	  
	  	//*canvas*//

	  $scope.isObjectSelected = false;

	  //mouseMoving
		// $scope.$on("mouseMoving", function (e) {
			// $timeout(function () {
				// // console.log(e);
				// zoomCtx.fillStyle = "white";
				// //zoomCtx.clearRect(0,0, zoom.width, zoom.height);
				// //zoomCtx.fillStyle = "transparent";
				// zoomCtx.fillRect(0,0, zoom.width, zoom.height);
				// zoomCtx.drawImage(main, e.x, e.y, 200, 100, 0,0, 400, 200);
				// console.log(zoom.style);
				// zoom.style.top = e.pageY + 10 + "px"
				// zoom.style.left = e.pageX + 10 + "px"
				// zoom.style.display = "block";
			// }, 0);
		// });
	  
	  //on object selection
	  $scope.$on("objectSelected", function () {
		$timeout(function () {
		  $scope.isObjectSelected = true;
		  $scope.canvasTarget = false;
		  var activeObject = $scope.factory.canvas.getActiveObject();
		  
		  if(activeObject) {
			  if (typeof activeObject.id == 'undefined') {
				  
				  activeObject.id = activeObject.get('type') + $scope.getRandomSpan();
			  }
			  
			  if(activeObject.id.indexOf("circle") !== -1 || activeObject.id.indexOf("triangle") !== -1
					|| activeObject.id.indexOf("rect") !== -1 || activeObject.id.indexOf("text") !== -1
					|| activeObject.id.indexOf("line") !== -1){
					$scope.formSelected = true;
					
					if(activeObject.id.indexOf("text") !== -1){
						$scope.showFonts = true;
						$scope.formSelected = false;
					}
					else{
						$scope.showFonts = false;
					}
					
			  }else{
					$scope.formSelected = false;
					$scope.showFonts = false;
			  }
			  if(activeObject.type === "image" ){
					$scope.imageSelected = true;
					$scope.showFonts = false;
			  }else{
					$scope.imageSelected = false;
			  }
		  }
		}, 0);
	  });
	  
	  $scope.changeFormColor = function(pal){
			var activeObject = $scope.factory.canvas.getActiveObject();
			var style = {};
			//console.log(activeObject.type);
			
			if(activeObject.type === "circle" || activeObject.type === "triangle" 
				|| activeObject.type === "rect"){
				activeObject.setFill(pal.color);	
			} else if(activeObject.type === "line"){
				activeObject.setStroke(pal.color);	
			} else if (activeObject.type === "textbox") {
				
				if (activeObject.setSelectionStyles && activeObject.isEditing) {
						//console.log("parcial");
					style["fill"] = pal.color;
					activeObject.setSelectionStyles(style);
				} else {
					
					activeObject.setFill(pal.color);
				}
				
			} else if(activeObject.type === "curved-text") {
				activeObject.set({
					fill : pal.color
				});
			}
			// $scope.formSelected = false;
			// $scope.factory.canvas.deactivateAll().renderAll();
			// activeObject.setColor(pal.color);
			$scope.factory.canvas.renderAll();
	  }

	$scope.applyOpacity = function(obj){
		var activeObject = $scope.factory.canvas.getActiveObject();
		var style = {};

		if (activeObject.setSelectionStyles && activeObject.isEditing) {	
			style["opacity"] = obj.myopacity;
			activeObject.setSelectionStyles(style);
		} else {
			activeObject.set({
				opacity: obj.myopacity
			});
		}

		$scope.factory.canvas.renderAll();
	}
	  
	  var download = function download(url, name) {

	  	var data = url.replace("data:image/png;base64,", "");
	    var blob = b64toBlob(data, 'image/png');
	    var blobUrl = URL.createObjectURL(blob);
	  	var a = document.createElement("a");
		document.body.appendChild(a);
		a.download = name;
		a.href = blobUrl;
		a.style = "display: none";
		a.click();

	  };

	function b64toBlob(b64Data, contentType, sliceSize) {
	    contentType = contentType || '';
	    sliceSize = sliceSize || 512;

	    var byteCharacters = atob(b64Data);
	    var byteArrays = [];

	    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
	        var slice = byteCharacters.slice(offset, offset + sliceSize);

	        var byteNumbers = new Array(slice.length);
	        for (var i = 0; i < slice.length; i++) {
	            byteNumbers[i] = slice.charCodeAt(i);
	        }

	        var byteArray = new Uint8Array(byteNumbers);

	        byteArrays.push(byteArray);
	    }

	    var blob = new Blob(byteArrays, {
	        type: contentType
	    });
	    return blob;
	}	


		  
	 $scope.exportOnePagePDF = function(name) {
		previous_showgrid = $scope.showGrid;
		
		$scope.showGrid = true;
		$scope.toggleGrid();
		previous_showprintingLines = $scope.showPrintingLines;
		
		if ( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = true;
			$scope.togglePrintingLines();
		}
		
		$scope.factory.canvas.deactivateAll().renderAll();
		$scope.factory.canvas.setZoom(1);
	
		$scope.savingCanvasWidth = $scope.factory.canvas.width;
		$scope.savingCanvasHeight = $scope.factory.canvas.height;

		fabric.devicePixelRatio = 1;
		 
		$scope.factory.canvas.setDimensions({width: $scope.newMaterialChange.width, height: 
			parseInt($scope.newMaterialChange.height)});
			
		var objects =  $scope.factory.canvas.getObjects();
		for (var i in objects) {
			var scaleX = objects[i].scaleX;
			var scaleY = objects[i].scaleY;
			var left = objects[i].left;
			var top = objects[i].top;

			var tempScaleX = scaleX * $scope.newMaterialChange.width_multiplier;
			var tempScaleY = scaleY * $scope.newMaterialChange.height_multiplier;
			var tempLeft = left * $scope.newMaterialChange.width_multiplier;
			var tempTop = top * $scope.newMaterialChange.height_multiplier;

			objects[i].scaleX = tempScaleX;
			objects[i].scaleY = tempScaleY;
			objects[i].left = tempLeft;
			objects[i].top = tempTop;

		//	objects[i].setCoords();
		}

		$scope.factory.canvas.renderAll();
		$scope.factory.canvas.calcOffset();
		
		var imgData = $scope.factory.canvas.toDataURL({       format: 'png'   });
		console.log("img ind", imgData);
		
		//AFTER DOWNLOAD RETURN TO NORMAL STATE
		
		$scope.factory.canvas.setDimensions({width: $scope.newMaterialChange.width_small, height: 
			parseInt($scope.newMaterialChange.height_small)});
			
		var objects =  $scope.factory.canvas.getObjects();
		for (var i in objects) {
			var scaleX = objects[i].scaleX;
			var scaleY = objects[i].scaleY;
			var left = objects[i].left;
			var top = objects[i].top;

			var tempScaleX = scaleX / $scope.newMaterialChange.width_multiplier;
			var tempScaleY = scaleY / $scope.newMaterialChange.height_multiplier;
			var tempLeft = left / $scope.newMaterialChange.width_multiplier;
			var tempTop = top / $scope.newMaterialChange.height_multiplier;

			objects[i].scaleX = tempScaleX;
			objects[i].scaleY = tempScaleY;
			objects[i].left = tempLeft;
			objects[i].top = tempTop;

		//	objects[i].setCoords();
		}

		$scope.factory.canvas.renderAll();
		$scope.factory.canvas.calcOffset();
		
		if(parseInt($scope.savingCanvasWidth) > parseInt($scope.savingCanvasHeight)) {
			console.log($scope.newMaterialChange.height_cm, $scope.newMaterialChange.width_cm);
			var pdf = new jsPDF('l','cm', [$scope.newMaterialChange.height_cm, $scope.newMaterialChange.width_cm]);
			pdf.addImage(imgData, 'JPEG', 0, 0, $scope.newMaterialChange.width_cm, $scope.newMaterialChange.height_cm);
			
		} else {
			console.log($scope.newMaterialChange.height_cm, $scope.newMaterialChange.width_cm);
			var pdf = new jsPDF('p','cm', [$scope.newMaterialChange.height_cm, $scope.newMaterialChange.width_cm]);
			pdf.addImage(imgData, 'JPEG', 0, 0, $scope.newMaterialChange.width_cm, $scope.newMaterialChange.height_cm);
			
		}

		var now = new Date().toISOString().slice(0,16);
		pdf.save("Wizad design " + now + ".pdf");
		
		$scope.showGrid = !previous_showgrid;
		$scope.toggleGrid();

		if ( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = false;
			$scope.togglePrintingLines();
		}
	 }


	 $scope.exportWholeDocPDF = async function() {

		$scope.imgDataToExportPDF = [];

		previous_showgrid = $scope.showGrid;
	 
		if( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = true;
			$scope.togglePrintingLines();
		}

		$scope.savingToDB();

		$scope.loading = true;
		$scope.waitingMessage = "Generando archivo PDF. Tarda aproximadamente 3 segundos por pagina. Por favor espere...";

		var params = { idtemplategroup_p : "" }
		
		params.idtemplategroup_p = $scope.template_group_id;
		$scope.savingCanvasWidth = $scope.factory.canvas.width;
		$scope.savingCanvasHeight = $scope.factory.canvas.height;

		const data = await generalService.GSlides(params);

		$scope.loading = true;
		
		async function processArray(data) {

			for (const slide of data) {

				$scope.loading = true;
				$scope.factory.canvas.clear();

				await $scope.loadSlide(slide);
				
				
				$scope.showGrid = true;
				$scope.toggleGrid();
				$scope.factory.canvas.deactivateAll().renderAll();
				$scope.factory.canvas.setZoom(1);
				$scope.savingCanvasWidth = $scope.factory.canvas.width;
				$scope.savingCanvasHeight = $scope.factory.canvas.height;
				fabric.devicePixelRatio = 1;
				$scope.factory.canvas.setDimensions({width: $scope.newMaterialChange.width, height: 
					parseInt($scope.newMaterialChange.height)});
					
				var objects =  $scope.factory.canvas.getObjects();
				
				for (var i in objects) {
					var scaleX = objects[i].scaleX;
					var scaleY = objects[i].scaleY;
					var left = objects[i].left;
					var top = objects[i].top;

					var tempScaleX = scaleX * $scope.newMaterialChange.width_multiplier;
					var tempScaleY = scaleY * $scope.newMaterialChange.height_multiplier;
					var tempLeft = left * $scope.newMaterialChange.width_multiplier;
					var tempTop = top * $scope.newMaterialChange.height_multiplier;

					objects[i].scaleX = tempScaleX;
					objects[i].scaleY = tempScaleY;
					objects[i].left = tempLeft;
					objects[i].top = tempTop;

				//	objects[i].setCoords();
				}

				$scope.factory.canvas.renderAll();
				$scope.factory.canvas.calcOffset();
						
				const imgData = await $scope.getImage();
				
				$scope.imgDataToExportPDF.push( imgData );
				
				$scope.factory.canvas.clear();
				$scope.factory.canvas.renderAll();
				
			}

		}

		await processArray(data);
		$scope.sendPDF();

		$scope.loadSlide(data[0]);
	
	}


	$scope.getImage = function() {
		return new Promise( resolve => {
			var img = $scope.factory.canvas.toDataURL({ format: 'png' });
			
			setTimeout(() => {
				resolve(img)
			}, 1000);
		});
	}

	$scope.loadSlide = function(slide) {
		return new Promise( resolve => {
			$scope.factory.canvas.loadFromJSON(slide.contents);	
			
			setTimeout(() => {
				$scope.factory.canvas.renderAll();
				resolve(true);
			}, 2000);
		});
	}

	 $scope.sendPDF = function() {

		$scope.pdf = null;
		var pageOrientation = 'p';
		var pageSize = [$scope.newMaterialChange.height_cm, $scope.newMaterialChange.width_cm];

		if(parseInt($scope.savingCanvasWidth) > parseInt($scope.savingCanvasHeight)) {
			pageOrientation = 'l';
		} 

		for(var i = 0; i < $scope.imgDataToExportPDF.length; i++) {

			if($scope.pdf === null) {
				$scope.pdf = new jsPDF(pageOrientation,'cm', pageSize);
			} else {
				$scope.pdf.addPage();
			}

			$scope.pdf.addImage($scope.imgDataToExportPDF[i], 'JPEG', 0, 0, $scope.newMaterialChange.width_cm, $scope.newMaterialChange.height_cm);
		}
		
		var now = new Date().toISOString().slice(0,16);
		$scope.pdf.save("Wizad design " + now + ".pdf");
		
		$scope.showGrid = !previous_showgrid;
		$scope.toggleGrid();

		if( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = false;
			$scope.togglePrintingLines();
		}

		$scope.loading = false;

		return;
	 }

	 $scope.addSlide = function() {

		if ($scope.currentUser.typenum == '3') {
		
			if($scope.design_group_id !== 0) {

				var temp_name = $scope.design_name;

				if( $scope.newMaterialChange.offline == 1 ) {
					$scope.showPrintingLines = true;
					$scope.togglePrintingLines();
				}

				$scope.savingToDB('design');

				reallyNew();

				$scope.design_name = temp_name;

				if( $scope.newMaterialChange.offline == 1 ) {
					$scope.showPrintingLines = false;
					$scope.togglePrintingLines();
				}

				$scope.savingToDB('design');
				
			} else {
				$scope.alertClass = "alert alert-danger";
				$scope.alertShow = true;
				$scope.message = "Primero debe guardar su diseño"; 
			}
		} else {

			if($scope.template_group_id !== 0) {

				var temp_name = $scope.template_name;

				if( $scope.newMaterialChange.offline == 1 ) {
					$scope.showPrintingLines = true;
					$scope.togglePrintingLines();
				}

				$scope.savingToDB('template');

				reallyNew();

				$scope.template_name = temp_name;

				if( $scope.newMaterialChange.offline == 1 ) {
					$scope.showPrintingLines = false;
					$scope.togglePrintingLines();
				}

				$scope.savingToDB('template');
				
			} else {
				$scope.alertClass = "alert alert-danger";
				$scope.alertShow = true;
				$scope.message = "Primero debe guardar como plantilla"; 
			}
		
		
		}
	 }

	 $scope.createThumbnail = function() {
		
		imgData = $scope.createPNG('', true);

		if($scope.template_saved_id !== 0) {
	
			var params = {
						idtemplate_p : "",
						img_data: ""
					}
			params.idtemplate_p = $scope.template_saved_id;
			params.img_data = imgData;

			generalService.SaveNewThumbnail(params)
				.then(function(data) {

					$scope.getThumbnails();
					
				}, function(error){
					
					alert('Error al guardar. Mensaje de error: ' + error);
					$scope.loading = false;
				})
		} 
	 }

	 $scope.createDesignThumbnail = function() {
		
		imgData = $scope.createPNG('', true);

		if($scope.design_saved_id !== 0) {
	
			var params = {
						idudesign_p : "",
						img_data: ""
					}
			params.idudesign_p = $scope.design_saved_id;
			params.img_data = imgData;

			generalService.DesignSaveNewThumbnail(params)
				.then(function(data) {

					$scope.getDesignThumbnails();
					
				}, function(error){
					
					alert('Error al guardar. Mensaje de error: ' + error);
					$scope.loading = false;
				})
		} 
	 }

	 $scope.exportPNG = function(name) {
		$scope.createPNG(name, false);
	 }
	 
	 $scope.createPNG = function(name, returnImageData) {

		previous_showgrid = $scope.showGrid;
		$scope.showGrid = true;
		$scope.toggleGrid();
		
		if ( $scope.newMaterialChange.offline == 1 ) {
				$scope.showPrintingLines = true;
				$scope.togglePrintingLines();
		}
		
        fabric.devicePixelRatio = 1;
				
		 if (returnImageData === false ) {
			$scope.factory.canvas.setDimensions(
				{
					width:  parseInt($scope.newMaterialChange.width), 
					height: parseInt($scope.newMaterialChange.height)
				});

			var objects =  $scope.factory.canvas.getObjects();
			
		 
				console.log("objects", objects);
				for (var i in objects) {
					var scaleX = objects[i].scaleX;
					var scaleY = objects[i].scaleY;
					var left = objects[i].left;
					var top = objects[i].top;

					var tempScaleX = scaleX * $scope.newMaterialChange.width_multiplier;
					var tempScaleY = scaleY * $scope.newMaterialChange.height_multiplier;
					var tempLeft = left * $scope.newMaterialChange.width_multiplier;
					var tempTop = top * $scope.newMaterialChange.height_multiplier;

					objects[i].scaleX = tempScaleX;
					objects[i].scaleY = tempScaleY;
					objects[i].left = tempLeft;
					objects[i].top = tempTop;

				//	objects[i].setCoords();
				}
			
		 } else {
			 var ratio = parseInt($scope.newMaterialChange.width) / parseInt($scope.newMaterialChange.height);

			 $scope.factory.canvas.setDimensions(
				{
					width:  parseInt(300), 
					height: parseInt(300 / ratio)
					
				});
			var objects =  $scope.factory.canvas.getObjects();
			
			
		 
				console.log("objects", objects);

				for (var i in objects) {
					var scaleX = objects[i].scaleX;
					var scaleY = objects[i].scaleY;
					var left = objects[i].left;
					var top = objects[i].top;

					var tempScaleX = scaleX * 0.25;
					var tempScaleY = scaleY * 0.25;
					var tempLeft = left * 0.25;
					var tempTop = top * 0.25;

					objects[i].scaleX = tempScaleX;
					objects[i].scaleY = tempScaleY;
					objects[i].left = tempLeft;
					objects[i].top = tempTop;

				//	objects[i].setCoords();
				}
			
		 }
		 
		$scope.factory.canvas.renderAll();
		$scope.factory.canvas.renderAll();
		$scope.factory.canvas.calcOffset();
		
		try
		{
			var imgData = $scope.factory.canvas.toDataURL({       format: 'png'   });
		}
		catch(err) {
			console.log(err);
			$scope.alertClass = "alert alert-danger";
			$scope.alertShow = true;
			$scope.message = "Error: al crear imagen"; 
		}
		
		//AFTER PROCESS RETURN TO NORMAL STATE
		$scope.factory.canvas.setDimensions(
				{
					width:  parseInt($scope.newMaterialChange.width_small), 
					height: parseInt($scope.newMaterialChange.height_small)
				});
		
		var objects =  $scope.factory.canvas.getObjects();

		if (returnImageData === false ) {
			
			
				for (var i in objects) {
					var scaleX = objects[i].scaleX;
					var scaleY = objects[i].scaleY;
					var left = objects[i].left;
					var top = objects[i].top;

					var tempScaleX = scaleX / $scope.newMaterialChange.width_multiplier;
					var tempScaleY = scaleY / $scope.newMaterialChange.height_multiplier;
					var tempLeft = left / $scope.newMaterialChange.width_multiplier;
					var tempTop = top / $scope.newMaterialChange.height_multiplier;

					objects[i].scaleX = tempScaleX;
					objects[i].scaleY = tempScaleY;
					objects[i].left = tempLeft;
					objects[i].top = tempTop;

			//		objects[i].setCoords();
				}
			
		} else {

			

				for (var i in objects) {
					var scaleX = objects[i].scaleX;
					var scaleY = objects[i].scaleY;
					var left = objects[i].left;
					var top = objects[i].top;

					var tempScaleX = scaleX / 0.25;
					var tempScaleY = scaleY / 0.25;
					var tempLeft = left / 0.25;
					var tempTop = top / 0.25;

					objects[i].scaleX = tempScaleX;
					objects[i].scaleY = tempScaleY;
					objects[i].left = tempLeft;
					objects[i].top = tempTop;

			//		objects[i].setCoords();
				}
			
		}

		$scope.factory.canvas.renderAll();
		$scope.factory.canvas.calcOffset();
		
		$scope.showGrid = !previous_showgrid;
		$scope.toggleGrid();

		if ( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = false;
			$scope.togglePrintingLines();
		}

		if (returnImageData ) {
			return imgData;
		} else {
			var now = new Date().toISOString().slice(0,16);
			download(imgData, "Wizad image " + now + ".png");
		}

	 }
	  // $scope.changeFormColor = function(pal){
			// var activeObject = $scope.factory.canvas.getActiveObject();
		
			// activeObject.setFill(pal.color);
			// $scope.factory.canvas.renderAll();
			// // activeObject.setColor(pal.color);
	  // }

	  $scope.getThumbnails = function() {

		generalService.GThumbnails({ idtemplategroup_p: $scope.template_group_id })
					.then(function(data) {
						$scope.thumbnails = data;
					})
	  
	  }

	  $scope.getDesignThumbnails = function() {

		generalService.GDesignThumbnails({ idudesigngroup_p: $scope.design_group_id })
					.then(function(data) {
						$scope.thumbnails = data;
					})
	  
	  }
	  
	  $scope.canvasIsTargeted = function(){
		  $scope.canvasTarget = true;
		  $scope.formSelected = false;
		  $scope.alertExpiredShow = false;
		  $scope.factory.canvas.deactivateAll().renderAll();
	  }
	  
	  
	  $scope.changeTextFont = function(font){
		  var activeObject = $scope.factory.canvas.getActiveObject();
		  activeObject.fontFamily = font.font;
		  $scope.factory.canvas.renderAll();
		  //console.log(font.font);
		  // var text = "Escribe tu texto..";
		  // var fontColor = $scope.paletteArray[0].color;
		  // var textSample = new fabric.IText(text, {
			  // left: fabric.util.getRandomInt(10, 100),
			  // top: fabric.util.getRandomInt(10, 200),
			  // fontFamily: font.font,
			  // angle: 0,
			  // fill: fontColor,
			  // scaleX: 0.5,
			  // scaleY: 0.5,
			  // fontWeight: '',
			  // hasRotatingPoint: true
			// });
		// $scope.factory.canvas.add(textSample);
		// $scope.factory.canvas.item(canvas.item.length - 1).hasRotatingPoint = true;
		// $scope.factory.canvas.setActiveObject(textSample);
		// $scope.factory.canvas.renderAll();
	  }

	  //on object cleared
	  $scope.$on("objectCleared", function () {
		$timeout(function () {
		  $scope.formSelected = false;
		  $scope.imageSelected = false;
		  $scope.isObjectSelected = false;
		  $scope.showFonts = false;
		}, 0);
	  });

	  //delete selected object
	  $scope.deleteSelectedObject = function () {
		
		var activeObject = $scope.factory.canvas.getActiveObject();
		$scope.factory.canvas.remove(activeObject);
	  };
	  
	  $scope.addLine = function(){
		 
			var random = $scope.getRandomSpan();
			random = "line" + random;
			
			lineColor = $scope.selectFillColor();
			
			var lineSample = new fabric.Line([50, 100, 200, 100], {
				left: 20,
				top: 20,
				stroke: lineColor,
				strokeWidth: 5,
				id: random
			});
			//console.log("addline");
			$scope.factory.canvas.add(lineSample);
			var rectSecondObj = $scope.findObjectWithPropertyValue(
				$scope.factory.canvas, 'name', 'overlayImage');
			$scope.factory.canvas.bringToFront(rectSecondObj);
		}
	  
	    $scope.findObjectWithPropertyValue = function (canvas, propertyName, propertyValue) {
				var condition = {};
				condition[propertyName] = propertyValue;
				//return _(canvas.getObjects()).where( condition ).first()  /* _.where function deprecated as of v4.0.0 in favor of _.filter function */
			return _(canvas.getObjects()).filter( condition ).first()
		}

		$scope.getRandomSpan = function(){			
			do{
				var value = Math.floor((Math.random()*300)+1);
			}while($scope.randomNumberArray.includes(value))				
			return value;
		}
		
		$scope.redrawRulers = function () {
			
			$scope.topRuler.clear();
			$scope.leftRuler.clear();
			$scope.topRuler.setBackgroundColor('#ddd');
			$scope.leftRuler.setBackgroundColor('#ddd');

			zoomLevel = $scope.factory.canvas.getZoom();
			
			for (i = 0; i < $scope.factory.canvas.width; i += (10 * zoomLevel)) {
				
				var topLine = new fabric.Line([i, 10, i, 20], {
				  stroke: 'black',
				  strokeWidth: 1,
				  selectable: false
				});
				
				$scope.topRuler.add(topLine);
			}
			
			for (i = 0; i < $scope.factory.canvas.height; i += (10 * zoomLevel)) {	
				var leftLine = new fabric.Line([10, i, 20, i], {
				  stroke: 'black',
				  strokeWidth: 1,
				  selectable: false
				});
				
				$scope.leftRuler.add(leftLine);
			}
		
			// Numbers for top ruler
			for (i = 0; i < $scope.factory.canvas.width;  i += (100 * zoomLevel)) {
				var text = new fabric.Text((Math.round(i / zoomLevel)).toString(), {
					left: i,
				  top: 0,
				  fontSize: 8,
				  selectable: false
				});
				$scope.topRuler.add(text);
			}
			
			//console.log($scope.factory.canvas.height);
			// Numbers for left ruler
			for (i = 0; i < $scope.factory.canvas.height;  i += (100 * zoomLevel)) {
				var text = new fabric.Text((Math.round(i / zoomLevel)).toString(), {
					top: i,
				  left: 0,
				  fontSize: 8,
				  selectable: false
				});
				$scope.leftRuler.add(text);
			}
		}
		
		$scope.zoomLevel = 0;
        $scope.zoomLevelMin = 0;
        $scope.zoomLevelMax = 5;
		
		$('#canvas_board').on('mousewheel', function(e) {
			
			var delta = e.originalEvent.wheelDelta;
            if (delta != 0) {
                var pointer = $scope.factory.canvas.getPointer(e, true);
                var point = new fabric.Point(pointer.x, pointer.y);
                if (delta > 0) {
                    $scope.zoomIn(point);
                } else if (delta < 0) {
                    $scope.zoomOut(point);
                }
            }

 			$scope.redrawRulers();
			e.originalEvent.returnValue = false;
	  	});
		
		$scope.zoomIn = function(point) {
            if ($scope.zoomLevel < $scope.zoomLevelMax) {
                $scope.zoomLevel++;
                $scope.factory.canvas.zoomToPoint(point, Math.pow(2, $scope.zoomLevel));
                $scope.keepPositionInBounds($scope.factory.canvas);
            }
        }
		
        $scope.zoomOut = function(point) {
            if ($scope.zoomLevel > $scope.zoomLevelMin) {
                $scope.zoomLevel--;
                $scope.factory.canvas.zoomToPoint(point, Math.pow(2, $scope.zoomLevel));
                $scope.keepPositionInBounds($scope.factory.canvas);
            }
        }
		
		$scope.clamp = function(value, min, max) {
            return Math.max(min, Math.min(value, max));
        }

        $scope.keepPositionInBounds = function() {
            var zoom = $scope.factory.canvas.getZoom();
            var xMin = (2 - zoom) * $scope.factory.canvas.getWidth() / 2;
            var xMax = zoom * $scope.factory.canvas.getWidth() / 2;
            var yMin = (2 - zoom) * $scope.factory.canvas.getHeight() / 2;
            var yMax = zoom * $scope.factory.canvas.getHeight() / 2;

            var point = new fabric.Point($scope.factory.canvas.getWidth() / 2, $scope.factory.canvas.getHeight() / 2);
            var center = fabric.util.transformPoint(point, $scope.factory.canvas.viewportTransform);

            var clampedCenterX = $scope.clamp(center.x, xMin, xMax);
            var clampedCenterY = $scope.clamp(center.y, yMin, yMax);

            var diffX = clampedCenterX - center.x;
            var diffY = clampedCenterY - center.y;

            if (diffX != 0 || diffY != 0) {
                $scope.factory.canvas.relativePan(new fabric.Point(diffX, diffY));
            }
        }
		
		$scope.addText = function (textParam) {
			 
			var random = $scope.getRandomSpan();
			random = "text" + random;
			var bkColor = $scope.factory.canvas.backgroundColor;
	
			var presetColor = 0;
			var fontColor = "#000000";
			var paletteSize = $scope.paletteArray.length;
			
			if (paletteSize == 1) {
				
				alert("ERROR: No se puede continuar.\nLa campaña solamente cuenta con un color definido, favor de reportarlo al usuario administrador");
				return;
			}
			
			// Algoritmo para seleccionar el color de letra
			if(bkColor === "" ) {
				
				// el fondo es transparente se busca uno diferente de blanco
				for(i = 0; i < paletteSize; i++) {
						
					if($scope.paletteArray[i].color != "#ffffff") {
					
						fontColor = $scope.paletteArray[i].color;
						break;
					}
				}
				
			} else {
				// el fondo tiene color, se busca uno diferente
				for(i = 0; i < paletteSize; i++) {
						
					if($scope.paletteArray[i].color != bkColor) {
					
						fontColor = $scope.paletteArray[i].color;
						break;
					}
				}
			} 

				
			var text = "";
			if(textParam === undefined) {
				text = "Escribe tu texto..";
			} else {
				text = textParam;
			}
			
			if(typeof $scope.fontsDropdown[0] == 'undefined') {
				
				alert("No se cargaron fuentes a la camapaña\nPor lo que no se puede agregar texto");
				return;
			}
			var fontFamily = $scope.fontsDropdown[0].name;
			var textSample = new fabric.Textbox(text, {
			  left: 0,
			  top: 0,
			  fontFamily: fontFamily,
			  fontSize: 12,
			  angle: 0,
			  fill: fontColor,
			  scaleX: 3,
			  scaleY: 3,
			  fontWeight: '',
			  hasRotatingPoint: true,
			  id : random
			});
			
			$scope.factory.canvas.add(textSample);
			//$scope.factory.canvas.item(canvas.item.length - 1).hasRotatingPoint = true;
			$scope.factory.canvas.setActiveObject(textSample);
			var rectSecondObj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'name', 'overlayImage');
			$scope.factory.canvas.bringToFront(rectSecondObj);
		};



		
	  //paint the canvas
	  $scope.paintBrush = function () {
		alert("Sorry :( not yet implemented...");
	  };

	  
	  
	  //reset the board
	  $scope.resetBoard = function () {
		var canvas = CanvasFactory.getCanvas();
		canvas.clear();
	  };
	  
	$scope.changeCanvasColor = function(pal){
		$scope.factory.canvas.backgroundColor=pal.color;
		$scope.factory.canvas.renderAll();
		//$scope.canvasTarget = false;
		// $scope.factory.canvas.renderTop();
	}
	
	$scope.addCircle = function(){
		
		var random = $scope.getRandomSpan();
		random = "circle" + random;
		
		fillColor = $scope.selectFillColor();	
		
		var circle=new fabric.Circle({
			top: 0,
			left: 0,
			radius: 99,
			fill: fillColor,
			id: random
		});
		$scope.factory.canvas.add(circle);
		var rectSecondObj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'name', 'overlayImage');
		$scope.factory.canvas.bringToFront(rectSecondObj);
	}
	
	$scope.addTriangle = function(){
		
		var random = $scope.getRandomSpan();
		random = "triangle" + random;
	
		fillColor = $scope.selectFillColor();
		
		var triangle=new fabric.Triangle({
			top: 0,
			left: 0,
			radius: 99,
			fill: fillColor,
			id: random
		});
		$scope.factory.canvas.add(triangle);
		var rectSecondObj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'name', 'overlayImage');
		$scope.factory.canvas.bringToFront(rectSecondObj);
	}


	$scope.selectFillColor = function() {

		var bkColor = $scope.factory.canvas.backgroundColor;
		var paletteSize = $scope.paletteArray.length;
				
		if (paletteSize == 1) {
			
			alert("ERROR: No se puede continuar.\nLa campaña solamente cuenta con un color definido, favor de reportarlo al usuario administrador");
			return;
		}


		// Algoritmo para seleccionar el color de letra
		if(bkColor === "" ) {
			
			// el fondo es transparente se busca uno diferente de blanco
			for(i = 0; i < paletteSize; i++) {
					
				if($scope.paletteArray[i].color != "#ffffff") {
				
					fillColor = $scope.paletteArray[i].color;
					break;
				}
			}
			
		} else {
			// el fondo tiene color, se busca uno diferente
			for(i = 0; i < paletteSize; i++) {
					
				if($scope.paletteArray[i].color != bkColor) {
				
					fillColor = $scope.paletteArray[i].color;
					break;
				}
			}
		}

		return fillColor;

	}
	
	$scope.addRectangle = function(){
		
		var random = $scope.getRandomSpan();
		random = "rect" + random;
		fillColor = $scope.selectFillColor();		
		
		var rectangle=new fabric.Rect({
			left: 0,
			top: 0,
			width: 100,
			height: 100,
			fill: fillColor,
			padding: 10,
			id:random
		});
		$scope.factory.canvas.add(rectangle);
		var rectSecondObj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'name', 'overlayImage');
		$scope.factory.canvas.bringToFront(rectSecondObj);
	}
	
	$scope.moveToFront = function(){
		var activeObject = $scope.factory.canvas.getActiveObject();
		$scope.factory.canvas.bringToFront(activeObject);
	}
	$scope.moveToBack = function(){
		var activeObject = $scope.factory.canvas.getActiveObject();
		$scope.factory.canvas.sendToBack(activeObject);
	}
	$scope.moveToBackward = function(){
		var activeObject = $scope.factory.canvas.getActiveObject();
		$scope.factory.canvas.sendBackwards(activeObject);
	}
	$scope.moveToForward = function(){
		var activeObject = $scope.factory.canvas.getActiveObject();
		$scope.factory.canvas.bringForward(activeObject);
	}
	$scope.saveCanvas = function(){
		
	}
	$scope.exportImg = function(){
		var objects = $scope.getCanvasObjects();
		if (objects.length !== 0) {
		  ngDialog.open({
			template: 'design/downloadDialog.html',
			closeByDocument: true,
			closeByEscape: true,
			scope: $scope
		  });
		} else {
		  alert("Nothing on sticker board!!");
		}
	}
	
	$scope.getCanvasObjects = function() {
		
		return $scope.factory.canvas.getObjects();
	}
	
	
	$scope.startCrop = function(){
		$scope.cropStarted = true;
		
		$scope.factory.canvas.remove($scope.el);

		if($scope.factory.canvas.getActiveObject())
		{
			$scope.object = $scope.factory.canvas.getActiveObject();
			
			if($scope.lastActive !== $scope.object) {
				//console.log('different object');
			} else {
				//console.log('same object');
			}
			
			if ($scope.lastActive && $scope.lastActive !== $scope.object) {
			//	$scope.lastActive.clipTo = null;
			}
		
			var random = $scope.getRandomSpan();
			random = "rect" + random;
			
			$scope.el = new fabric.Rect
			({
				fill: 'rgba(0,0,0,0.3)',
				originX: 'left',
				originY: 'top',
				stroke: '#ccc',
				strokeDashArray: [2, 2],
				opacity: 1,
				width: 1,
				height: 1,
				borderColor: '#36fd00',
				cornerColor: 'green',
				hasRotatingPoint:false,
				id: random
			});
			
			$scope.el.left				 = parseInt($scope.factory.canvas.getActiveObject().left);			
			$scope.el.top				 = parseInt($scope.factory.canvas.getActiveObject().top);
			$scope.el.width				 = parseInt($scope.factory.canvas.getActiveObject().width); //* $scope.factory.canvas.getActiveObject().scaleX;
			$scope.el.height			 = parseInt($scope.factory.canvas.getActiveObject().height);// * $scope.factory.canvas.getActiveObject().scaleY;
			$scope.el.scaleX			 = $scope.factory.canvas.getActiveObject().scaleX * 1;
			$scope.el.scaleY			 = $scope.factory.canvas.getActiveObject().scaleY * 1;

			$scope.selection_object_left = $scope.factory.canvas.getActiveObject().left;
			$scope.selection_object_top = $scope.factory.canvas.getActiveObject().top;
			
			$scope.factory.canvas.add($scope.el);
			$scope.factory.canvas.setActiveObject($scope.el);

			for(var i = 0; i < $("#layers li").size(); i++) {
				$scope.factory.canvas.item(i).selectable= false;
			}

		} else {
			alert("Seleccione un objeto");
		}
	}
		
	$scope.crop = function(){
		
		var left = $scope.el.left - $scope.object.left;
		var top = $scope.el.top - $scope.object.top;
		var scale_ratioX = $scope.el.scaleX / $scope.object.scaleX;
		var scale_ratioY = $scope.el.scaleY / $scope.object.scaleY;
		left *= 1;
		top *= 1;		
		
		var width  = $scope.el.width * 1;
		var height = $scope.el.height * 1;

		$scope.object.originX = 'left';
		$scope.object.originY = 'top';

		var rect_left;
		var rect_top;
		
		if(parseInt($scope.el.left) == parseInt($scope.object.left)) {
			rect_left = -$scope.object.width / 2;
		} else if ($scope.el.left < $scope.object.left) {
			rect_left = (((-$scope.object.width / 2) * $scope.object.scaleX ) - ($scope.object.left - $scope.el.left)) / $scope.object.scaleX;
		} else {
			
			rect_left = (((-$scope.object.width / 2) * $scope.object.scaleX )  - $scope.object.left + $scope.el.left ) / $scope.object.scaleX;
		}

		if(parseInt($scope.el.top) == parseInt($scope.object.top)) {
			rect_top = -$scope.object.height / 2;
		} else if ($scope.el.top < $scope.object.top) {
			rect_top = (((-$scope.object.height / 2) * $scope.object.scaleY ) - ($scope.object.top - $scope.el.top)) / $scope.object.scaleY;
		} else {
			rect_top = (((-$scope.object.height / 2) * $scope.object.scaleY )  - $scope.object.top + $scope.el.top )  / $scope.object.scaleY ;
		}
	
		var func = function(ctx) {

			//	ctx.rect( left, pos, w, h);
			/*
				w and h have to be adjusted according to scales of both objects
				si los lefts son iguales, se aplica el width del object / 2 
				si los lefts son diferentes, se aplica 
			*/

			ctx.rect( rect_left *1 , rect_top*1, 
				parseInt(width * scale_ratioX ), 
				parseInt(scale_ratioY * height));
			
		}

		$scope.clipToFunctionsValues.push(
			{
				'id': $scope.object.id,
				'left': $scope.el.left * 1,
				'top': $scope.el.top * 1,
				'width': $scope.el.width * 1,
				'height': $scope.el.height * 1,
				'scaleX': $scope.el.scaleX * 1,
				'scaleY': $scope.el.scaleY * 1
			}
		
		);
		
		$scope.object.clipTo = func;
		$scope.clipToFunctionsFcs.push({id: $scope.object.id, func: $scope.object.clipTo});
		
		for(var i=0; i < $("#layers li").size(); i++) {
			$scope.factory.canvas.item(i).selectable= true;
		}

		disabled = true;
	   
		$scope.factory.canvas.remove($scope.factory.canvas.getActiveObject());
		$scope.lastActive = $scope.object;
		$scope.factory.canvas.renderAll();
		$scope.cropStarted = false;
	}

	
		
	$scope.isDownloadable = function() {
		
		if($scope.CampaignSelected.autorization == 1) {
			
			return true;
		}
		
		return false;
		
	}
	

	$scope.savingToDB = async function(type = 'template') {
	
		$scope.loading = true;
		$scope.waitingMessage = "Guardando";
		
		$scope.oldshowGrid = $scope.showGrid;
		$scope.showGrid = true;
		$scope.toggleGrid();

		if ( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = true;
			$scope.togglePrintingLines();
		}

		if(type == 'template') {

			var params = {
					"name_p" : "",
					"idmaterial_p"	: "",
					"contents_p"	: "",
					"iduser_p"	: "",
					"idtemplategroup_p" : "",
					"idcampaign" : ""
				};
			
			params.name_p = $scope.template_name;
			params.idmaterial_p = $scope.material;
			params.contents_p = $scope.factory.canvas;
			params.iduser_p = $scope.currentUser.id_user;
			params.idtemplategroup_p = $scope.template_group_id;
			params.idcampaign_p = $scope.CampaignSelected.id_campaign;

			if($scope.template_saved_id === 0) {

				$scope.prepareClipToFunctions();
				
				generalService.NewTemplate(params)
				.then(function(data) {
					
					$scope.template_saved_id = data[0].id;
					$scope.template_group_id = data[0].template_group_id;
					
					$scope.fixClipToFunctions();
					$scope.loading = false;
					
					$scope.showGrid = !$scope.oldshowGrid;
					$scope.toggleGrid();

					// reload list of templates
					var params = {
						idcompany_p : "",
						idmaterial_p: "",
						idcampaign_p: ""
					}

					params.idcompany_p = $scope.currentUser.id_company;
					params.idmaterial_p = $scope.newMaterialChange.id_material ;
					params.idcampaign_p	= $scope.CampaignSelected.id_campaign;

					generalService.GTemplates(params)
					.then(function(data) {
						$scope.templates = data;
					});

					//if($scope.newMaterialChange.multipage == 1) {

						$scope.createThumbnail();
					//}
					
				}, function(error){
					
					alert('Error al guardar. Mensaje de error: ' + error);
					$scope.loading = false;
				})
			
			} else {
				params.idtemplate_p = $scope.template_saved_id;

				//if($scope.newMaterialChange.multipage == 1) {

					$scope.createThumbnail();
					
				//}
				
				$scope.prepareClipToFunctions();

				generalService.UTemplate(params)
				.then(function(data) {
						
					$scope.fixClipToFunctions();
					$scope.loading = false;
					
					$scope.showGrid = !$scope.oldshowGrid;
					$scope.toggleGrid();

					// reload list of templates
					var params = {
						idcompany_p : "",
						idmaterial_p: "",
						idcampaign_p: ""
					}

					params.idcompany_p = $scope.currentUser.id_company;
					params.idmaterial_p = $scope.newMaterialChange.id_material ;
					params.idcampaign_p	= $scope.CampaignSelected.id_campaign;

					generalService.GTemplates(params)
					.then(function(data) {
						$scope.templates = data;
					});

					
				}, function(error){
					
					alert('Error al guardar. Mensaje de error: ' + error);
					$scope.loading = false;
				})

			}
		} else if (type == 'design') {

			var params = {
					"name_p" : "",
					"idmaterial_p"	: "",
					"contents_p"	: "",
					"iduser_p"	: "",
					"idtemplategroup_p" : "",
					"idcampaign" : "",
					"idtemplate_p" : ""
				};
			
			params.name_p = $scope.design_name;
			params.idmaterial_p = $scope.material;
			params.contents_p = $scope.factory.canvas;
			params.iduser_p = $scope.currentUser.id_user;
			params.idtemplategroup_p = $scope.design_group_id;
			params.idcampaign_p = $scope.CampaignSelected.id_campaign;
			params.idtemplate_p = $scope.template_saved_id;

			if($scope.design_saved_id === 0) {

				$scope.prepareClipToFunctions();
				
				generalService.NewUDesign(params)
				.then(function(data) {
					
					$scope.design_saved_id = data[0].id;
					$scope.design_group_id = data[0].design_group_id;
					
					$scope.fixClipToFunctions();
					$scope.loading = false;
					
					$scope.showGrid = !$scope.oldshowGrid;
					$scope.toggleGrid();

					// reload list of designs
					var params = {
						idcompany_p : "",
						idmaterial_p: "",
						idcampaign_p: ""
					}

					params.idcompany_p = $scope.currentUser.id_company;
					params.idmaterial_p = $scope.newMaterialChange.id_material ;
					params.idcampaign_p	= $scope.CampaignSelected.id_campaign;

					generalService.GDesigns(params)
					.then(function(data) {
						$scope.designs = data;
					});

					//if($scope.newMaterialChange.multipage == 1) {

						$scope.createDesignThumbnail();
					//}
					
				}, function(error){
					
					alert('Error al guardar. Mensaje de error: ' + error);
					$scope.loading = false;
				})
			
			} else {
				params.idudesign_p = $scope.design_saved_id;

				//if($scope.newMaterialChange.multipage == 1) {

					$scope.createDesignThumbnail();
					
				//}
				
				$scope.prepareClipToFunctions();

				generalService.UUDesign(params)
				.then(function(data) {
						
					$scope.fixClipToFunctions();
					$scope.loading = false;
					
					$scope.showGrid = !$scope.oldshowGrid;
					$scope.toggleGrid();

					// reload list of designs
					var params = {
						idcompany_p : "",
						idmaterial_p: "",
						idcampaign_p: ""
					}

					params.idcompany_p = $scope.currentUser.id_company;
					params.idmaterial_p = $scope.newMaterialChange.id_material ;
					params.idcampaign_p	= $scope.CampaignSelected.id_campaign;

					generalService.GDesigns(params)
					.then(function(data) {
						$scope.designs = data;
					});

					
				}, function(error){
					
					alert('Error al guardar. Mensaje de error: ' + error);
					$scope.loading = false;
				})
			}
		}

		if ( $scope.newMaterialChange.offline == 1 ) {
			$scope.showPrintingLines = false;
			$scope.togglePrintingLines();
		}

	}
	/*
	$scope.saving = function() {
		$scope.loading = true;
		$scope.waitingMessage = "Guardando";
		
		$scope.oldshowGrid = $scope.showGrid;
		$scope.showGrid = true;
		$scope.toggleGrid();
		$scope.prepareClipToFunctions();
		
		generalService.SaveWizFile($scope.factory.canvas)
		.then(function(data) {
			
			var element = document.createElement('a');
			element.setAttribute('href', data);
			element.setAttribute('download', "archivo.wiz");
			element.style.display = 'none';
			$scope.fixClipToFunctions();
			document.body.appendChild(element);
			element.click();
			document.body.removeChild(element);
			$scope.loading = false;
			
			$scope.showGrid = !$scope.oldshowGrid;
			$scope.toggleGrid();
			
		}, function(error){
			
			alert('Error al guardar. Mensaje de error: ' + error);
			$scope.loading = false;
		})

	}*/
	
	/*
	$scope.opening = function() {
		
		$timeout(function(){
			$('#openWiz').trigger("click");
		}, 200);
		
	}*/
	
	$scope.prepareClipToFunctions = function() {
		
		for(i = 0; i < $scope.clipToFunctionsValues.length; i++) {
			
			objId = $scope.clipToFunctionsValues[i].id;
			obj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'id', objId);
			
			var str = JSON.stringify( $scope.clipToFunctionsValues[i] );
			obj.clipTo = str;
		}
		
	}
	
	$scope.fixClipToFunctions = function() {
		
		for(i = 0; i < $scope.clipToFunctionsFcs.length; i++) {
			
			objId = $scope.clipToFunctionsFcs[i].id;
			obj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'id', objId);
			obj.clipTo = $scope.clipToFunctionsFcs[i].func;
			
		}
	}
	
	$scope.removeClipToFunctions = function(data) {
		
		for(i = 0; i < data.objects.length; i++) {
						
			if( data.objects[i].clipTo && data.objects[i].clipTo !== "" ) {

				if(typeof data.objects[i].clipTo == 'object') {
					var props = data.objects[i].clipTo;
				} else {
					var props = JSON.parse(data.objects[i].clipTo);
				}
				
				
				clipToF = {id: props.id, 
						   func: data.objects[i].clipTo};
				
				$scope.clipToFunctions.push(clipToF);
				data.objects[i].clipTo = null;
				data.objects[i].id = props.id;
				
			}
			
		}
		return data;
	}
	
	$scope.restoreClipToFunctions = function() {
		
		for(i = 0; i < $scope.clipToFunctions.length; i++) {
			
			objId = $scope.clipToFunctions[i].id;
			obj = $scope.findObjectWithPropertyValue($scope.factory.canvas, 'id', objId);

			if(typeof $scope.clipToFunctions[i].func == 'object') {
				props = $scope.clipToFunctions[i].func;
			} else {
				props = JSON.parse($scope.clipToFunctions[i].func);
			}
			
			obj.clipTo = null;
			$scope.factory.canvas.setActiveObject(obj);
			$scope.startCrop();
			$scope.el.width = props.width;
			$scope.el.left = props.left;
			$scope.el.height = props.height;
			$scope.el.top = props.top;
			$scope.el.scaleX = props.scaleX;
			$scope.el.scaleY = props.scaleY;
			$scope.crop();
			
		}
		
	}
	
	/*
	$scope.loadingFileIntoCanvas = function(file) {
		$scope.loading = true;
		$scope.clipToFunctions = [];
		$scope.clipToFunctionsValues = [];
		$scope.clipToFunctionsFcs = [];
		$scope.waitingMessage = "Abriendo archivo";
		generalService.ReadWizFile(file)
		.then(function(data) {
			
			$scope.removeClipToFunctions(data);
			$scope.factory.canvas.clear();			
			$scope.factory.canvas.loadFromJSON(data);		
			
			$timeout( function(){
				$scope.restoreClipToFunctions();
				$scope.factory.canvas.renderAll();
				
			}, 1000 );
			$scope.loading = false;
			
		})
		
	}
	
	
	$scope.sendingFile = function() {
		
		var fdata = new FormData();
		jQuery.each(jQuery('#openWiz')[0].files, function(i, file) {
			fdata.append('wizFile', file);
		});
		
		generalService.UploadWizFile(fdata)
		.then(function(data) {
			
			if(typeof data.error == 'undefined') {
				$scope.alertClass = "alert alert-success";
				$scope.message = data.success.msg;
				$scope.alertShow = true;
				$scope.loadingFileIntoCanvas(data.success.file);
			} else {
				
				$scope.alertClass = "alert alert-danger";
				$scope.alertShow = true;
				$scope.message = 'Error al cargar archivo ' + data.error.msg;
				
			}
			$('#loadWiz')[0].reset();
			
			
		})
	}*/
	
	$scope.creatingNewFile = function() {
		var message = "Se perderán los cambios realizados hasta el momento. ¿Desea continuar?";
		var modalHtml = '<div class="modal-body">' + message + '</div>';
		modalHtml += '<div class="modal-footer"><button class="btn btn-primary" ng-click="ok()">Aceptar</button><button class="btn btn-warning" ng-click="cancel()">Cancelar</button></div>';

		var modalInstance = $modal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		modalInstance.result.then(function() {

			reallyNew();

			if ( $scope.newMaterialChange.offline == 1 ) {
				$scope.showPrintingLines = false;
				$scope.togglePrintingLines();
			}
			
		});
		
	}
	
	reallyNew = function(item) {
		var grid = $scope.showGrid;
		$scope.factory.canvas.clear();
		
		$scope.showGrid = !grid;
		$scope.toggleGrid();

		if($scope.currentUser.typenum == '2' || $scope.currentUser.typenum == '4') {
			$scope.template_saved_id = 0;
		}

		$scope.template_name = "";
		$scope.design_saved_id = 0;
		$scope.design_name = "";
	}
	
	var ModalInstanceCtrl = function($scope, $modalInstance) {
		$scope.ok = function() {
			$modalInstance.close();
		};

		$scope.cancel = function() {
			$modalInstance.dismiss('cancel');
		};
	}


	// liberia https://github.com/Templarian/ui.bootstrap.contextMenu
	$scope.slideOptions = [
          ['Borrar', function ($itemScope) {
				$scope.deleteSlide($itemScope.image.id);
          }],
          ['Duplicar', function ($itemScope) {
				$scope.duplicateSlide($itemScope.image.id);
          }],
		  ['Insertar', function ($itemScope) {
				$scope.insertSlide($itemScope.image.id);
          }],
		  ['Mover <<', function ($itemScope) {
				$scope.moveSlide($itemScope.image.id, 'left');
          }],
		  ['Mover >>', function ($itemScope) {
				$scope.moveSlide($itemScope.image.id, 'right');
          }]
      ];

	$scope.deleteSlide = function(template_id) {

		var message = "¿Desea borrar este elemento?";
		var modalHtml = '<div class="modal-body">' + message + '</div>';
		modalHtml += '<div class="modal-footer"><button class="btn btn-primary" ng-click="ok()">Aceptar</button><button class="btn btn-warning" ng-click="cancel()">Cancelar</button></div>';

		var modalInstance = $modal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		modalInstance.result.then(function() {

			//designer
			if ($scope.currentUser.typenum == '3') {

				var params = { idudesign_p : ""	}

				params.idudesign_p = template_id;
				
				generalService.DDesignSlide(params)
				.then(function(data) {
					$scope.getDesignThumbnails();

				})

			} else {

				var params = { idtemplate_p : "" }

				params.idtemplate_p = template_id;
				
				generalService.DSlide(params)
				.then(function(data) {
					$scope.getThumbnails();

				})
			}
			
			
		});
	}


	$scope.duplicateSlide = function(template_id) {
	
		//designer
		if ($scope.currentUser.typenum == '3') {
			var params = { idudesign_p : "" }

			params.idudesign_p = template_id;
			
			generalService.DuplicateDesignSlide(params)
			.then(function(data) {
				$scope.getDesignThumbnails();

			})
		} else {
			var params = { idtemplate_p : "" }

			params.idtemplate_p = template_id;
			
			generalService.DuplicateSlide(params)
			.then(function(data) {
				$scope.getThumbnails();

			})
		}
	}


	$scope.insertSlide = function(template_id) {
	
		//designer
		if ($scope.currentUser.typenum == '3') {
			var params = { idudesign_p : "" }

			params.idudesign_p = template_id;
			
			generalService.IDesignSlide(params)
			.then(function(data) {
				$scope.getDesignThumbnails();

			})
		} else {
			var params = { idtemplate_p : "" }

			params.idtemplate_p = template_id;
			
			generalService.ISlide(params)
			.then(function(data) {
				$scope.getThumbnails();

			})
		}
	}


	$scope.moveSlide = function (template_id, direction) {
		
		//designer
		if ($scope.currentUser.typenum == '3') {
			var params = { idudesign_p : "" }

			params.idudesign_p = template_id;
			params.direction_p = direction;
			
			generalService.MDesignSlide(params)
			.then(function(data) {
				$scope.getDesignThumbnails();

			})
		} else {
			var params = { idtemplate_p : "" }

			params.idtemplate_p = template_id;
			params.direction_p = direction;
			
			generalService.MSlide(params)
			.then(function(data) {
				$scope.getThumbnails();

			})
		}
	
	}
	
  });