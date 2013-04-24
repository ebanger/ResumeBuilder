'use strict';

/* This is the controller */

rbuildermvc.controller('rbuilderCtrl', function rbuilderCtrl($scope, rbuilderStorage) {
	// do stuff
	var resumeList = $scope.resumeList = null;
	var resume = $scope.resume = null;

	$scope.getResumeList = function(userID){
		resumeList = rbuilderStorage.getResumeList(userID);
		$scope.resumeList = resumeList;
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