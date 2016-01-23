var http = require('http');
var url = require('url');
var fs = require('fs');
var io = require('socket.io');
var net = require('net');
var ini = require('./ini');
var exec = require('child_process').exec;

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


var homiqConnect = homiqClient.connect(ini.port, ini.listen, function() {

    fs.readFile(__dirname + '/server.json', function(error, data){
        if (error){
            for (var i=0; i<10; i++) {
                lights[i]=0;
            }        }
        else {
            lights=JSON.parse(data);
        }
    });

    console.log('Connected to homiq');

});

homiqConnect.on('error',function(e) {
    console.log('Nie ma emulatora, odpal emu.js ;)');
    process.exit();
});



httpServer.listen(ini.http_port);
console.log('Listening on http://localhost:'+ini.http_port);





var listener = io.listen(httpServer);
listener.sockets.on('connection', function(httpSocket){
    httpClients.push(httpSocket);
    console.log('cześć kliencie');
   
    for (var i=0; i<10; i++) {
        if (lights[i]==1) httpSocket.emit('light', {light: i, val:1});
    }  
  
    
    httpSocket.on('light', function(data){
        var i=parseInt(data);
        var newvalue=1-lights[i];
        var msg='#S'+i+'.'+newvalue+'\r\n';
        homiqClient.write(msg);
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
            case 'A':
                var i=parseInt(line.substr(2,1));
                var newvalue=parseInt(line.substr(4,1));
                lights[i]=newvalue;
                
                for (var x in httpClients) {
                    httpClients[x].emit('light', {light: i, val:newvalue});
                }
                
                break;
        }
    }
});

function hastalavista(options, err) {
    if (options.cleanup) {
        fs.writeFileSync(__dirname + '/server.json',JSON.stringify(lights));
    }
    if (options.exit) process.exit();
}

process.on('exit',hastalavista.bind(null,{cleanup:true}));
process.on('SIGINT',hastalavista.bind(null,{exit:true,cleanup:true}));



var cmd='ssh -nNT -R '+ini.http_port+':localhost:'+ini.http_port+' '+ini.tunnel_to;
exec(cmd,function (error, stdout, stderr) {
    //console.log('stdout: ' + stdout);
    //console.log('stderr: ' + stderr);
    if (error !== null) {
        console.log('exec error: ' + error);
    }
});



