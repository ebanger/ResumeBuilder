// this is the model
'use strict';

/* Service to retrieve resumes from database */
rbuildermvc.factory('rbuilderStorage', function () {
    return {
        get: function(currentUser) {

            var resume;

            $.ajax({
                type: "GET",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/getData.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/getData.php",
                async: false,
                data:{'currentUser':currentUser},
                success: function(data){
                    resume = jQuery.parseJSON(data);
                }
            });       
            return resume;
        },

        getResume: function(resumeID)
        {
            var resume;
            $.ajax({
                type: "GET",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/getResume.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/getResume.php",
                async: false,
                data: { 'resumeID': resumeID },
                success: function(data){
                    resume = jQuery.parseJSON(data);
                }
            });

            return resume;
        },

        getResumeList: function(currentUser)
        {
            var resumeList;
            $.ajax({
                type: "GET",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/getResumeList.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/getResumeList.php",
                async: false,
                data: {'currentUser': currentUser},
                success: function(data){
                    resumeList = jQuery.parseJSON(data);
                }
            });
            return resumeList;

        },

        put: function(currentUser, resume)
        {
            $.ajax({
                type: "POST",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/putData.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/putData.php",
                data: { 'currentUser': currentUser, 'resume': resume},
                async: false

            });
        },

        update: function(resume, resumeID)
        {
            $. ajax({
                type: "POST",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/updateData.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/updateData.php",
                data: { 'resume': resume, 'resumeID': resumeID },
                async: false
            });
        },

        deleteResume: function(resumeID)
        {
            $.ajax({
                type: "POST",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/deleteResume.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/deleteResume.php",
                data: { 'resumeID': resumeID },
                async: false
            });
        },

        getResumeId: function(currentUser)
        {
            var currentResumeId;
            $.ajax({
                type: "GET",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/getResumeId.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/getResumeId.php",
                async: false,
                success: function(data){
                    currentResumeId = data;
                }
            });
            return currentResumeId;
        },

        putResumeId: function(currentUser,resumeID)
        {
            $.ajax({
                type: "POST",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/putResumeId.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/putResumeId.php",
                data: {'currentUser': currentUser, 'resumeID': resumeID },
                async: false
            });
        }
     
    };
});


