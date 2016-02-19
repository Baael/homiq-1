var fs = require('fs');

var Structure = require('./classes/common/structure');
var Logger = require('./classes/common/logger');
var Device = require('./classes/common/device');
var Logic = require('./classes/common/logic');
var Scenario = require('./classes/common/scenario');


var logger = new Logger('./logs');
var structure = new Structure(__dirname + '/conf/structure.json',logger);
var scenario = new Scenario(logger);
var logic = new Logic(scenario,logger);

var structureData;
var devices={};

/*
 * overall init may be initiated by signal HUP
 * therefore afterward we push (kill) the HUP signal to ourselves
 */

process.on('SIGHUP',function () {
    var data=structure.get();
    if (typeof(data)=='object') {
        structureData=data;
        
        scenario.setdb(structure.db);
        logic.setdb(structure.db);
        
        for(var i=0; i<structureData.devices.length; i++) {
            var id=structureData.devices[i].id;
            if (typeof(devices[id])!='undefined') {
                devices[id].disconnect();
            }
            logger.log('Initializing '+structureData.devices[i].name,'init');
            devices[id] = new Device(structureData.devices[i].protocol,structureData.devices[i].language,structureData.devices[i].com,logger);
            devices[id].connect();
            devices[id].on('data',function(type,data){
                logic.action(id,type,data);
            });
            scenario.on(id,function(d) {
                devices[id].command(d);
            });
        }
    }   
});

process.kill(process.pid, 'SIGHUP');
fs.writeFile(__dirname+'/homiq.pid',process.pid);

/*
 * wait before everything starts
 */
setTimeout(function() {}, 1000);

