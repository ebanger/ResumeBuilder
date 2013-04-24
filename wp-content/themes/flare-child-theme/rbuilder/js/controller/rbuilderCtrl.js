'use strict';

/* This is the controller */

rbuildermvc.controller('rbuilderCtrl', function rbuilderCtrl($scope, rbuilderStorage) {
	// do stuff
	var resumeList = [
        {
            "resumeID":"1",
            "resumeName": "Project Manager"
        },
        {
            "resumeID":"2",
            "resumeName": "Senior Developer"
        }
    ];

    $scope.resumeList = resumeList;
	var resume = $scope.resume = null;
	//var resumeList = $scope.resumeList = rbuilderStorage.getResumeList();

	$scope.deleteResume = function(resumeID){
		resumeList.splice(resumeID, 1);
		
	}

	$scope.saveResume = function(){
		resume = $scope.resume;
		console.log($scope.resume)
		rbuilderStorage.update(resume, 3);
	}

	$scope.getResume = function(resumeID){
	 	resume = rbuilderStorage.getResume(resumeID);
	 	$scope.resume = resume;
	}


	/* Phien: list of functions */
	$scope.addName = function() {

	}

	$scope.addSchool = function() {

	}

	$scope.addGPA = function() {

	}
});