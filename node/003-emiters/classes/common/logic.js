

var Logic = function(logger)
{
    var db;
    
    return {
        setdb: function (setdb) {
            db=setdb;        
        },
        
        action: function(device,type,data) {
            switch (type) {
                case 'output':
                    data.device=device;
                    db.outputs.set(data);
                    break;
                    
            }
        }
    }
    
}

module.exports=Logic;