var http = require('http');
var url = require('url');
var fs = require('fs');
var io = require('socket.io');

    var server = http.createServer(function(request, response){
        var path = url.parse(request.url).pathname;

        switch(path){
            case '/':
                response.writeHead(200, {'Content-Type': 'text/html'});
                response.write('<a href="socket.html">Socket</a>');
                response.end();
                break;
            case '/socket.html':
                fs.readFile(__dirname + path, function(error, data){
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

    server.listen(8001);
    console.log('Listening on port 8001: http://localhost:8001');
    
    //io.listen(server);
    
    var listener = io.listen(server);
    listener.sockets.on('connection', function(socket){
        socket.emit('message', {'message': 'hello my lovely client'});
        
        setInterval(function() {
            socket.emit('date', {'date': new Date()});
        }, 1000);
        
        socket.on('client_data', function(data){
            process.stdout.write(data.letter);
        });
        
    });