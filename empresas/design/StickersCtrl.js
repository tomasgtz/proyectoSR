'use strict';

/**
 * @ngdoc function
 * @name newappApp.controller:StickersCtrl
 * @description
 * # StickersCtrl
 * Controller of the newappApp
 */

angular.module('newApp')
  .controller('StickersCtrl', function ($scope, CanvasFactory, ngDialog, $timeout, ngDragDrop, ImagesFactory, UtilsFactory, AppSettings) {
	
		// ViewModel
	  var vm = this;

	  //Images are hardcoded [TODO] Move to Service Layer
	  vm.images = [{
		title: "2x1",
		src: "images/2x1cn.png",
		isUserUploaded: false
	  }, {
		title: "Cinepolis",
		src: "images/cinepolis.png",
		isUserUploaded: false
	  }, {
		title: "Fondo",
		src: "images/fondo.png",
		isUserUploaded: false
	  }, {
		title: "Palomitas",
		src: "images/palomitas.png",
		isUserUploaded: false
	  }, {
		title: "Personas",
		src: "images/personascin.png",
		isUserUploaded: false
	  }, {
		title: "Sala",
		src: "images/sala.png",
		isUserUploaded: false
	  }];

	  vm.usedSpace = UtilsFactory.localStorageSpace();

	  //Restore Stored Stickers
	  var stickersImgs = ImagesFactory.getRestoredStickerImages(vm.images);
	  vm.images = stickersImgs;

	  vm.uploaded = false;
	  vm.title = "";
	  $scope.previewImages = [];

	  //Drag & Drop Styles
	  vm.styles = {
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
	  vm.dragCallback = function (event) {
		console.log("Dragging", event);
	  };

	  vm.dropCallback = function (event) {
		var currDragElem = ngDragDrop.getCurrentDragElement();
		var imgSrc = currDragElem.attr("src");
		var object = {
		  src: imgSrc,
		  drop: true
		};
		vm.dropImage(object, event);
		console.log("Dropped", event);
	  };

	  vm.overCallback = function (event) {
		console.log("Drag Over", event);
	  };

	  //Delete Sticker
	  vm.deleteSticker = function (image) {
		var index = vm.images.indexOf(image);
		vm.images.splice(index, 1);
		ImagesFactory.deleteStickerImage(image); //delete from persisted localStorage
		UtilsFactory.resetUsedFileStorageSpace(); //Reset the $rootScope file storage for header data update
	  };

	  //callback function once file is uploaded
	  vm.onFileUpload = function () {
		vm.uploaded = true;
	  };

	  //submit sticker
	  vm.submitSticker = function (form) {
		var guid = UtilsFactory.guid();
		var sticker = {
		  src: $scope.previewImages[0],
		  title: vm.title,
		  isUserUploaded: true,
		  guid: guid
		};

		if (form.$valid && $scope.previewImages.length) {
		  //if form is valid perform action
		  form.$setPristine();
		  form.$setUntouched();
		  vm.uploaded = false;
		  vm.images.push(sticker);
		  ImagesFactory.saveStickerImage(sticker); //Persist Sticker Image
		  UtilsFactory.resetUsedFileStorageSpace(); //Reset the $rootScope file storage for header data update
		  $scope.previewImages = []; //Reset the images
		  ngDialog.close();
		}
	  };

	  //upload sticker
	  vm.uploadSticker = function () {
		$timeout(function () {
		  //Notify $digest cycle hack
		  $('#sticker_upload').trigger('click');
		}, 0);
	  };

	  //open upload dialog
	  vm.openUploadDialog = function () {
		if (vm.usedSpace >= 1) { //AppSettings.maxStorageSpace
		  //if storage exceed max app provided storage space then throw error
		  alert("Exceeded max provided localstorage space. Please empty to save.");
		} else {
		  //open dialog to save
		  ngDialog.open({
			template: 'stickerDialog.html',
			closeByDocument: false,
			closeByEscape: false,
			scope: $scope
		  });
		}
	  };

	  //Add Image to Canvas Area
	  vm.dropImage = function (obj, $event) {
		var canvas = CanvasFactory.getCanvas();
		var PosX = undefined,
			PosY = undefined;
		if (obj.drop === true) {
		  PosX = $event.clientX - $event.currentTarget.offsetLeft - 50;
		  PosY = $event.clientY - $event.currentTarget.offsetTop - 54; //offset height of header
		}
		fabric.Image.fromURL(obj.src, function (oImg) {
		  if (obj.drop === true) {
			oImg.set('left', PosX).set('top', PosY);
		  }
		  canvas.add(oImg);
		});
	  };

  });
