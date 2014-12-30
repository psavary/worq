/**
 * Created by philou on 11.11.14.
 */

//@psa todo remove
    //angularstrap example
app.config(function($modalProvider) {
    angular.extend($modalProvider.defaults, {
        html: true
    });
});

app.config(function($dropdownProvider) {
    angular.extend($dropdownProvider.defaults, {
        html: true
    });
});


app.config(function($tooltipProvider) {
    angular.extend($tooltipProvider.defaults, {
        html: true
    });
});
//end angularstrapexample