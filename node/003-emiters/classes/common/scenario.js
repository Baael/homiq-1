

var Scenario=function(logger) {
    var db;
    
    
    return {
        setdb: function(setdb) {
            db=setdb;
        },
        
        run: function(scenario) {
            var delay=0;
            
            if (typeof(scenario)=='object' && typeof(scenario.scenario)!='undefined') {
                
            }
            console.log(scenario,delay);
        }
    }
    
}

module.exports=Scenario;