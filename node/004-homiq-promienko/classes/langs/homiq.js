var attempts=5;
var attempt_delay=3;

var pos_cmd=0;
var pos_val=1;
var pos_src=2;
var pos_dst=3;
var pos_pkt=4;
var pos_top=5;
var pos_crc=6;




module.exports = function(com,logger,callback) {
    var counter=0;
    var sendQueue=[];
    var sendSemaphore=false;
    var buf='';
    
    var crc = function (cmd) {
        var str=cmd[pos_cmd]+cmd[pos_val]+cmd[pos_src]+cmd[pos_dst]+cmd[pos_pkt]+cmd[pos_top];
        var c=0;
        for (var i=0; i<str.length; i++) {

            var ord=str.charCodeAt(i);
            var bit_counter = 8;
            
            while (bit_counter > 0 ) {
                
                var feedback_bit = (c ^ ord) & 0x01;
                if ( feedback_bit == 0x01 ) {
                    c = c ^ 0x18;
                }
                c = (c >> 1) & 0x7F;
                if (feedback_bit == 0x01 ) {
                    c = c | 0x80;
                }
                ord = ord >> 1;
                bit_counter--;

            }             
        }
        return c;
    }
    
    var send = function(str,delay) {
        now=Date.now()/1000;
        
        if (needack==null) needack=false;
        
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
                
            var msg=sendQueue[i].str;
            var res=com.send(msg+"\r\n");
            if (!res) sendQueue[i].when=now+10;
            sendQueue[i].count++;
            sendQueue[i].sent=now;
            
            logger.log('Sending: '+msg,'frame');
        }
        
        for (var i=0; i<sendQueue.length; i++) {
            
            if ( now-sendQueue[i].sent<attempt_delay) continue;
            
            if ( sendQueue[i].count>=attempts ) {
                sendQueue.splice(i,1);
            }
             
        }
        
        
        
        sendSemaphore=false;
        if (sendQueue.length>0) setTimeout(send,1000);
        
    }
    
    var sendline = function (line,delay) {
        if (delay==null) delay=0;
        var cmd='<;'+line.join(';')+';>';
        send(cmd,delay,line[pos_top]=='s');
    }
    
    var linein = function (line) {
        
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
            buf+=data.trim();
            
            while (buf.indexOf(';>')>0) {
                var begin=buf.indexOf('<;');
                var end=buf.indexOf(';>');
                
                logger.log('Received: '+buf.substr(begin,end-begin+2),'frame');
                var line=buf.substr(begin+2,end-begin-2).split(';');
                buf=buf.substr(end+2);
                if (line[pos_top]=='s') {
                    var ack=line.slice(0);
                    ack[pos_top]='a';
                    ack[pos_dst]=line[pos_src];
                    ack[pos_src]=line[pos_dst];
                    ack[pos_crc]=crc(ack);
                    var cmd='<;'+ack.join(';')+';>';
                    logger.log('Sending: '+cmd,'frame');
                    com.send(cmd+"\r\n");
                }
                linein(line);
            }
            
            return;
            
            
            
            
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
                logger.log('Signal from input '+adr,'emu');
                callback('input',{address: adr});
                
            } else {
                logger.log('Unknown input data: '+data,'error');
            }
            
        }
    }
    
}