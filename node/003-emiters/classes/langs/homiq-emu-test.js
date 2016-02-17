
module.exports = function(com,logger,callback) {
    
    return {
        'turnon': function(options) {
            return '#S'+options['address']+'.1';
        },
        'turnoff': function(options) {
            return '#S'+options['address']+'.0';
        },
        'data': function(data) {
            
        }
    }
    
}