'use strict';

/* This is the controller */

rbuildermvc.controller('rbuilderCtrl', function rbuilderCtrl($scope, rbuilderStorage) {
	// do stuff
	var resume = $scope.resume = rbuilderStorage.get();

	$scope.getResumes = function(){}

	$scope.selectResume = function(){}

	$scope.saveResume = function(){}


	/* Phien: list of functions */
	$scope.addName = function() {

	}

	$scope.addSchool = function() {

	}

	$scope.addGPA = function() {

	}
});