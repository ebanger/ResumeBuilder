// this is the model
'use strict';

/* Service to retrieve resumes from database */
rbuildermvc.factory('rbuilderStorage', function () {
    return {
        get: function() {
            return {   
                name: 'John',
                userID: 1,
                resumeID: 1,
                street: '123 Street St.',
                education: [
                    {
                        educationID: '1', 
                        schoolName: 'ASU',
                        gpa: 3.2,
                        include: 'false',
                        position: -1
                    },
                    {
                        educationID: '2',
                        schoolName: 'UofA',
                        gpa: 2.0,
                        include: 'false',
                        position: -1
                    }
                ],
                employment: [
                    {
                        employmentID: '12',
                        companyName: 'Pizza Hut',
                        jobTitle: 'Assistant Manager',
                        beginDate: '2008-01-02',
                        include: 'false',
                        position: -1
                    },
                    {
                        employmentID: '13',
                        companyName: 'Boeing',
                        jobTitle: 'Engineer',
                        beginDate: '2009-03-05',
                        include: 'false',
                        position: -1
                    }
                ]
            };
        }
    };
});