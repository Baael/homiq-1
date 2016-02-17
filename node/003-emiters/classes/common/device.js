var util = require('util');
var EventEmitter = require('events').EventEmitter;


var Device = function(protocol,language,options,logger) {
    var self=this;
    
    var Protocol = require(__dirname+'/../protocols/'+protocol);
    var Translator = require(__dirname+'/../langs/'+language);
    
    
    var com=new Protocol(options,logger);
    var trans=new Translator(com,logger,function(type,data){
        self.emit(type,data);
    });
    
    com.on('data',function(data) {
        trans.data(data);
    });
    
    //com.send('#S3.1.35');
    //com.send('#S2.0.36');
    trans.turnon({address:4});
    
    
    return {
        diconnect: function () {
            com.disconnect();
        },
        
        connect: function () {
            com.connect();
        },
        
        on: function(event,fun) {
            self.on(event,fun);
        },
        
        
    }
}

util.inherits(Device, EventEmitter);
module.exports = Device;
