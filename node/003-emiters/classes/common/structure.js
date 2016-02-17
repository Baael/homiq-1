var fs = require('fs');

module.exports = function (conf,logger) {
    var config_file=conf;
    
    return {
        get: function() {
            try {
                
                data=fs.readFileSync(config_file);
            } catch(e) {
                logger.log('File not found: '+config_file);
                process.exit();
            }
            
            
            
            try {
                return JSON.parse(data);
            } catch (e) {
                logger.log('Structure parse error: '+e);
                return null;
            }            
            
        }
    }
}




