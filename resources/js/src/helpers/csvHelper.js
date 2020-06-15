
//var csv is the CSV file with headers
function csvToObject(csv) {
    var lines=csv.data.split("\n");
   
    var result = [];
   
    var headers=lines[0].split(",");
        
    for(var i=1;i<lines.length;i++){
   
        var obj = {};
        var currentline=lines[i].split(",");
   
        for(var j=0;j<headers.length;j++){
            obj[headers[j]] = currentline[j];
        }
        
        obj.team_id = csv.teamId;
        
        result.push(obj);
   
    }

    return result
}

module.exports = csvToObject;