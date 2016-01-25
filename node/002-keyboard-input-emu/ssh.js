var exec = require('child_process').exec;

module.exports = {
    tunnel:function (userhost,localport,remoteport) {
        
        var milliseconds = (new Date).getTime();
        
        var cmd='ssh -nNT -R '+remoteport+':localhost:'+localport+' '+userhost;
        console.log('Trying to establish ssh tunnel:',cmd);
        
        exec(cmd,function (error, stdout, stderr) {
            
            var delay=(new Date).getTime() - milliseconds;
            var startInSeconds=delay<10000?300:1;
            
            setTimeout(function(){
                module.exports.tunnel(userhost,localport,remoteport);
            },1000*startInSeconds);
            
            console.log('stderr:',stderr.trim());
        
            
            
            /*
            console.log('stdout: ' + stdout);
            if (error !== null) {
                console.log('exec error: ' + error);
            }
            */
        });    
    }
}