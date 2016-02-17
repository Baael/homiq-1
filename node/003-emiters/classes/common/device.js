var util = require('util');
var EventEmitter = require('events').EventEmitter;


var Device = function(protocol,language,options,logger) {
    var Protocol = require(__dirname+'/../protocols/'+protocol);
    var Translator = require(__dirname+'/../langs/'+language);
    
    
    var com=new Protocol(options,logger);
    var trans=new Translator(com,logger,function(data){
        
    });
    
    com.on('data',function(data) {
        trans.data(data);
    });
    
    com.send('#S3.1');
    com.send('#S2.0');
    
    
    return {
        diconnect: function () {
            com.disconnect();
        },
        
        connect: function () {
            com.connect();
        }
        
        
    }
}

util.inherits(Device, EventEmitter);
module.exports = Device;
