// this is the model
'use strict';

/* Service to retrieve resumes from database */
rbuildermvc.factory('rbuilderStorage', function () {
    return {
        get: function() {

            var resume;

            $.ajax({
                type: "GET",
                url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/getData.php",
                async: false,

                success: function(data){
                    resume = jQuery.parseJSON(data);

                }
                });        
            
            /*
            $.ajax({
                type: "POST",
                url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/putData.php",
                data: { 'resume': resume},
                async: false

            });
            */

            return resume;
        },

        put: function(resume)
        {
            $.ajax({
                type: "POST",
                url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/putData.php",
                data: { 'resume': resume},
                async: false

            });
        },

        update: function(resume, resumeID)
        {
            $. ajax({
                type: "POST",
                url: "http://localhost/ResumeBuilder/wp-content/themes/flare-child-theme/rbuilder/js/model/updateData.php",
                data: { 'resume': resume, 'resumeID': resumeID }.
                async: false
            });
        }
     
    };
});


