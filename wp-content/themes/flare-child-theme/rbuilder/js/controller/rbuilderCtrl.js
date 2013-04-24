'use strict';

/* This is the controller */

rbuildermvc.controller('rbuilderCtrl', function rbuilderCtrl($scope, rbuilderStorage) {
	// do stuff
	var resumeList = $scope.resumeList = {"resumes":[{"resumeID":"1","resumeName":"Java Developer","dateModified":"2013-23-4"},{"resumeID":"2","resumeName":"Pizza Maker","dateModified":"2010-22-6"},{"resumeID":"3","resumeName":"Astronaut","dateModified":"2011-14-1"},{"resumeID":"4","resumeName":"Linux Administrator","dateModified":"2013-01-12"}]};
	var resume = $scope.resume = rbuilderStorage.getResume(2);;

	$scope.getResumeList = function(userID){
		resumeList = rbuilderStorage.getResumeList(userID);
		$scope.resumeList = resumeList;
		console.log(resumeList);
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