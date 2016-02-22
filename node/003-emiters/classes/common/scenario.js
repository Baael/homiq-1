var util = require('util');
var EventEmitter = require('events').EventEmitter;

var condition=require('./condition');

var Scenario=function(logger) {
    var self=this;
    var db;
    
    var scenariosQueue=[];
    var scenariosSemaphore=false;
    
    var runscenarios=function() {
        if (scenariosQueue.length==0) return;
        if (scenariosSemaphore) return;
        
        scenariosSemaphore=true;
        
        for (var i=0;i<scenariosQueue.length;i++) {
            if (scenariosQueue[i].when<=Date.now()) {
                
                var pass=true;
                
                if (typeof(scenariosQueue[i].scenario.conditions)=='object') {
                    for (var j=0; j<scenariosQueue[i].scenario.conditions.length; j++) {
                        pass*=condition(db,scenariosQueue[i].scenario.conditions[j]);
                        if (!pass) break;
                    }                    
                }
                
                if (pass) {
                    logger.log(scenariosQueue[i].scenario.name,'scenario');
                    for(var j=0;j<scenariosQueue[i].scenario.actions.length;j++) {
                        
                        self.emit(scenariosQueue[i].scenario.actions[j].device,
                                  scenariosQueue[i].scenario.actions[j].device,
                                  scenariosQueue[i].scenario.actions[j]);
                    }
                }
                
                scenariosQueue.splice(i,1);
                scenariosSemaphore=false;
                setTimeout(runscenarios,1);
                return;
            }
        }
        
        scenariosSemaphore=false;
        setTimeout(runscenarios,1000);
    }
    
    
    
    return {
        setdb: function(setdb) {
            db=setdb;
        },
        
        on: function(event,fun) {
            self.on(event,fun);
        },
        
        run: function(scenario,delay) {
            if (delay==null) delay=0;
            
            /*
             *check if scenario is object and has delay defined
             */
            if (typeof(scenario)=='object' && typeof(scenario.scenario)=='string') {
                if (typeof(scenario.delay)!='undefined') {
                    delay+=parseFloat(scenario.delay);
                }
                scenario=scenario.scenario;
            }
            
            /*
             *get database for specified scenario id
             */
            scenario=db.scenarios.get(scenario);
            if (typeof(scenario)!='object') return;
            
            /*
             *queue scenario
             */
            scenariosQueue.push({
                when: Date.now()+delay,
                scenario: scenario
            });
            
            /*
             *run queue
             */
            runscenarios();
            
            /*
             *run subscenarios
             */
            if (typeof(scenario.scenarios)=='object' ) {
                for (var i=0;i<scenario.scenarios.length;i++) {
                    run(scenario.scenarios[i],delay)
                }
            }
            
        }
    }
    
}

util.inherits(Scenario, EventEmitter);

module.exports=Scenario;