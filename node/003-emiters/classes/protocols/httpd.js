var util = require('util');
var EventEmitter = require('events').EventEmitter;
var http = require('http');
var io = require('socket.io');
var os = require('os');

var Httpd = function(options,logger) {
    var self=this;
    
    var httpServer;
    var listener;
    var httpClients=[];
    var ips=[];
    
    var ifaces = os.networkInterfaces();
    
    Object.keys(ifaces).forEach(function (ifname) {
      var alias = 0;
    
      ifaces[ifname].forEach(function (iface) {
        if ('IPv4' !== iface.family || iface.internal !== false) {
          return;
        }
        ips.push(iface.address);
        
      });
    });
    
    

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
                httpSocket.emit('web', {ips: ips, port:options.port});       
                self.emit('connection',httpSocket);
                
                
                httpSocket.on('disconnect', function() {                    
                    for (var x in httpClients) {
                         if (httpClients[x]==httpSocket) {
                            httpClients.splice(x,1);
                         }
                    }
                });
                
                httpSocket.on('input', function(data){
                    self.emit('data',data);
                });
            });

            
        },
        disconnect: function() {
            listener.close();
            httpServer.close();
        },
        on: function(event,fun) {
            self.on(event,fun);
        },

        initstate: function(socket,db) {
            self.emit('initstate',socket,db);
        },
        
        notify: function(type,data) {
            self.emit('notify',httpClients,type,data);
    
        }
        

    }
}

util.inherits(Httpd, EventEmitter);
module.exports = Httpd;
