/**
 * Welcome to Pebble.js!
 *
 * This is where you write your app.
 */

var UI = require('ui');
var ajax = require('ajax');

//splash
var card = new UI.Card({
  title:'abema.tv (unofficial)',
  subtitle:'Downloading Timetable'
});
card.show();

var programs = function(data){
  var items = [];
  for(var i = 0; i < data.length; i++){
    items.push({
      title:data[i].title,
      subtitle:data[i].channel
    });
  }
  return items;
};

//download timetable
var URL ='http://halka.me/now_abema_json.php';
ajax(
  {
    url: URL,
    type: 'json'
  },
  function(data) {
    // Success!
    var resultMenu = new UI.Menu({
    sections: [{
    title: 'Now On Air!',
    items: programs(data)
  }]
});
   card.hide();
   resultMenu.show();
  },
  function(error) {
    // Failure!
    console.log('Failed fetching data: ' + error);
  }
);