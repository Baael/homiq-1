var fs = require('fs');

var Structure = require('./classes/common/structure');
var Logger = require('./classes/common/logger');
var Device = require('./classes/common/device');
var Model = require('./classes/common/model');

var logger = new Logger('./logs');
var structure = new Structure(__dirname + '/conf/structure.json',logger);
var outputs = new Model(__dirname + '/conf/outputs.json',['device','address'],logger);
var inputs = new Model(__dirname + '/conf/inputs.json',['device','address'],logger);


var structureData;
var devices={};

process.on('SIGHUP',function () {
    var data=structure.get();
    if (typeof(data)=='object') {
        structureData=data;
        inputs.init();
        outputs.init();
        for(var i=0; i<structureData.devices.length; i++) {
            var id=structureData.devices[i].id;
            if (typeof(devices[id])!='undefined') {
                devices[id].disconnect();
            }
            logger.log('Initializing '+structureData.devices[i].name,'init');
            devices[id] = new Device(structureData.devices[i].protocol,structureData.devices[i].language,structureData.devices[i].com,logger);
            devices[id].connect();
        }
    }   
});
process.kill(process.pid, 'SIGHUP');
fs.writeFile(__dirname+'/homiq.pid',process.pid);

setTimeout(function() {}, 100)


