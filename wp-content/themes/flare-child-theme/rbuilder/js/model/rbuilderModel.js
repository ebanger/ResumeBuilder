// this is the model
'use strict';

/* Service to retrieve resumes from database */
rbuildermvc.factory('rbuilderStorage', function () {
    return {
        get: function() {

            var resume;

            $.ajax({
                type: "GET",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/getData.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/getData.php",
                async: false,

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

        getResumeList: function()
        {
            var resumeList;
            $.ajax({
                type: "GET",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/getResumeList.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/getResumeList.php",
                async: false,
                //data: {'userID': userID},
                success: function(data){
                    resumeList = jQuery.parseJSON(data);
                }
            });
            return resumeList;

        },

        put: function(resume)
        {
            $.ajax({
                type: "POST",
                //url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/putData.php",
                url: "http://dev1.arrowresumebuilder.com/wp-content/themes/flare-child-theme/rbuilder/js/model/putData.php",
                data: { 'resume': resume},
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
        }
     
    };
});


