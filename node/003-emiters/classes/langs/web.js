
module.exports = function(com,logger,callback) {
    
    return {
        'request': function(request,response) {
            
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