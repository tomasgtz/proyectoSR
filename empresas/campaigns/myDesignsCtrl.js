'use strict';


angular.module('newApp')
  .controller('myDesignsCtrl', function ($scope, campaignService, userService, applicationService, pluginsService, $location, objCampaign, generalService) {

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
				generalService.openDesign({idudesign_p: img.id_design, idmaterial_p: img.id_material });
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
		return generalService.GDesignsThumbs({iduser_p: $scope.currentUser.id_user, page_p: $scope.page})
			.then(function(data) {				
				$scope.designsList = data;	
				
				for(var i in $scope.designsList){

					if(typeof $scope.designsList[i].id != 'undefined') {

						var pic = { 
							id_design: $scope.designsList[i].id,
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
		generalService.GDesignsThumbsCount({iduser_p: $scope.currentUser.id_user})
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
	
  });
