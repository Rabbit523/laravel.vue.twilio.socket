var http = require('http');
var express = require('express');
var app = express();
var ws = require('ws');
var server = http.createServer(app);
var port = 8081;
server.listen(port);

var wss = new ws.Server({
  server: server,
  path: '/one2one'
});

wss.getUniqueID = function () {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
  }
  return s4() + s4() + '-' + s4();
};
var users = [];
var subscriptions = [];

wss.on('connection', function (ws) {
  ws.id = wss.getUniqueID();
  users[ws.id] = ws;

  ws.on('error', function (error) {
    console.log('an error' + error);
    ws.close();
  });

  ws.on('close', function () {
    $message = {id: subscriptions[ws.id], status: "Offline", type: 'status' };
    if (subscriptions[ws.id]) {
      for (var key in subscriptions) {
        if (subscriptions[key] != subscriptions[ws.id]) {
          users[key].send(JSON.stringify($message));
        }
      }
    }
    delete users[ws.id];
    delete subscriptions[ws.id];
  });

  ws.on('message', function (msg) {
    var _message = JSON.parse(msg);
    if (_message.command == "subscribe") {
      subscriptions[ws.id] = _message.channel;
      $message = {id: subscriptions[ws.id], status: "Available", type: "status" };
      for (var key in subscriptions) {
        if (subscriptions[key] != subscriptions[ws.id]) {
          users[key].send(JSON.stringify($message));
        }
      }
    } else if (_message.command == "message") {
      if (_message.type == 'status') {
        $message = {id: _message.id, status: _message.msg, type: 'status' };
        for (var key in subscriptions) {
          if (subscriptions[key] != _message.id) {
            users[key].send(JSON.stringify($message));
          }
        }
      } else if (_message.type == 'request') {
          $message = { 
            type: _message.type,
            sub_type: _message.sub_type,
            id: _message.customer_id,
            name: _message.customer_name,
            min: _message.min,
            image: _message.img
          };
        for (var key in subscriptions) {
          if (subscriptions[key] == _message.id) {
            users[key].send(JSON.stringify($message));
          }
        }
      } else { 
        $message = {token: _message.token, type: "token" };
        for (var key in subscriptions) {
          if (subscriptions[key] == _message.channel) {
            users[key].send(JSON.stringify($message));
          }
        }
      }
    }
  });
});