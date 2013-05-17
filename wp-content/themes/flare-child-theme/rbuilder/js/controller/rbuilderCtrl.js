'use strict';

/* This is the controller */

rbuildermvc.controller('rbuilderCtrl', function rbuilderCtrl($scope, rbuilderStorage) {
	// do stuff
	//var resumeList = $scope.resumeList = {"resumes":[{"resumeID":"1","resumeName":"Java Developer","dateModified":"2013-23-4"},{"resumeID":"2","resumeName":"Pizza Maker","dateModified":"2010-22-6"},{"resumeID":"3","resumeName":"Astronaut","dateModified":"2011-14-1"},{"resumeID":"4","resumeName":"Linux Administrator","dateModified":"2013-01-12"}]};
	var currentUser = $scope.currentUser;
	
	var currentResumeId = $scope.currentResumeId;
	var resumeList = $scope.resumeList; //= rbuilderStorage.getResumeList();
	var resume = $scope.resume; //=rbuilderStorage.getResume(currentResumeId);


	$scope.init = function(user){
		$scope.currentUser = user;
		currentUser = user;
		console.log(currentUser);
		currentResumeId = rbuilderStorage.getResumeId(currentUser);
		resumeList = $scope.resumeList = rbuilderStorage.getResumeList(currentUser);
		var currentResumeIdNum = parseInt(currentResumeId, 10);
		resume = $scope.resume = rbuilderStorage.getResume(currentResumeIdNum);
	}

	$scope.generateResume = function(){
		$scope.resume = rbuilderStorage.get(currentUser);
		resume = $scope.resume;
		rbuilderStorage.put(currentUser, resume);
	}

	$scope.getResumeList = function(currentUser){
		resumeList = rbuilderStorage.getResumeList(currentUser);
		$scope.resumeList = resumeList;
		console.log(resumeList);
	}

	$scope.saveResume = function(){
		resume = $scope.resume;
		console.log(resume);
		rbuilderStorage.update(resume, parseInt(resume.currentResumeId, 10));
	}

	$scope.getResume = function(index){
		currentResumeId = parseInt(index, 10);
		//currentResumeId = currentResumeId - 1;
	 	resume = rbuilderStorage.getResume(currentResumeId, 10);
	 	$scope.resume = resume;
	 	//window.location.href = "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/index.html";
		console.log(resume);
	}

	$scope.deleteResume = function(index) {
		if(confirm("Are you sure you want to delete this resume?")){
			var resumeToDelete = parseInt(index, 10);
			rbuilderStorage.deleteResume(parseInt(resumeList.resumes[resumeToDelete].resumeID, 10));
			resumeList = $scope.resumeList = rbuilderStorage.getResumeList();
		}
	}
});