angular.module('medchartApp', ['ui.bootstrap', 'ngResource', 'ngRoute'])
// BEGIN ROUTING CONFIG
.config(function($routeProvider) {
	$routeProvider.when('/', {
		templateUrl: 'template/medchart/chart.html'
	});
/*	.when('/chart', {
		templateUrl: 'template/medchart/chart.html',
		controller: 'MedchartController',
	})
	.when('/chart/:medlistId', {
		templateUrl: 'template/medchart/chart.html',
		controller: 'MedchartController',
	});
*/
})
// END ROUTING CONFIG

// BEGIN SERVICES
.factory('RxNormDataService', ['$http', function($http) {
	return {
		query: function() {
			return $http.get('data/meds.json', {cache: true});
		}
	}
}])

.factory('MedchartService', ['$resource', function($resource) {
	return $resource('/medlist/api/medcharts/:id',
			{id:'@id'},
			{
				update: { method:'PUT' },
				save: { method:'POST', params: { expand: 'meds' }}
			}
	)}
])

.factory('MedService', ['$resource', function($resource) {
	return $resource('/medlist/api/meds/:id',
			{id:'@id'},
			{
				update: { method:'PUT' }
			}
	)}
])

.factory('ProviderService', ['$resource', function($resource) {
	return $resource('http://www.bloomapi.com/api/search?limit=1&offset=0&key1=npi&op1=eq&value1=:npi',
		{npi:'@npi'}
	)}
])	
// END SERVICES

