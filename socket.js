var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(6001, function() {
    console.log('Server is running!');
});

io.on('connection', function(socket) {
    var redisClient = redis.createClient();
    redisClient.auth('43900abb77351b7fc4a920201b687eebf9015cc4adfa4449e5a6bc6a131a0a46');
  	redisClient.subscribe('message');

  	redisClient.on("message", function(channel, data) {
	    socket.emit(channel, data);
	  });

  	socket.on('disconnect', function() {
	    redisClient.quit();
	  });
});