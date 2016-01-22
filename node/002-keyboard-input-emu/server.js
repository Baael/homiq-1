var http = require('http');
var url = require('url');
var fs = require('fs');
var io = require('socket.io');
var net = require('net');
var ini = require('./ini')


var lights=[];
var httpClients=[];

var httpServer = http.createServer(function(request, response){
    var path = url.parse(request.url).pathname;

    switch(path){
        case '/':
            fs.readFile(__dirname + '/index.html', function(error, data){
                if (error){
                    response.writeHead(404);
                    response.write("opps this doesn't exist - 404");
                    response.end();
                }
                else{
                    response.writeHead(200, {"Content-Type": "text/html"});
                    response.write(data, "utf8");
                    response.end();
                }
            });
            break;
        default:
            response.writeHead(404);
            response.write("opps this doesn't exist - 404");
            response.end();
            break;
    }
});

var homiqClient = new net.Socket();
homiqClient.connect(ini.port, ini.listen, function() {
	console.log('Connected to homiq');
    for (var i=0; i<10; i++) {
        lights[i]=0;
    }
});

httpServer.listen(ini.http_port);
console.log('Listening on http://localhost:'+ini.http_port);





var listener = io.listen(httpServer);
listener.sockets.on('connection', function(httpSocket){
    httpClients.push(httpSocket);
    console.log('cześć kliencie');
   
    
    setInterval(function() {
        httpSocket.emit('date', {'date': new Date()});
    }, 1000);
    
    httpSocket.on('light', function(data){
        var i=parseInt(data);
        var newvalue=1-lights[i];
        var msg='#S'+i+'.'+newvalue;
        homiqClient.write(msg);
        
        console.log(msg);
    });
    
    httpSocket.on('disconnect', function(){
        
        for (var x in httpClients) {
             if (httpClients[x]==httpSocket) {
                httpClients.splice(x,1);
             }
        }

        console.log('narka kliencie');
    });  
    
});

  

homiqClient.on('data', function(data) {
    var line=data.toString('ascii');
	console.log('Simon Homiq sais:', line.trim());
    
    
    if (line.substr(0,1)=='#') {
        
        switch (line.substr(1,1)) {
            case 'I':
                var i=parseInt(line.substr(2,1));
                var newvalue=1-lights[i];
                var msg='#S'+i+'.'+newvalue;
                homiqClient.write(msg+'\r\n');
                
                break;
        }
    }
});