// BEGIN MEDCHART CONTROLLER
.controller('MedchartController', ['$scope', 'RxNormDataService', 'MedchartService', 'MedService', 'ProviderService', function($scope, RxNormDataService, MedchartService, MedService, ProviderService) {	 
	$scope.medchart = [];
	
	$scope.meds = [
	{
	"name": "Simvastatin 10 MG Oral Tablet [Zocor]",
	"rxnorm_id": "104490",
	"sig": "Take one tablet by mouth in the evening",
	"indication": "cholesterol",
	"created_by": "PATIENT",
	"date_created": "2015/1/2 09:30:05"
	},
	{
	"name": "Lisinopril 2.5 MG Oral Tablet [Zestril]",
	"rxnorm_id": "104375",
	"sig": "",
	"indication": "high blood pressure",
	"created_by": "PATIENT",
	"date_created": "2015/1/2 09:40:55"
	}];
	
	$scope.sortMedsBy = '';
	
	$scope.viewMedsAs = 'patient';
	
	$scope.deletedMeds = [];
	
	$scope.user = 'PATIENT';
	
	$scope.status = 'editing';

	// Load all RxNorm data from local JSON file into rxnormMeds variable
	RxNormDataService.query()
		.then(function(res) {
			$scope.rxnormMeds = res.data;
		});
	
	ProviderService.get({npi:'1861733537'}, function(res) {
		$scope.providerNPI = res.id;
		$scope.providerName = res.result.last_name;
		console.log($scope.providerName);
	});	

	// BEGIN MEDCHART FUNCTIONS
	$scope.updateMedchart = function() {
		// If medchartId is not already established, make a new medchart and save the id to $scope
		// else return updated medchart
		if ($scope.medchartId) {
			result = MedchartService.update({id:$scope.medchartId});
		} else {
			result = MedchartService.save({}, function(res) {
				$scope.medchartId = res.id;
				$scope.medchart = res;
			});
		}
		
		return result;
	}

	$scope.saveMedchart = function() {
		if ($scope.meds.length > 0) {
			$scope.status = 'saving';
				
			return $scope.updateMedchart()
			.$promise.then(function(res) {
				console.log(res);
				return $scope.updateMeds();
			}).then(function(res) {
				$scope.status = 'saved';
				console.log(res);
			}, function(error) {
				console.log(error);
			});
		} else {
			alert('You need to have at least one medication to save a Med Chart.');
		}
	}
	
	$scope.loadMedchart = function() {
		$scope.status = 'loading';
		if ($scope.medchartIdInput != null) {
			
			MedchartService.get({id:$scope.medchartIdInput}, function(m) {
				$scope.medchartId = m.id;
				$scope.medchart = m;
				$scope.meds = m.meds;
				$scope.medchartIdInput = '';
				$scope.status = 'editing';
			});	
		}
	}

	$scope.newMedchart = function() {
		$('#med-start').hide();
		$('#med-toolbar').show();
		$('#med-typeahead').show();
		
		$scope.meds = [];
		$scope.medchartId = null;
		$scope.deletedMeds = [];
		$scope.status = 'creating';
		//if (!$scope.user) { $scope.user = 'USER'; } 
	}
	
	$scope.printMedchart = function() {
		if ( $scope.meds.length < 1 ) {
			alert( "It doesn't look like you have anything to print!");
		} else {
			var content = {};
			content.content = [];
			content.styles  = {};

			// Make Header
			var header = {
				table: {
					style: 'tableExample',
					widths: [ 100, 225, 100, 50 ],
					headerRows: 2,
					body: [
						[{ rowSpan: 2, text: 'Chart My Meds', style: 'title' }, { text: 'Last Updated: ', style: 'tableHeader'}, { rowSpan: 2, text: 'ID: ' + $scope.medchartId, style: 'id' }, {rowSpan: 2, text: ''}],
						[ '',{ text: 'Updated By: ', style: 'tableHeader'}, '', '' ]
					]
				},
				layout: {
					hLineWidth: function(i, node) {
							return (i === 0 || i === node.table.body.length) ? 1 : 1;
					},
					vLineWidth: function(i, node) {
							return (i === 0 || i === node.table.widths.length) ? 1 : 1;
					},
					hLineColor: function(i, node) {
							return (i === 0 || i === node.table.body.length) ? 'gray' : 'gray';
					},
					vLineColor: function(i, node) {
							return (i === 0 || i === node.table.widths.length) ? 'gray' : 'gray';
					},
					// paddingLeft: function(i, node) { return 4; },
					// paddingRight: function(i, node) { return 4; },
					// paddingTop: function(i, node) { return 2; },
					// paddingBottom: function(i, node) { return 2; }
				}        
			};
			content.content.push(header);

			for ( var m = 0; m < $scope.meds.length; m++){
				var med = { text: $scope.meds[m].name, style: "medtitle" };
				var sig = { text: $scope.meds[m].sig, style: "sig" };

				if ($scope.meds[m].indication) {
					sig.text += ' for ' + $scope.meds[m].indication;
				}

				content.content.push(med);
				content.content.push(sig);
				
				/*
				var medNotes = 
				  {
					ul: [
					  $scope.meds[m].sig,
					  $scope.meds[m].indication,
					  $scope.meds[m].notes
					]
				  };        
				
				content.content.push(medNotes)
				*/
			}

			var styles = {
				title: {
					fontSize: 14,
					bold: true
				},
				id: {
					fontSize: 16,
					alignment: 'middle',
					paddingTop: 10
				},
				header: {
					fontSize: 18,
					bold: true,
					margin: [0, 0, 0, 10]
				},
				medtitle: {
					fontSize: 20,
					bold: true,
					margin: [0, 10, 0, 5]
				},
				sig: {
					fontSize: 14,
					margin: [0, 10, 0, 5]
				},
				tableExample: {
					margin: [0, 5, 0, 15],
					vLineWidth: 1,
					hLineWidth: 1,
					vLineColor: 'grey'
				},
				tableHeader: {
					bold: true,
					fontSize: 11,
					color: 'black'
				}    
			};
			content.styles = styles;

			var docDefinition = content;
			pdfMake.createPdf(docDefinition).open();
		}
	}
	// END MEDCHART FUNCTIONS
	
	// BEGIN MED FUNCTIONS
  	$scope.addMed = function() {
		d = new Date();
		month = d.getMonth() + 1;
		day = d.getDate();
		year = d.getFullYear();
		hour = d.getHours();
		minute = d.getMinutes();
		second = d.getSeconds();
		
		now = year + '/' + month + '/' + day + ' ' + hour + ':' + minute + ':' + second;
			
		$scope.meds.unshift({
			name:$scope.medInput.name,
			rxnorm_id:$scope.medInput.rxcui,
			sig:'',
			indication:'',
			created_by: $scope.user,
			date_created: now,
		});
		
		$scope.medInput = [];
	}
	
	$scope.removeMed = function(index) {
		if(confirm("Are you sure you want to remove this medication?")){
			$scope.deletedMeds.push($scope.meds[index]);

			$scope.meds.splice(index, 1);
		};
	};
	
	$scope.updateMeds = function() {
		result = [];
		
		// Loop through each medication and save it to database using medchartId
		for (var i = 0; i < $scope.meds.length; i++)
		{
			$scope.meds[i]['medchart_id'] = $scope.medchartId;
			
			// New meds should not have an id
			if ($scope.meds[i].id) {
				result.push(MedService.update({id:$scope.meds[i].id}, $scope.meds[i]));
			} else {
				result.push(MedService.save({}, $scope.meds[i], function(res) {
					$scope.meds[i]['id'] = res.id;
				}));
			}
		}
		
		// Loop through all deleted medications and delete from database 
		for (var i = 0; i < $scope.deletedMeds.length; i++)
		{
			result.push(MedService.delete({id:$scope.deletedMeds[i].id}));
			$scope.deletedMeds = [];
		}
		
		return result;
	}

	$scope.sortMeds = function(field) {
		$scope.sortMedsBy = field;
		$scope.meds.sort($scope.sortBy(field, true, function(a){return a.toUpperCase()}));
	}

	$scope.sortBy = function(field, reverse, primer) {
		var key = primer ? 
        function(x) {return primer(x[field])} : 
        function(x) {return x[field]};

        reverse = [-1, 1][+!!reverse];

        return function (a, b) {
            return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
        }
	}

	$scope.viewMeds = function(view) {
		$scope.viewMedsAs = view;
	}
	
	$scope.getIndicationList = function() {
		var indications = [];
		for (var m = 0; m < $scope.meds.length; m++) {
			var inArray = false;
			for (var i = 0; i < indications.length; i++) {
				if (indications[i] == $scope.meds[m].indication) inArray = true;
			}
			if (!inArray && $scope.meds[m].indication != '') indications.push($scope.meds[m].indication);
		}
		return indications.sort();
	}
	// END MED FUNCTIONS	
}])
// END MEDCHART CONTROLLER

// BEGIN DIRECTIVES
.directive('medItem', [function () {
    return {
        restrict: 'AE',
        templateUrl: 'template/medchart/meditem.html',
	};
}])

.directive('focusMe', function($timeout) {
	return {
		link: function($scope, $element, $attrs) {
			$scope.$watch($attrs.focusMe, function(value) {
				if(value === true) {
					$timeout(function() {
						$element[0].focus();
					});
				}
			});
		}
	};
})

.directive('editInPlace', [function () {
    return {
        restrict: 'E',
        scope: {
            value: '=',
			defaultText: '='
        },
        templateUrl: 'template/editinplace/editinplace.html',
        link: function ($scope, $element, $attrs) {
            $scope.editing = false;
			
            $scope.edit = function () {
				$scope.editing = true;
            };

            $scope.done = function () {
                $scope.editing = false;
            };
        }
    };
}]);
// END DIRECTIVES