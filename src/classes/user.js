// info = {username, email}
function newUser(info) {
    console.log('writing');
    fire_DB.ref('users').push(info);
}

function getAllUsers(callback) {
    firebase.database().ref('/users').once('value').then(function(snapshot) {
        callback(snapshot.val());
    });
}

var xhhUser = function() {

}
