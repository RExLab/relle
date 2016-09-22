/* global require */

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

config = {timeslice: 20000,
    nUsersMax: 3};

http.listen(3000, function () {
    console.log('listening on *:3000');


});

var rooms = [
    {name: "arara_azul",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "baleia_franca_do_sul",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "borboleta_da_praia",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "cervo_do_pantanal",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "gato_maracaja",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "lobo_guara",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "macaco_aranha",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "mico_leao_dourado",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "onca_pintada",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    },
    {name: "sapo_folha",
        nUsers: 0,
        Users: [],
        active: -1,
        interval: 0,
        list: []
    }


];

/*
 var User = {username: '',
 avatar: "max",
 id: 0,
 commands: [1, 2]
 }; */

io.on('connection', function (socket) {
    socket.joined = false;
    var availroom = refresh_rooms();
    socket.emit('available rooms', availroom);


    socket.on('users joined', function (data) {
        if (socket.joined) {
            var users = rooms[socket.indexRoom].Users;
            console.log(users);
            //socket.emit('user joined', users);
        }
    });

    socket.on('leave room', function (data) {
        if (socket.joined) {
            console.log('leaving room' + data);
            rooms[socket.indexRoom].nUsers--;
            if (rooms[socket.indexRoom].nUsers > 0) {
                rooms[socket.indexRoom].Users.splice(socket.user.id, 1);
            } else {
                clearRoom(rooms[socket.indexRoom]);
            }
            socket.leave(rooms[socket.indexRoom].name);
            socket.joined = false;
            availroom = refresh_rooms();
            socket.broadcast.emit('available rooms', availroom);
        }
    });

    socket.on('new connection', function (data) {
        socket.user = data.user;
        socket.indexRoom = availroom.name.indexOf(data.selectedRoom);

        if (socket.indexRoom >= 0) {
            if (rooms[socket.indexRoom].nUsers < 3 && rooms[socket.indexRoom].active < 0) {
                handle_new_user(socket);
                availroom = refresh_rooms();
                socket.broadcast.emit('available rooms', availroom);
            }

        } else {
            console.log(socket.user + ' has not joined');
        }

    });

    socket.on('disconnect', function () {
        if (socket.joined) {
            var room = rooms[socket.indexRoom];
            if (room.active >= 0) {
                if (typeof (room.setTimeout) !== 'undefined') {
                    clearTimeout(room.setTimeout);
                    clearInterval(room.interval);
                }
                 room.nUsers--;
                if (room.nUsers > 0) { 
                    
                    handle_user_disconnected(socket);
                    room.interval = setInterval(function () {
                        ChangeRoundwPreemption(room);
                    }, config.timeslice);
                } else {
                    clearRoom(room);
                }
            } else {
                room.nUsers--;
                if (room.nUsers > 0) {
                    handle_user_disconnected2(socket);
                } else {
                    clearRoom(room);
                }
            }
            socket.leave(room.name);
            availroom = refresh_rooms();
            socket.broadcast.emit('available rooms', availroom);
            io.sockets.in(room.name).emit('user disconnected', room.Users);
        }
        console.log(socket.user + ' has disconnected');
    });


    socket.on('move', function (data) {
        if (socket.joined) {
            room = rooms[socket.indexRoom];
            if (room.Users[room.active].username === socket.user.username) {
                console.log(data);
                socket.broadcast.to(room.name).emit('move', data);
                clearTimeout(room.setTimeout);
                clearInterval(room.interval);
                room.list = data;
                room.active = (++room.active) % room.nUsers;
                ChangeRound(room);
                room.interval = setInterval(function () {
                    ChangeRoundwPreemption(room);
                }, config.timeslice);
            }
        }
    });

});

function refresh_rooms() {
    var array = {};
    array.name = [];
    array.nUsers = [];
    for (var i = 0; i < rooms.length; i++) {
        if (rooms[i].nUsers < config.nUsersMax) {
            array.name.push(rooms[i].name);
            array.nUsers.push(rooms[i].nUsers);
        }
    }
    console.log(array.name);
    console.log(array.nUsers);
    return array;
}


function handle_user_disconnected2(socket) {
    var room = rooms[socket.indexRoom];
    var index = 0;

    for (var i = 0; i < config.nUsersMax; i++) {
        if (typeof (room.Users[i]) !== 'undefined') {
            if (room.Users[i].username !== socket.user.username) {
                room.Users[i].commands = [2 * index, 2 * index + 1];
                room.Users[i].id = index++;
            } else {
                room.Users.splice(i, 1);
            }
        }
    }

}

function handle_user_disconnected(socket) {
    var room = rooms[socket.indexRoom];
    var index = 0;
    var commands = room.Users.filter(function (obj) {
        return obj.username === socket.user.username;
    })[0].commands;

    for (var i = 0; i < config.nUsersMax; i++) {
        if (typeof (room.Users[i]) !== 'undefined') {
            if (room.Users[i].username !== socket.user.username) {
                room.Users[i].id = index++;
                if (room.nUsers === 2) {
                    room.Users[i].commands.push(commands.pop());
                } else if (room.nUsers === 1) {
                    room.Users[i].commands = room.Users[i].commands.concat(commands);
                }
            } else {
                if (room.active === room.Users[i].id) {
                    room.active = (++room.active) % room.nUsers;
                    ChangeRound(room);
                }
                room.Users.splice(i, 1);
            }
        }
    }
   
    // Tratar caso em que o usuário desconectado tinha a vez
}

function clearRoom(room) {
    room.active = -1;
    room.Users = [];
    room.list = [];
    room.nUsers = 0;
    room.interval = 0;
}

function handle_new_user(socket) {
    var room = rooms[socket.indexRoom];
    socket.join(room.name);
    var i = room.nUsers++;
    socket.user.id = i;
    socket.user.group = room.name;
    socket.user.commands = [2 * i, 2 * i + 1];
    room.Users.push(socket.user);
    socket.joined = true;
    socket.to(room.name).emit('user joined', socket.user);
    socket.emit('user joined',room.Users);
    if (room.nUsers > 2) {
        //io.sockets.in(room.name).emit('start',null);
        room.active = (++room.active) % room.nUsers;
        ChangeRound(room);
        room.interval = setInterval(function () {
            ChangeRoundwPreemption(room);
        }, config.timeslice);
    }
}


function ChangeRound(room) {

    console.log(room.active);
    var user = room.Users[room.active];
    if (user !== 'undefined') {
        io.sockets.in(room.name).emit('changeround', user);
    }

}

function ChangeRoundwPreemption(room) {
    var user = room.Users[room.active];
    io.sockets.in(room.name).emit('preemption', user);

    room.setTimeout = setTimeout(
            function () {
                clearInterval(room.interval);
                io.sockets.in(room.name).emit('move', room.list);
                room.active = (++room.active) % room.nUsers;
                ChangeRound(room);
                room.interval = setInterval(function () {
                    ChangeRoundwPreemption(room);
                }, config.timeslice);

            }, config.timeslice / 2);
}
