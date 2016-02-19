var util = require('util');
var EventEmitter = require('events').EventEmitter;
var http = require('http');
var io = require('socket.io');

var Httpd = function(options,logger) {
    var self=this;
    
    var httpServer;
    var listener;
    var httpClients=[];

    return {
        connect: function() {
            httpServer = http.createServer(function(request, response) {
                self.emit('request',request,response);  
            });
            httpServer.listen(options.port);
            logger.log('Listening on http://localhost:'+options.port,'net');
            
            listener = io.listen(httpServer);
            listener.sockets.on('connection', function(httpSocket){
                httpClients.push(httpSocket);
                
                
            });

            
        },
        disconnect: function() {
            listener.close();
            httpServer.close();
        },
        on: function(event,fun) {
            self.on(event,fun);
        },
        
    }
}

util.inherits(Httpd, EventEmitter);
module.exports = Httpd;
