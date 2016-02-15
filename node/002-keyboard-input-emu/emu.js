var net = require('net');
var keypress = require('keypress');
var ini = require('./ini')


keypress(process.stdin);

var lastSocket;

var homiq = net.createServer(function(socket) {
	
    lastSocket=socket;
	socket.setMaxListeners(0);
	
    socket.write('Witaj dupku\r\n');
    
    socket.on('data',function(data){
        var line=data.toString('ascii').trim();
        console.log('Request:',line);
        
        if (line.substr(0,2)=='#S') {
            var msg='#A'+line.substr(2,3)+'\r\n';
            socket.write(msg);
            console.log('Reply:',msg.trim());
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
		lastSocket.write('#I'+k+"\n");
	}
	
	if (key && key.ctrl && key.name == 'c') {
		console.log('bye');
		process.exit();
	}
});  

console.log('Tu Homiq EMULATOR, klawisze od 1 do 0 do dyspozycji');
