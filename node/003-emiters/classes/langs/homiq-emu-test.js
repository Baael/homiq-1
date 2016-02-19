var attempts=5;
var attempt_delay=3;


module.exports = function(com,logger,callback) {
    var counter=0;
    var sendQueue=[];
    var sendSemaphore=false;
    
    var send = function(str,delay) {
        now=Date.now()/1000;
        
        if (str!=null) {
            sendQueue.push({str: str, sent: 0, count: 0, when:now+parseFloat(delay)});
        }
        
        if (sendSemaphore) {
            setTimeout(send,10);
            return;
        }
        
        sendSemaphore=true;
        
        for (var i=0; i<sendQueue.length; i++) {
            if ( sendQueue[i].when>now) continue;
            if ( now-sendQueue[i].sent<attempt_delay) continue;
            if ( sendQueue[i].count>=attempts) continue;
                
            var msg=sendQueue[i].str+'.'+(++counter);
            var res=com.send(msg);
            if (!res) sendQueue[i].when=now+10;
            sendQueue[i].count++;
            sendQueue[i].sent=now;
            
            logger.log('Sending: '+msg,'frame');
        }
        
        for (var i=0; i<sendQueue.length; i++) {
            if ( now-sendQueue[i].sent<attempt_delay) continue;
            if ( sendQueue[i].count>=attempts) {
                sendQueue.splice(i,1);
            }
        }
        
        
        sendSemaphore=false;
        if (sendQueue.length>0) setTimeout(send,1000);
        
    }
    
    
    return {
        'turnon': function(options) {
            var cmd='#S'+options['address']+'.1';
            var delay = typeof(options['delay'])=='undefined'?0:options['delay'];
            send(cmd,delay);
            
        },
        'turnoff': function(options) {
            var cmd='#S'+options['address']+'.0';
            var delay = typeof(options['delay'])=='undefined'?0:options['delay'];
            send(cmd,delay);
        },
        'data': function(data) {
            logger.log('Received: '+data,'frame');
            
            if (data.substr(0,2)=='#A') {
                var adr=data.substr(2,1);
                var val=data.substr(4,1);
                
                for (var i=0;i<sendQueue.length; i++) {
                    if (sendQueue[i].str=='#S'+adr+'.'+val && sendQueue[i].sent>0) {
                        sendQueue[i].count=attempts;
                        break;
                    }
                }
                var opt={address:adr,state:val,logicalstate:val==1?'on':'off'};
                callback('output',opt);
                
            } else if (data.substr(0,2)=='#I') {
                var adr=data.substr(2,1);
                callback('input',{address: adr});
                
            } else {
                logger.log('Unknown input data: '+data,'error');
            }
            
        }
    }
    
}