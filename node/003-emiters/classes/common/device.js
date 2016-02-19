var util = require('util');
var EventEmitter = require('events').EventEmitter;


var Device = function(protocol,language,options,logger) {
    var self=this;
    
    var Protocol = require(__dirname+'/../protocols/'+protocol);
    var Translator = require(__dirname+'/../langs/'+language);
    
    
    var com=new Protocol(options,logger);
    var trans=new Translator(com,logger,function(type,data) {
        logger.log("Device notification "+type,'emiter');
        self.emit('data',type,data);
    });
    
    com.on('data',function(data) {
        trans.data(data);
    });
    
    com.on('request',function(request,response) {
        trans.request(request,response);
    });
  
    
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
        
        command: function(data) {
            if (typeof(data.command)=='string') {
                if (typeof(trans[data.command])=='function') trans[data.command](data);
            }
        }
    }
}

util.inherits(Device, EventEmitter);
module.exports = Device;
