'use strict';

/**
 * @ngdoc overview
 * @name newappApp
 * @description
 * # newappApp
 *kk
 * Main module of the application.
 */
var MakeApp = angular
  .module('newApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ui.bootstrap',
	'colorpicker.module',
	'fileUpload',
	'ngDropzone',
	'ngDialog',
	'ngDragDrop',
	'ngFileSelect',
	'ngTableToCsv',
	'ng-file-input',
	'ui.bootstrap.contextMenu'
  ])
  .config(function ($routeProvider, ngDialogProvider) {
      $routeProvider
        .when('/', {
            templateUrl: 'dashboard/dashboard.html',
            controller: 'dashboardCtrl'
        })
        .when('/frontend', {
            templateUrl: 'frontend/frontend.html',
            controller: 'frontendCtrl'
        })
        .when('/charts', {
            templateUrl: 'charts/charts/charts.html',
            controller: 'chartsCtrl'
        })
        .when('/financial-charts', {
            templateUrl: 'charts/financialCharts/financialCharts.html',
            controller: 'financialChartsCtrl'
        })
        .when('/ui-animations', {
            templateUrl: 'uiElements/animations/animations.html',
            controller: 'animationsCtrl'
        })
        .when('/ui-buttons', {
            templateUrl: 'uiElements/Buttons/buttons.html',
            controller: 'buttonsCtrl'
        })
        .when('/ui-components', {
            templateUrl: 'uiElements/components/components.html',
            controller: 'componentsCtrl'
        })
        .when('/ui-helperClasses', {
            templateUrl: 'uiElements/helperClasses/helperClasses.html',
            controller: 'helperClassesCtrl'
        })
        .when('/ui-icons', {
            templateUrl: 'uiElements/icons/icons.html',
            controller: 'iconsCtrl'
        })
        .when('/ui-modals', {
            templateUrl: 'uiElements/modals/modals.html',
            controller: 'modalsCtrl'
        })
        .when('/ui-nestableList', {
            templateUrl: 'uiElements/nestableList/nestableList.html',
            controller: 'nestableListCtrl'
        })
        .when('/ui-notifications', {
            templateUrl: 'uiElements/notifications/notifications.html',
            controller: 'notificationsCtrl'
        })
        .when('/ui-portlets', {
            templateUrl: 'uiElements/portlets/portlets.html',
            controller: 'portletsCtrl'
        })
        .when('/ui-tabs', {
            templateUrl: 'uiElements/Tabs/tabs.html',
            controller: 'tabsCtrl'
        })
        .when('/ui-treeView', {
            templateUrl: 'uiElements/treeView/treeView.html',
            controller: 'treeViewCtrl'
        })
        .when('/ui-typography', {
            templateUrl: 'uiElements/typography/typography.html',
            controller: 'typographyCtrl'
        })
        .when('/email-templates', {
            templateUrl: 'mailbox/mailbox-templates.html',
            controller: 'mailboxTemplatesCtrl'
        })
          .when('/forms-elements', {
              templateUrl: 'forms/elements/elements.html',
              controller: 'elementsCtrl'
          })
             .when('/forms-validation', {
                 templateUrl: 'forms/validation/validation.html',
                 controller: 'elementsCtrl'
             })
            .when('/forms-plugins', {
                templateUrl: 'forms/plugins/plugins.html',
                controller: 'pluginsCtrl'
            })
          .when('/forms-wizard', {
              templateUrl: 'forms/wizard/wizard.html',
              controller: 'wizardCtrl'
          })
          .when('/forms-sliders', {
              templateUrl: 'forms/sliders/sliders.html',
              controller: 'slidersCtrl'
          })
          .when('/forms-editors', {
              templateUrl: 'forms/editors/editors.html',
              controller: 'editorsCtrl'
          })
            .when('/forms-input-masks', {
                templateUrl: 'forms/inputMasks/inputMasks.html',
                controller: 'inputMasksCtrl'
            })

           //medias
        .when('/medias-croping', {
            templateUrl: 'medias/croping/croping.html',
            controller: 'cropingCtrl'
        })
        .when('/medias-hover', {
            templateUrl: 'medias/hover/hover.html',
            controller: 'hoverCtrl'
        })
        .when('/medias-sortable', {
            templateUrl: 'medias/sortable/sortable.html',
            controller: 'sortableCtrl'
        })
          //pages
        .when('/pages-blank', {
            templateUrl: 'pages/blank/blank.html',
            controller: 'blankCtrl'
        })
        .when('/pages-contact', {
            templateUrl: 'pages/contact/contact.html',
            controller: 'contactCtrl'
        })
        .when('/pages-timeline', {
            templateUrl: 'pages/timeline/timeline.html',
            controller: 'timelineCtrl'
        })
             //ecommerce
        .when('/ecom-cart', {
            templateUrl: 'ecommerce/cart/cart.html',
            controller: 'cartCtrl'
        })
        .when('/ecom-invoice', {
            templateUrl: 'ecommerce/invoice/invoice.html',
            controller: 'invoiceCtrl'
        })
        .when('/ecom-pricingTable', {
            templateUrl: 'ecommerce/pricingTable/pricingTable.html',
            controller: 'pricingTableCtrl'
        })
          //extra
        .when('/extra-fullCalendar', {
            templateUrl: 'extra/fullCalendar/fullCalendar.html',
            controller: 'fullCalendarCtrl'
        })
        .when('/extra-google', {
            templateUrl: 'extra/google/google.html',
            controller: 'googleCtrl'
        })
        .when('/extra-slider', {
            templateUrl: 'extra/slider/slider.html',
            controller: 'sliderCtrl'
        })
        .when('/extra-vector', {
            templateUrl: 'extra/vector/vector.html',
            controller: 'vectorCtrl'
        })
        .when('/extra-widgets', {
            templateUrl: 'extra/widgets/widgets.html',
            controller: 'widgetsCtrl'
        })
          //tables
        .when('/tables-dynamic', {
            templateUrl: 'tables/dynamic/dynamic.html',
            controller: 'dynamicCtrl'
        })
        .when('/tables-editable', {
            templateUrl: 'tables/editable/editable.html',
            controller: 'editableCtrl'
        })
        .when('/tables-filter', {
            templateUrl: 'tables/filter/filter.html',
            controller: 'filterCtrl'
        })
        .when('/tables-styling', {
            templateUrl: 'tables/styling/styling.html',
            controller: 'stylingCtrl'
        })
          //user
        .when('/user-profile', {
            templateUrl: 'user/profile/profile.html',
            controller: 'profileCtrl'
        })
        .when('/user-sessionTimeout', {
            templateUrl: 'user/sessionTimeout/sessionTimeout.html',
            controller: 'sessionTimeoutCtrl'
        })
          //layout
        .when('/layout-api', {
            templateUrl: 'layout/api.html',
            controller: 'apiCtrl'
        })
		// Campa���a
		.when('/new-campaign', {
            templateUrl: 'nueva_campa���a/nueva_campa���a.html',
            controller: 'nvaCampa�naCtrl'
        })
		.when('/new-user', {
            templateUrl: 'user/newUser.html',
            controller: 'newUserCtrl'
        })
		.when('/campana', {
			templateUrl: 'user/nuevacampana.html',
            controller: 'CampaniaCtrl'
        })
		.when('/identity', {
            templateUrl: 'user/profile/identity.html',
            controller: 'identityCtrl'
        })
		.when('/mycampaigns', {
            templateUrl: 'campaigns/listing.html',
            controller: 'myCampaignsCtrl'
        })
		.when('/mydesigns', {
            templateUrl: 'campaigns/mydesigns.html',
            controller: 'myDesignsCtrl'
        })
		.when('/edit-campaign', {
            templateUrl: 'campaigns/seeCampaign.html',
            controller: 'seeCampaignCtrl'
        })
		.when('/design-campaign', {
            templateUrl: 'campaigns/designerCampaigns.html',
            controller: 'designerCampaignsCtrl'
        })
		.when('/campaign-materials', {
            templateUrl: 'campaigns/campaignMaterials.html',
            controller: 'campaignMaterialsCtrl'
        })
		.when('/designer-mode', {
            templateUrl: 'design/header.html',
            controller: 'HeaderCtrl as header'
        })
		.when('/canvas', {
            templateUrl: 'design/canvas.html',
            controller: 'CanvasCtrl as canvas'
        })
		.when('/stickers', {
            templateUrl: 'design/stickers.html',
            controller: 'StickersCtrl as stickers'
        })
		.when('/photos', {
            templateUrl: 'design/photos.html',
            controller: 'PhotosCtrl as photos'
        })
		.when('/historic', {
            templateUrl: 'user/historial.html',
            controller: 'HistoryCtrl'
        })
		.when('/suggestion-box', {
            templateUrl: 'user/suggestion.html',
            controller: 'SuggestionCtrl'
        })
		.when('/new-company', {
            templateUrl: 'user/newcompany.html',
            controller: 'NewCompanyCtrl'
        })
		.when('/free-campaign', {
            templateUrl: 'campaigns/freeCampaign.html',
            controller: 'freeCampaignCtrl'
        })
		.when('/subscription', {
            templateUrl: 'user/subscription.html',
            controller: 'SubscriptionCtrl'
        })
		.when('/free-materials', {
            templateUrl: 'admin/freeMaterials.html',
            controller: 'freeMaterialsCtrl'
        })
        .otherwise({
            redirectTo: '/'
        });
		
		 ngDialogProvider.setDefaults({
			className: 'ngdialog-theme-default',
			plain: false,
			showClose: true,
			closeByDocument: true,
			closeByEscape: true,
			appendTo: false
		  });
  });


// Route State Load Spinner(used on page or content load)
MakeApp.directive('ngSpinnerLoader', ['$rootScope',
    function($rootScope) {
        return {
            link: function(scope, element, attrs) {
                // by defult hide the spinner bar
                element.addClass('hide'); // hide spinner bar by default
                // display the spinner bar whenever the route changes(the content part started loading)
                $rootScope.$on('$routeChangeStart', function() {
                    element.removeClass('hide'); // show spinner bar
                });
                // hide the spinner bar on rounte change success(after the content loaded)
                $rootScope.$on('$routeChangeSuccess', function() {
                    setTimeout(function(){
                        element.addClass('hide'); // hide spinner bar
                    },500);
                    $("html, body").animate({
                        scrollTop: 0
                    }, 500);   
                });
            }
        };
    }
])