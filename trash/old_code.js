/* MED NOTES FUNCTIONALITY CODE */
app.directive('medNotes', function () {
    return {
        /*restrict: 'E',
        scope: {
            value: '='
        },*/
        template: '<ul index="{{$index}}"><li ng-repeat="note in med.notes" class="med-note-item"><i class="fa fa-file-text-o med-note-icon"></i><span class="med-note-remove"><a href="javascript:void(0);" ng-click="removeNote($index)" title="Remove note"><i class="fa fa-close"></i></a></span> <edit-in-place class="med-note" value="note.text"></edit-in-place></li></ul><ul class="hidden-print"><li><i class="fa fa-plus"></i> <a href="javascript:void(0);" ng-click="addNote($index)">Add note</a></li></ul>',
		link: function ($scope, element, attrs) {
			element.addClass('med-notes');

			$scope.addNote = function (index) {
				$scope.meds[index].notes.push({text:'New note'});
				//element.html('<edit-in-place value="' + $scope.med.indication + '"></edit-in-place>');
			};
			
			$scope.removeNote = function(index) {
				var med = element.find('ul').attr('index');
				if(confirm("Are you sure you want to remove this note?")){
					$scope.meds[med].notes.splice(index, 1);
				};
			};

		}
	};
});




/* ALLSCRIPTS IMPORT MEDS CODE */

	$scope.importMeds = function() {
		$http.get('http://localhost/medlist/api/allscripts.php')
		.success(function(data) {
			var medication = data[0].getmedicationsinfo;
			for (i = 0; i < medication.length; i++)
			{
				var med = medication[i];
				var ndc = med.NDC;
				var sig = med.Instructions;
				var indication = med.CategoryName;
				var notes = med.Comments;
				var addedby = med.SubmitByProviderName.toUpperCase();
				var dateadded = med.CreatedWhen;
				
				$scope.addMedAllscripts(ndc, sig, indication, notes, addedby, dateadded);
			}
		})
		.error(function(data) {
			alert('FAIL');
		});		
	}

/* ALLSCRIPTS ADD MEDS CODE - can probably lose this altogether */
	
		$scope.addMedAllscripts = function(ndc, sig, indication, notes, addedby, dateadded) {
		$http.get('http://rxnav.nlm.nih.gov/REST/rxcui.json?idtype=NDC&id=' + ndc)
		.success(function(data) {
			var rxcui = data.idGroup.rxnormId[0];
			$http.get('http://rxnav.nlm.nih.gov/REST/rxcui/' + rxcui + '.json?tty=SBD')
			.success(function(data) {
				var ingredient = data.idGroup.name;
				$scope.meds.push({
					name:ingredient,
					rxnorm_id:rxcui,
					sig:sig,
					indication:indication,
					notes:[],
					addedby:addedby,
					date_created:dateadded
				});
			});
		});
	}

/* MEDCHART USER CODE - underdeveloped */
	
	$scope.setMedchartUser = function(user) {
		$scope.user = user;
		for (var i = 0; i < $scope.meds.length; i++)
		{
			$scope.meds[i].created_by = user;
		}
		$('#med-user-identity').hide();
		$scope.saveMedchart();
	}

	$scope.editMedchart = function() {
		    $scope.providerNPIinput = prompt("Please enter your provider NPI:");

			if ($scope.providerNPIinput != null) {
				var NPI = $resource('http://www.bloomapi.com/api/search?limit=1&offset=0&key1=npi&op1=eq&value1=:npi',
					{npi:'@npi'}
				);
				
				NPI.get({npi:$scope.providerNPIinput}, function(r) {
					$scope.providerNPI = r.id;
					$scope.providerName = r.result.last_name;
					console.log($scope.providerName);
				});	
			}
	}

/* GOOGLE ADWORDS SIDEBAR STUFF */
				<div class="col-md-12 col-sm-6">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<ins class="adsbygoogle"
						 style="display:inline-block;width:300px;height:250px"
						 data-ad-client="ca-pub-7122202546588715"
						 data-ad-slot="3873659281"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
					<br><br>
				</div>
				<div class="col-md-12 col-sm-6">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<ins class="adsbygoogle"
						 style="display:inline-block;width:300px;height:600px"
						 data-ad-client="ca-pub-7122202546588715"
						 data-ad-slot="5350392486"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
			
				</div>
