var net = require('net');
var keypress = require('keypress');
var ini = require('./ini')


keypress(process.stdin);

var lastSocket;

var homiq = net.createServer(function(socket) {
	
    lastSocket=socket;
    
    socket.write('Hej dupku\r\n');
    
    socket.on('data',function(data){
        var line=data.toString('ascii').trim();
        console.log(line);
        
        if (line.substr(0,2)=='#S') {
            var msg='#A'+line.substr(2)+'\r\n';
            socket.write(msg);
            console.log('Odpowiedź:',msg.trim());
        }
        
    });
    
    socket.on('end' , function () {
        lastSocket=null;
    });
    
});

process.setMaxListeners(0);

homiq.listen(ini.port, ini.listen);






process.stdin.setRawMode(true);
process.stdin.resume();

    process.stdin.on('keypress', function (ch, key) {
        
        var k=parseInt(ch);
        if (!isNaN(k) && lastSocket!=null) {
            lastSocket.write('#I'+k);
            lastSocket.pipe(lastSocket);
        }
        
        if (key && key.ctrl && key.name == 'c') {
            console.log('bye');
            process.exit();
        }
    });  

